#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Vrainsietech\Vrtmvc\Helpers\FileGenerator; 

// Get the command and arguments
$command = $argv[1] ?? null;
$arguments = array_slice($argv, 2);

switch ($command) {
    case 'make:controller':
        if (count($arguments) !== 1) {
            echo "Usage: ./vrtcli make:controller <ControllerName>\n ";
            exit(1);
        }
        $controllerName = $arguments[0];
        FileGenerator::createController($controllerName);
        break;

    case 'make:view':
        if (count($arguments) !== 1) {
            echo "Usage: ./vrtcli make:view <ViewName>\n";
            exit(1);
        }
        $viewName = $arguments[0];
        FileGenerator::createView($viewName);
        break;

    case 'destroy:controller':
        if (count($arguments) !== 1) {
            echo "Usage: ./vrtcli destroy:controller <ControllerName>\n";
            exit(1);
        }

        $controllerName = $arguments[0];
        if(!file_exists(__DIR__."/src/Controllers/$controllerName.php")){
            echo "Error. Controller file specified doesn't exist.";
            exit(1);
        }
        if(unlink(__DIR__."/src/Controllers/$controllerName.php")){
            echo "Controller '$controllerName' Succefully Destroyed Locally";
        } else {
            echo "Error. System encounterd and issue. Try again.\n Controller '$controllerName' NOT Destroyed";
        }
        break;

    case 'destroy:view':
        if (count($arguments) !== 1) {
            echo "Usage: ./vrtcli destroy:view <viewName>\n";
            exit(1);
        }

        $viewName = $arguments[0];
        if(!file_exists(__DIR__."/src/Views/$viewName.php")){
            echo "Error. View file specified doesn't exist.";
            exit(1);
        }
        if(unlink(__DIR__."/src/Views/$viewName.php")){
            echo "View '$viewName' Succefully Destroyed Locally";
        } else {
            echo "Error. System encounterd and issue. Try again.\n View '$viewName' NOT Destroyed";
        }
        break;

    default:
        echo "Available commands:\n";
        echo "  make:controller <ControllerName>\n";
        echo "  make:view <ViewName>\n";
        echo "  destroy:controller <ControllerName>\n";
        echo "  destroy:view <ViewName>\n";
        break;
}