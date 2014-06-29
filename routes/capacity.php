<?php
$capacity = new capacityCtrl();

$app->get('/capacity', function () use ($capacity, $app) {
    $data = $capacity->getDevicesBySite();
	  $app->response->write($data);
});

$app->post('/capacity', function () use ($capacity) {
    $capacity->add();
});

$app->delete('/capacity/:id', function () use ($capacity) {
    $capacity->delete($id);
});
?>
