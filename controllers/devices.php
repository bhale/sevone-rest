<?php
class devicesCtrl {

  function __construct() {
    $this->soap = new SevOneSOAP();
  }

  function getDevices() {
    $devices = $this->soap->client->core_getDevices();
    return json_encode($devices);
  }
}
?>
