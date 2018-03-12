<?php

try {
    Core::init();
} catch (Exception $e) {
    Core::error($e);
}

/**
 * Classe que principal do sistema
 */

class Core
{

    private static $execution_time_start;

    public static function init()
    {
        Core::$execution_time_start = microtime(true);
        // Carrega as classes necessárias do sistema
        Loader::system('ActiveRecord');        
        Loader::system('BaseDAO');
        Loader::system('BaseModel');
        Loader::system('BaseController');
        //Carrega as configurações do banco
        Loader::config('db');
        if (USE_ROUTES) {
            // Maneira Laravel de acessar as controllers por routes
            Loader::system('Router');
            Loader::config('routes');
            $request = Router::getRequest(Core::requestArray(), Core::getURI(true));
            if ($request) {
                Core::callController($request->controller, $request->method, $request->args);
            } else {
                $file = VIEW_FOLDER.'/' . substr(Core::getURI(), 1);
                Loader::file($file);
            }
        } else {
            // Maneira codeigniter de acessar as controllers
            $request = Core::requestArray();
            Core::callController($request->controller, $request->method, $request->args);
        }
    }

    public static function getURI($as_array = false)
    {
        $current_uri = $_SERVER['REQUEST_URI'];
        if (substr($current_uri, 0, strlen('/' . BASE_PATH)) == '/' . BASE_PATH) {
            $current_uri = substr($current_uri, strlen('/' . BASE_PATH));
        }

        $uri_as_string = str_replace(array('index.php', '//'), array('', '/'), $current_uri);

        if ($as_array) {
            return array_filter(explode('/', $uri_as_string));
        } else {
            return $uri_as_string;
        }
    }

    public static function requestArray()
    {
        $request = new StdClass();
        $params = array_filter(explode('/', Core::getURI()));
        $request->controller = ucfirst(array_shift($params) ?: 'DefaultController');
        $request->method = array_shift($params) ?: 'index';
        $request->args = $params;
        $request->type = $_SERVER['REQUEST_METHOD'];
        return $request;
    }

    public static function callController($controller, $method, $args)
    {
        if (file_exists(CONTROLLER_FOLDER . "/{$controller}.php")) {
            require_once CONTROLLER_FOLDER . "/{$controller}.php";
            if (class_exists($controller)) {
                if (method_exists($controller, $method)) {
                    try {
                        $controllerObj = new $controller();
                        $controllerObj->{$method}($args);
                    } catch (Exception $ex) {
                        Core::error($ex);
                    }
                } else {
                    Loader::view('messages/aviso', array('tipo' => 'danger', 'msg' => "Método {$method} não existe na classe {$controller}."), 404);
                }
            } else {
                Loader::view('messages/aviso', array('tipo' => 'danger', 'msg' => "Classe {$controller} não existe."), 501);
            }
        } else {
            Loader::view('messages/aviso', array('tipo' => 'danger', 'msg' => "Controller {$controller}.php não encontrada."), 500);
        }
    }

    public static function error($ex, $status = 500)
    {
        http_response_code($status);
        Loader::view('messages/error', array('tipo' => 'danger', 'ex' => $ex));
    }

    public static function getExecutionTime($precision = 3)
    {
        $decorrido_segundos = microtime(true) - self::$execution_time_start;
        $decorrido_segundos_formatado = number_format($decorrido_segundos, $precision);
        return rtrim($decorrido_segundos_formatado, '0');
    }
}