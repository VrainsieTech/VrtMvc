<?php

require 'vendor/autoload.php';

use Vrainsietech\VrtMvc\Helpers\Whoami; // Just replace path to unit of test

$myObject = new Whoami();
$result = $myObject->iam();
echo $result; // Or var_dump($result); for debugging

// Add more test cases here to cover different scenarios.