<?php
namespace Core;

class Router
{
    private const POST = 'POST';
    private const GET = 'GET';
    public const PARAMS_CONTROLLER = 'controller';
    public const PARAMS_ACTION = 'action';

    /** @var array  */
    private $routes = [];
    /** @var Request  */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * register post route
     *
     * @param string $uri
     * @param array $params
     */
    public function post(string $uri, callable $callable)
    {
        $this->routes[self::POST][$uri] = $callable;
    }

    /**
     * register get route
     *
     * @param string $uri
     * @param array $params
     */
    public function get(string $uri, callable $callable)
    {
        $this->routes[self::GET][$uri] = $callable;
    }

    /**
     * Check if all needed parameters are given
     *
     * @param array $params
     * @return bool
     */
    private function checkParams(array $params)
    {
        if (isset($params[self::PARAMS_ACTION]) && isset($params[self::PARAMS_CONTROLLER])) {
            return true;
        }

        return false;
    }

    public function route(): ?callable
    {
        $uri = strtok($this->request->getServer('request_uri'), '?');
        $method = $this->request->getServer('request_method');

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUri => $callable) {
                $pattern = '#^' . $routeUri . '$#';
                if (preg_match($pattern, $uri, $match)) {
                    $this->request->setRouteParameters($match);
                    return $callable;
                }
            }
        }

        http_response_code(404);
        return null;
    }
}