<?php

/**
 * Classe que cuida das rotas do sistema
 */
class Router
{
    private static $routes = array();
    
    private function __construct() { }

    public static function getRequest($request, $url_array)
    {
        $ret = false;
        self::orderRoutes();
        foreach (self::$routes as $route) {
            if (Router::compareUrls($url_array, $route->url_array) && $route->type == $request->type) {
                $ret = new StdClass();
                $ret->controller = $route->controller;
                $ret->method = $route->method;
                $ret->args = Router::buildParams($url_array, $route->url_array);
                $ret->args = array_merge($ret->args, $route->hidden_args);
                break;
            }
        }
        return $ret;
    }

    private static function orderRoutes()
    {
        $count_params = array();
        $count_params_vars = array();
        $count_vars = 0;    
        foreach (self::$routes as $key => $value) {
            $count_params[$key] = count($value->url_array);
            foreach ($value->url_array as $param) {
                if (mb_substr($param, 0, 1) == ':') {
                    $count_vars++;
                }
            }
            $count_params_vars[$key] = $count_vars;
        }
        array_multisort($count_params, SORT_ASC, $count_params_vars, SORT_ASC, self::$routes);
    }

    public static function get($url, $controller, $method)
    {
        self::cadastrarRoute($url, $controller, $method, 'GET');
    }

    public static function post($url, $controller, $method)
    {
        self::cadastrarRoute($url, $controller, $method, 'POST');
    }

    public static function group($base_url, $controller, $routes)
    {
        foreach ($routes as $key => $value) {
            self::cadastrarRoute($base_url . $value[1], $controller, $value[2], $value[0]);
        }
    }

    public static function cadastrarRoute($url, $controller, $method, $type, $hidden_args = array())
    {
        $obj = new StdClass();
        $obj->url = $url;
        $obj->type = strtoupper($type);
        $obj->controller = $controller;
        $obj->method = $method;
        $obj->url_array = array_filter(explode('/', $url));
        $obj->hidden_args = $hidden_args;
        self::$routes[] = $obj;
    }

    public static function compareUrls($url1, $url2)
    {
        $match = false;
        $cont = count($url1);
        $compare = $cont == count($url2);
        if ($compare) {
            $match = true;
            foreach ($url1 as $key => $value) {
                if (!($url1[$key] == $url2[$key])) {
                    if (!(mb_substr($url1[$key], 0, 1) == ':' || mb_substr($url2[$key], 0, 1) == ':')) {
                        $match = false;
                    }
                }
            }
        }
        return $match;
    }

    public static function buildParams($url_acessada, $url_route)
    {
        $ret = array();
        foreach ($url_route as $key => $request) {
            if (mb_substr($request, 0, 1) == ':') {
                $new_key = str_replace(':', '', $request);
                $ret[$new_key] = str_replace($request, $url_acessada[$key], $request);
            }
        }
        return $ret;
    }

    public static function getRequestHeaders()
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) != 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

    public static function redirect($address, $timeout = 0, $kill = true)
    {
        $address = URL_BASE.$address;
        $timeout = $timeout < 0 ? 0 : $timeout;
        if ($timeout == 0) {
            header("Location: ${address}");
            echo "<script type=\"text/javascript\">window.location.href = '${address}';</script>";
        } else {
            header("Refresh:${timeout}; url=${address}");
            echo "setTimeout(\"location.href = 'https://www.quackit.com';\",1500);";
        }
        echo "<meta http-equiv=\"refresh\" content=\"${timeout};url=${address}\"/>";
        if ($kill) die("Redirecionando...");
    }

}