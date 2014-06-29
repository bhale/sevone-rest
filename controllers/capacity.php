<?php

class capacityCtrl {

  function __construct() {
    $this->soap = new SevOneSOAP();
    $this->equipment = new Equipment();
  }

  function add() {
    $post = json_decode(file_get_contents("php://input"), true);

    $device_id = $post['interface']['deviceId'];
    $object_id = $post['interface']['id'];
    $plugin_string = $post['interface']['pluginString'];

    $businessUnits = $post['businessUnits'];

    foreach ($businessUnits as $businessUnit) {
      $group_id = $businessUnit['id'];
      $name = $businessUnit['name'];
      $this->soap->client->group_addObjectToGroup($device_id, $object_id, $group_id, $plugin_string);
    }
  }

  function getDevicesBySite() {
    // Return a nested array with site->device->interface for WAN interfaces
    // Include Business Unit affiliations for devices that match the GITSM Equipment table
    $sites = array();

    $equipment = $this->equipment->getEquipment(); // All equipment with business unit affiliation from the GITSM DB
    $groups = $this->getCapacityObjectGroups(); // Object groups under the Capacity Planning class, with child objects
    $interfaces = $this->getInterfaceObjects(); // All suspected WAN objects (from 'WAN Interface' object group)
    $devices = $this->soap->client->group_getDevicesByGroupId(5);  // All the WAN devices from SevOne

    foreach ($devices as $device) {
      if(!isset($device->envcode)) {
        $device->envcode = "No Database Match";
      }

      $sites[$device->envcode]['businessUnits'] = array();

      // If we find a match for the device in the Network Database,
      // record its envcode and businessUnits in our object
      if (array_key_exists($device->ip, $equipment)) {

        $businessUnits = $equipment[$device->ip]['business_units'];

        // Lookup the objectGroupId to match this business unit in SevOne
        foreach ($businessUnits as $businessUnit) {
          $groupId = $this->soap->client->group_getObjectGroupIdByName("Capacity Planning", $businessUnit);
          array_push($sites[$device->envcode]['businessUnits'], array("name" => $businessUnit, "id" => $groupId));
        }

        $device->envcode = $equipment[$device->ip]['envcode'];

      } else {
        $device->envcode = "No Database Match";
      }

      // Find interfaces matching this device id and assign them to our device object.
      $device->interfaces = array();
      foreach ($interfaces as $interface) {
        if ($interface->deviceId == $device->id) {

          // Find out if this interface already exists in a relevant object group
          // Add array of existing group memberships to the interface object
          // Drop matched object at the end so we don't have to check it again
          $interface->currentGroups = array();

          foreach ($groups as $group) {
            foreach ($group['objects'] as $object_key => $object) {
              if ($object->id == $interface->id) {
                $interface->ip = $object->ip;
                array_push($interface->currentGroups, array("id" => $group['id'], "name" => $group['name']));
                unset($group['objects'][$object_key]);
              }
            }
          }
          array_push($device->interfaces, $interface);
        }
      }

      // Push the device object into an array sorted by site name
      $sites[$device->envcode]['envcode'] = $device->envcode;
      $sites[$device->envcode]['devices'][] = $device;
    }

    // We have to drop the array keys on the sites array for better JSON conversion.
    // We needed them up front to get devices grouped properly by site as we iterate the devices
    $json_sites = array();
    foreach ($sites as $site) {
      array_push($json_sites, $site);
    }
    return json_encode($json_sites);
  }

  function getCapacityObjectGroups() {
    // Retrieve the object groups relevant for capacity planning report
    $groups = array();
    $objectGroups = $this->soap->client->group_getObjectGroupsByClassId(87);

    // For each object group, populate an array with the objects already in that group.
    foreach ($objectGroups as $group) {
      $groups[$group->id]['id'] = $group->id;
      $groups[$group->id]['name'] = $group->name;
      $groups[$group->id]['objects'] = $this->soap->client->plugin_snmp_getObjectsByObjectGroupId($group->id);
    }
    return $groups;
  }

  function getInterfaceObjects() {
    // Get all objects (known interfaces) in the WAN Interfaces group for comparison
    $limit = 5000;
    $start = 0;
    $filters = $this->soap->client->factory_ObjectFilter();
    $filters->objectGroupIds = array("61");
    $interfaces = $this->soap->client->core_getObjectsWithFilter( $limit, $start, $filters );
    return $interfaces;
  }
}
?>
