<?php
namespace Vrainsietech\Vrtmvc;
use Vrainsietech\Vrtmvc\VrtDb;

//Creates database using values provided in the .env.
$db = VrtDb::dbCreate();

if($db == 1){
	//Creates a fully privileged user.
	$dbpass = ENV('orgDbPass');
	$dbuser = ENV('orgDbUser');
	$dbuser = VrtDb::dbUser($dbpass, $dbname);

	if($dbuser == 1){
		//Notify Creator.
		$message = VrtDb::swal("Database and Database User Created successfully","bgscs");
	}
}