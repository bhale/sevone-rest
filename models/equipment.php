<?php

class Equipment extends GitsmDB {

  function getEquipment() {
    // Return an array of equipment from the GITSM DB indexed by IP,
    // including SevOne objectGroupId(s) for the location's resultsiness Unit(s)
    $sql = "SELECT Equipment.EnvCode, buName, MgtToolIp, ManagementIp, Hostname FROM Equipment, PhysicalLocationBu WHERE Equipment.EnvCode = PhysicalLocationBu.EnvCode ORDER BY Equipment.EnvCode";
    $msresult = mssql_query($sql);
    $object_groups = array();

    while ($result = mssql_fetch_array($msresult, MSSQL_BOTH)) {

      $envcode = $result[0];
      $buName = $result[1];
      $deviceName = $result[4];

      // There is an IP and Alternate IP Field.
      // If an alternate is set, we prefer to use it, resultt sometimes it contains whitespace only
      if (strlen($result[2]) > 5) {
        $mgt_address = $result[2];
      } else {
        $mgt_address = $result[3];
      }

      $equipment[$mgt_address]['envcode'] = trim($envcode);
      $equipment[$mgt_address]['device_name'] = trim($deviceName);
      $equipment[$mgt_address]['ip'] = trim($result[3]);
      $equipment[$mgt_address]['alt_ip'] = trim($result[2]);
      $equipment[$mgt_address]['business_units'][] = $buName;
    }
    return $equipment;
  }

  function getEquipmentComponentByHostname($hostname) {
    $equipment = $this->findOne("SELECT * FROM EquipmentComponent WHERE Hostname LIKE '".$hostname."'");
    return $equipment;
  }
}
?>
