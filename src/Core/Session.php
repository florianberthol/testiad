<?php
namespace Core;


class Session
{
    /**
     * @param string $name
     * @param string $data
     */
    public function set(string $name, string $data)
    {
        $_SESSION[$name] = $data;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function get(string $name): ?string
    {
        if (isset($_SESSION[$name])) {
            return htmlentities($_SESSION[$name]);
        }

        return null;
    }

    /**
     * @param string $name
     */
    public function delete(string $name)
    {
        unset($_SESSION[$name]);
    }
}