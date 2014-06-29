<?php

class sitesCtrl {

  function __construct() {
    $this->soap = new SevOneSOAP();
    $this->sites = new Sites();
  }

  function getSiteBySevOneDeviceId($id) {
    $device = $this->soap->client->core_getDeviceById($id);
    $site = $this->sites->getSiteByIp($device->ip);
    return json_encode($site);
  }
}
?>
