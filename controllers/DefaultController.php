<?php

/**
 * Controller Default
 */
class DefaultController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Loader::model('DefaultModel');
    }

    public static function index($params)
    {
    	$model = new DefaultModel();
    	var_dump($model->teste());
        Loader::view('messages/aviso', array('tipo' => 'info', 'msg' => 'Consulte a documentação.'));
    }

}