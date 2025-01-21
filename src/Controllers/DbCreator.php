<?php
namespace Vrainsietech\Vrtmvc\Controllers;
use Vrainsietech\Vrtmvc\Core\VrtDb;

require_once __DIR__ . '/config/config.php';

//Creates database using values provided in the config
$vrt = new VrtDb();
$db = dbCreate();

if($db == 1){
	//Creates a fully privileged user.
	$dbpass = ENV('orgDbPass');
	$dbuser = ENV('orgDbUser');
	$dbuser = $vrt->dbUser($dbpass, $dbname);

	if($dbuser == 1){
		//Notify Creator.
		if(isset($_GET['alert'])){
			if($_GET['scs']){
				echo "<script>alert('Database and User Created successfully')</script>";
		    } else {
			echo "<script>alert('Database and User Creation Failed')</script>";
		    }
		
	   }
    }
}