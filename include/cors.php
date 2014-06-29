<?php
// Setup CORS to permit cross-domain JSON XHR
$app->hook('slim.before.dispatch', function () use ($app) {
  $headers = $app->response->headers;
  $headers->set('Content-Type', 'application/json');
  $headers->set('Access-Control-Allow-Origin', '*');
  $headers->set('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
  $headers->set('Access-Control-Max-Age', '1000');
  $headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
});
?>
