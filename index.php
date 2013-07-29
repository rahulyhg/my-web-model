<?php
require 'app.php';

use Slim\Slim;
use Slim\Extras\Views\Mustache as Mustache;

Mustache::$mustacheDirectory = 'vendor/mustache/mustache/src/Mustache';

$app = new Slim(array(
	'debug' => true,
    'view' => new Mustache(array(
    	'template_class_prefix' => '_tpl_',
    	'cache' => dirname(__FILE__).'/views/cache',
    	'cache_file_mode' => 0666,
    	'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views'),
    	'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views/partials'),
    ))
));

// GET route
$app->get('/', function () use($app) {
     $app->render('base', array(
     		'name' => 'Visioncan'
     	));
});

$app->run();
?>