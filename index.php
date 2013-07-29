<?php
require 'App.php';

$app = new App();

// GET route
$app->get('/', function () use($app) {
    $app->render('base', array(
        'name' => 'Visioncan'
    ));
});

$app->run();
?>