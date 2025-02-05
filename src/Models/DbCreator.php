<?php
namespace Vrainsietech\Vrtmvc\Models;
use Vrainsietech\Vrtmvc\Core\VrtDb;

require_once __DIR__ . '/config/config.php';

//Creates database using values provided in the config
$vrt = new VrtDb();
$db = $vrt->dbCreate();
$alert="";

if($db == 1){
	//Creates a fully privileged user.
	$dbpass = getenv('DB_PASS');
	$dbuser = getenv('DB_USER');
	$dbuser = $vrt->dbUser($dbpass, $dbname);

	if($dbuser == 1){
		//Notify Creator.
		$alert = $vrt->swal("Database and User Created Successfully.","bgscs");
    } else {
    	$alert = $vrt->swal("Database and User Creation Failed.","bgerr");
    }
}