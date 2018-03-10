<?php

define('BASEPATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('APPPATH', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR);
define('ENVIRONMENT', DB_ENV);

Loader::system('CI_Common');
Loader::system('database/DB');

class ActiveRecord
{
	private static $db_configs = array();	
	private static $instances = array();

	public static function addEnv($environment, $configs)
	{
		self::$db_configs[$environment] = $configs;
	}

	public static function getInstance($environment = DB_ENV) {

		$config = array_key_exists($environment, self::$db_configs) ? self::$db_configs[$environment] : NULL;

		if (empty($config)) {
			return $config;
		}

		$pw = !empty($config['password']) ? ':'.$config['password'] : '';
		$instance = $config['driver'].'://'.$config['username'].$pw.'@'.$config['host'].'/'.$config['database'];

		if (!isset(self::$instances[$instance])) {
			self::$instances[$instance] =& DB($instance);
		}

		return self::$instances[$instance];
	}
}