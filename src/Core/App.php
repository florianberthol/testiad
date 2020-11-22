<?php
namespace Core;

use Controller\Chat;
use Controller\User;

class App
{
    private $router;
    private $request;
    private $session;

    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->session = new Session();
    }

    public function run()
    {
        $this->appConfig();
        $callable = $this->router->route($this->request);
        if ($callable) {
            try {
                call_user_func($callable);
            } catch (\Exception $e) {
                http_response_code(500);
                die ("Une erreur est survenue");
            }

        }
    }

    protected function appConfig()
    {
        DB::initConf('tchat', 'localhost', 'root', '');

        $appRequest = $this->request;
        $appSession = $this->session;

        // Routes
        $this->router->get('/', function () use ($appRequest, $appSession) {
            $controller = new User();
            $controller->index($appRequest, $appSession);
        });

        $this->router->post('/login', function () use ($appRequest, $appSession) {
            $controller = new User();
            $controller->login($appRequest, $appSession);
        });

        $this->router->get('/chat', function () use ($appSession) {
            $controller = new Chat();
            $controller->index($appSession);
        });

        $this->router->post('/post', function () use ($appRequest, $appSession) {
            $controller = new Chat();
            $controller->post($appRequest, $appSession);
        });
    }
}