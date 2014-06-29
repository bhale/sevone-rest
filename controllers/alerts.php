<?php
class alertsCtrl {

  function __construct() {
    $this->soap = new SevOneSOAP();
  }

  function getAlerts($cleared) {
    // Return alerts with associated devices
    $alerts = $this->soap->client->alert_getAlerts($cleared);
    $devices = $this->soap->client->core_getDevices();

    foreach ($alerts as $alert) {
      foreach ($devices as $device) {
        if ($device->id == $alert->deviceId) {
          $alert->device = $device;
        }
      }
    }
    return json_encode($alerts);
  }
}
?>
