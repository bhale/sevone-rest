<?php

class sitesCtrl {

  function __construct() {
    $this->soap = new SevOneSOAP();
    $this->sites = new Sites();
    $this->equipment = new Equipment();
  }

  function getSiteBySevOneDeviceId($id) {
    $device = $this->soap->client->core_getDeviceById($id);
    $site = $this->sites->getSiteByIp($device->ip);
    $site['EquipmentComponent'] = $this->equipment->getEquipmentComponentByHostname($site['Hostname']);
    return json_encode($site);
  }

  function test() {
    $data = $this->sites->getTest();
    return json_encode($data);
  }
}
?>
