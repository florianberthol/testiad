<?php
namespace Core;


class Request
{
    private $get;
    private $post;
    private $server;
    private $cookie;
    private $routeParameters;

    public function __construct()
    {
        $this->get = $this->init($_GET);
        $this->post = $this->init($_POST);
        $this->server = $this->init($_SERVER);
        $this->cookie = $this->init($_COOKIE);
        $this->routeParameters = null;
    }

    /**
     * Get $_GET vars
     *
     * @param string $var
     * @return mixed|null
     */
    public function getGet(string $var): ?string
    {
        return $this->getVar($this->get, $var);
    }

    /**
     * Get $_POST vars
     *
     * @param string $var
     * @return mixed|null
     */
    public function getPost(string $var): ?string
    {
        return $this->getVar($this->post, $var);
    }

    /**
     * Get $_SERVER vars
     *
     * @param string $var
     * @return mixed|null
     */
    public function getServer(string $var): ?string
    {
        return $this->getVar($this->server, $var);
    }

    /**
     * Get $_COOKIE vars
     *
     * @param string $var
     * @return mixed|null
     */
    public function getCookie(string $var): ?string
    {
        return $this->getVar($this->cookie, $var);
    }

    public function setRouteParameters(array $params)
    {
        $this->routeParameters = $params;
    }

    public function getRouteParameters(): ?array
    {
        return $this->routeParameters;
    }

    /**
     * Get var or null if don't exist
     *
     * @param array $var
     * @param string $name
     * @return mixed|null
     */
    protected function getVar(array $var, string $name): ?string
    {
        if (isset($var[$name])) {
            return $var[$name];
        }

        return null;
    }

    /**
     * @param array $datas
     * @return array
     */
    protected function init(array $datas): array
    {
        $cleanData = [];
        foreach ($datas as $key => $data) {
            $cleanData[strtolower($key)] = addslashes($data);
        }

        return $cleanData;
    }
}