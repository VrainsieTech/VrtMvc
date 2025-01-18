<?php

namespace Vrainsietech\Vrtmvc\Http;

class Request
{
    private $getParams = [];
    private $postParams = [];
    private $serverParams = [];
    private $files = [];
    private $attributes = [];

    function __construct()
    {
        $this->getParams = $_GET;
        $this->postParams = $_POST;
        $this->serverParams = $_SERVER;
        $this->files = $_FILES;
    }

    function getMethod()
    {
        return strtolower($this->serverParams['REQUEST_METHOD']);
    }

    function getUri()
    {
        return strtok($this->serverParams['REQUEST_URI'], '?'); // Remove query string
    }

    function getPath()
    {
        $uri = $this->getUri();

        // Remove the base path if set (e.g., if the app is in a subdirectory)
        $basePath = parse_url($this->serverParams['SCRIPT_NAME'], PHP_URL_PATH);
        if (str_starts_with($uri, $basePath) && $basePath !== '/') {
            $uri = substr($uri, strlen($basePath));
        }

        return $uri === '' ? '/' : $uri;
    }

    function getQueryString()
    {
        return $this->serverParams['QUERY_STRING'] ?? '';
    }

    function getQueryParams()
    {
        return $this->getParams;
    }

    function getPostParams()
    {
        return $this->postParams;
    }

    function all() {
        return array_merge($this->getQueryParams(), $this->getPostParams());
    }

    function input($key, $default = null)
    {
        return $this->all()[$key] ?? $default;
    }

    function has($key)
    {
        return array_key_exists($key, $this->all());
    }

    function file($key)
    {
        return $this->files[$key] ?? null;
    }

    function getServerParams(){
        return $this->serverParams;
    }

    function fullUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        return $protocol . $host . $uri;
    }

    function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    function getAttribute($key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    function replace(array $newInput)
    {
        $this->getParams = array_merge($this->getParams, array_intersect_key($newInput, $this->getParams));
        $this->postParams = array_merge($this->postParams, array_intersect_key($newInput, $this->postParams));
    }
}