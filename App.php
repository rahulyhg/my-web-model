<?php
require 'vendor/autoload.php';
require_once 'config/config_db.php';
require_once 'config/config_app.php';

use Slim\Slim;
use Slim\Extras\Views\Mustache as Mustache;
Mustache::$mustacheDirectory = 'vendor/mustache/mustache/src/Mustache';

ORM::configure("mysql:host=DB_HOST;dbname=DB_NAME");
ORM::configure('username', DB_USER);
ORM::configure('password', DB_PASSWORD);
ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

class App {
	private $templates, $template_path;
	public $slim;

	public function __construct(){
		$this->slim = new Slim(array(
			'debug' => DEBUG,
			'view' => new Mustache(array(
				'template_class_prefix' => '_tpl_',
				'cache' => dirname(__FILE__).'/views/cache',
				'cache_file_mode' => 0666,
				'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views'),
				'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/views/partials'),
			))
		));
		// $this->template_path = TEMPLATE_ROOT;
		// $this->templates = $this->_get_templates(TEMPLATE_ROOT); //TODO: Cache in Memcache
	}

	public function render($view, $data = array(), $contentType = 'html') {
		$defaults = array(
			'DOC_TITLE' => META_TITLE,
			'DOC_AUTHOR' => META_AUTHOR,
			'DOC_KEYWORDS' => META_KEYWORDS,
			'DOC_DESCRIPTION' => META_DESCRIPTION,
			'GOOGLE_ANALYTICS_ID' => GOOGLE_ANALYTICS_ID,
		);
		
		$data = array_merge($defaults, $data);
		
		if($contentType === 'html') {
			return $this->slim->render($view, $data);
		} else if ($contentType === 'json') {
			$this->slim->response()->header('Content-Type', 'application/json');
			return json_encode($data);
		}
	}
	
	public function get($route, $callback){
		return $this->slim->get($route, $callback);
	}
	
	public function post($route, $callback){
		return $this->slim->post($route, $callback);
	}
	
	public function run(){
		$this->slim->run();
	}
}
?>