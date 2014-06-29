<?php
$app->get('/', function () use ($app) {
  renderMarkdown("index.md", $app);
});
?>
