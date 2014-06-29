<?php
$alerts = new alertsCtrl();

$app->get('/alerts', function () use ($alerts) {
  $app->response->write($alerts->getAlerts(0););
});
?>
