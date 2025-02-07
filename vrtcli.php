#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Vrainsietech\Vrtmvc\Helpers\FileGenerator; 

// Get the command and arguments
$command = $argv[1] ?? null;

if($command === null || empty($command)){
    echo "Available commands:\n";
    echo "  make:controller <ControllerName>\n";
    echo "  make:model <ModelName>\n";
    echo "  make:view <viewName>\n";
    echo "  destroy:controller <ControllerName>\n";
    echo "  destroy:model <ModelName>\n";
    echo "  destroy:view <viewName>\n\n";
    echo "To run Local server:\n";
    echo "serve\n\n";
    exit(1);
}

$arguments = array_slice($argv, 2);
$action = substr($command,0,strpos($command,':'));
$component = subtr($command,(strpos($command,':') + 2));

switch ($component){
    case 'controller':
        $intent = ['controller', 'Controller'];
        break;

    case 'model':
        $intent = ['model', 'Model'];
        break;

    case 'view':
        $intent = ['view', 'view'];
        break;
}


switch ($action) {
    case 'make':
        if (count($arguments) !== 1) {
            echo "Usage: ./vrtcli make:$intent[0] <$intent[1]Name>\n ";
            exit(1);
        }
        $componentName = $arguments[0];
        if($component == 'controller') FileGenerator::createController($componentName);
        if($component == 'model') FileGenerator::createModel($componentName);
        if($component == 'view') FileGenerator::createView($componentName);
        
        break;

    case 'destroy':
        if (count($arguments) !== 1) {
            echo "Usage: ./vrtcli destroy:$intent[0] <$intent[1]Name>\n";
            exit(1);
        }

        $componentName = $arguments[0];
        if($component == 'controller') $dir = 'Controllers';
        if($component == 'model') $dir = 'Models';
        if($component == 'view') $dir = 'Views';

        if(!file_exists(__DIR__."/src/$dir/$componentName.php")){
            echo "Error. $intent[1] file specified doesn't exist.";
            exit(1);
        }
        if(unlink(__DIR__."/src/$dir/$componentName.php")){
            echo "$intent[1] '$componentName' Succefully Deleted Locally.";
        } else {
            echo "Error. System encounterd and issue. Try again.\n $intent[1] '$componentName' NOT Deleted.";
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