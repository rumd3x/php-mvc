<?php

if (!function_exists('http_response_code')) {
    function http_response_code($status_code) {
        header("HTTP/1.0 $status_code");
    }
}

/**
 * Classe que carrega as coisas
 */
class Loader
{
    /**
     * Função que carrega os arquivos na tela
     */
    public static function view($file, $vars = array(), $http_status = 200)
    {
        if (is_int($vars)) {
            $http_status = $vars;
            $vars = array();
        }
        foreach ($vars as $varname => $varval) {
            ${$varname} = $varval;
        }
        http_response_code($http_status);
        header('Content-Type: text/html; charset=utf-8');
        include VIEW_FOLDER . "/{$file}.php";
        echo '<input type="hidden" id="URL_BASE" value="' . URL_BASE . '" />';
    }

    public static function utilize($folder, $file)
    {
        $file = $file;
        require_once "{$folder}/{$file}.php";
    }

    public static function system($file)
    {
        Loader::utilize(SYSTEM_FOLDER, $file);
    }

    public static function model($file)
    {
        Loader::utilize(MODELS_FOLDER, ucfirst($file));
    }

    public static function config($file)
    {
        Loader::utilize(CONFIG_FOLDER, $file);
    }
    
    public static function file($file)
    {
        if (file_exists($file)) {
            http_response_code(200);
            $pathinfo = pathinfo($file);
            switch (strtolower($pathinfo['extension'])) {
                case 'js':
                    header('Content-type: text/javascript');
                    break;
                case 'css':
                    header('Content-type: text/css');
                    break;
                case 'json':
                    header('Content-type: application/json');
                    break;
                default:
                    header('Content-type: text/plain');
                    break;
            }
            echo file_get_contents($file);
        } else {
            Loader::view('messages/aviso', array('tipo' => 'danger', 'msg' => 'Rota não cadastrada.'), 404);
        }
    }

    public static function response($var, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($var);
    }

}