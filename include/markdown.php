<?php
use \Michelf\Markdown;

function renderMarkdown($template, $app) {
  $doc = file_get_contents("./views/" . $template);
  $app->response->headers->set('Content-Type', 'text/html');
  $html = Markdown::defaultTransform($doc);
  $app->response->write($html);
}
?>
