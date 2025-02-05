<?php

namespace Vrainsietech\Vrtmvc\Http;
use Vrainsietech\Vrtmvc\Core\Views;

class Response
{
    private $content;
    private $statusCode;
    private $headers = [];

    function __construct($content = '', $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    function view(string $view, array $data = [], $statusCode = 200): self
    {
        $viewPath = __DIR__ . '/Views/' . $view . '.php'; // Construct path here
        $errorViewPath = __DIR__ . '/Views/errors/404.php';
        $viewInstance = new Views($viewPath, $errorViewPath);
        foreach ($data as $key => $value) {
            $viewInstance->with($key, $value);
        }
        ob_start();
        $viewInstance->render();
        $this->content = ob_get_clean();
        $this->statusCode = $statusCode;
        $this->setHeader('Content-Type', 'text/html');
        return $this;
    }

    function send()
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }
        echo $this->content;
    }

    function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    function withJson(array $data, $statusCode = 200){
        $this->setContent(json_encode($data));
        $this->setHeader('Content-Type', 'application/json');
        $this->setStatusCode($statusCode);
        return $this;
    }

}