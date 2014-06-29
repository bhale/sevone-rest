<?php
$devices = new devicesCtrl();

$app->get('/devices', function () use ($devices, $app) {
  $app->response->write($devices->getDevices());
});

$app->get('/device/:id', function ($id) use ($devices, $app) {
  $app->response->write($devices->getDeviceById($id));
});
?>
