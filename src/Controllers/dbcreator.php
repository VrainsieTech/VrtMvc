<?php
namespace Vrainsietech\Vrtmvc;
use Vrainsietech\Vrtmvc\VrtDb;

//Creates database using values provided in the .env.
$vrt = new VrtDb();

if($db == 1){
	//Creates a fully privileged user.
	$dbpass = ENV('orgDbPass');
	$dbuser = ENV('orgDbUser');
	$dbuser = $vrt->dbUser($dbpass, $dbname);

	if($dbuser == 1){
		//Notify Creator.
		$alert = $vrt->swal("Database and Database User Created successfully","bgscs");
	}
}