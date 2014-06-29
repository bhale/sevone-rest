<?php
$devices = new devicesCtrl();

$app->get('/devices', function () use ($devices, $app) {
  $app->response->write($devices->getDevices());
});
?>
