<?php

/**
 * Controller Default
 */
class ExampleController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Loader::model('ExampleModel');
    }

    public static function index($params)
    {
    	$model = new ExampleModel();
        Loader::view('messages/aviso', array('tipo' => 'info', 'msg' => "Demorou: ".Core::getExecutionTime()." segundos."));
    }

}