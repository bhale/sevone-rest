<?php
$alerts = new alertsCtrl();

$app->get('/alerts', function () use ($alerts) {
  $alerts = $alerts->getAlerts(0);
  $app->response->write($alerts);
});
?>
