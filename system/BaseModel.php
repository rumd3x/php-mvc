<?php 
	/**
	 * Classe de Modelo base
	 */
	abstract class Model extends StdClass
	{
		protected $dao;		
	    public abstract function __construct();
	}
?>