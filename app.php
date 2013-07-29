<?php
require 'vendor/autoload.php';
require_once 'config/config_db.php';
require_once 'config/config_app.php';

ORM::configure("mysql:host=DB_HOST;dbname=DB_NAME");
ORM::configure('username', DB_USER);
ORM::configure('password', DB_PASSWORD);
ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
?>