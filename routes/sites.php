<?php
$sites = new sitesCtrl();

$app->get('/site/:id', function ($id) use ($sites, $app) {
    $data = $sites->getSiteBySevOneDeviceId($id);
    $app->response->write($data);
});

?>
