<?php
// Routes

$app->get('/', function ($request, $response, $args) {

    $this->logger->info("Pond '/' route");

    return $this->renderer->render($response, 'index.phtml', $args);
});
