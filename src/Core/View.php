<?php
namespace Vrainsietech\Vrtmvc\Core;

/**
 * Views Templating Engine.
 * 
 * This Engine implements an easier way to pass variables to views. It reduces the task of having to use the php native tagging open and closing tags and many echos in html scripts. Its safe to use in a javascript script as it only use '{{somevar}}' unlike the js that use '${somevar}'. The syntax is safe for universal passing of php vars to the views files. Remember to make sure every view file ends with a .php extension to make this work well without issue.
 * 
 * @param string $viewPath The path to view file.
 * @param string $errorViewPath [Optional] The path to a custom 404 page in case $viewPath fails.
 * 
 * @return string|int whichever is the data you are looking to pass to the view file.
 * 
 */

class Views {

    private $viewPath;
    private $data = [];
    private $errorViewPath; // Path to the 404 view

    public function __construct($viewPath, $errorViewPath = null) {
        $this->viewPath = $viewPath;
        $this->errorViewPath = $errorViewPath;
    }

    public function with($key, $value) {
        $this->data[$key] = $value;
        return $this;
    }

    private function renderErrorView() {
        if ($this->errorViewPath && file_exists($this->errorViewPath)) {
            http_response_code(404); // Set the 404 status code
            include $this->errorViewPath;
        } else {
            http_response_code(404);
            echo "<h1>404 Not Found</h1><p>The requested page could not be found.</p>";
        }
    }

    public function render() {
        if (!file_exists($this->viewPath)) {
            $this->renderErrorView();
            return; // Important: Stop further execution
        }

        ob_start();
        include $this->viewPath;
        $content = ob_get_clean();

        $content = preg_replace_callback('/\{\{(.*?)\}\}/', function ($matches) {
            $key = trim($matches[1]);
            return isset($this->data[$key]) ? htmlspecialchars($this->data[$key], ENT_QUOTES, 'UTF-8') : '';
        }, $content);

        echo $content;
    }
}