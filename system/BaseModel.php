<?php 
	/**
	 * Classe de Modelo base
	 */
	abstract class Model extends StdClass
	{
		protected $dao;		
	    public abstract function __construct();

	    public static function _isStatic() {
	        $backtrace = debug_backtrace();
	        return $backtrace[1]['type'] == '::';
	    }
	}
?>