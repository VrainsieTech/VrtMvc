<?php
namespace Vrainsietech\Vrtmvc\Models;
use Vrainsietech\Vrtmvc\Core\VrtDb;


class Update extends VrtDb {
private $vrt;
function __construct(VrtDb $vrt){
	$this->vrt = $vrt;
}

/**
 * Update Database Tables.
 * 
 * Provide the needed table that needs update along with Key='Value' string or comma separated and Condition to successfully update the given row(s) of data in the given table. Be sure to give condition to effectively affect the number of rows needed.
 * 
 * @param $table Target table in the database.
 * @param $qry The Key='Value' pair(s) of statement to be worked on.
 * @param $condition string the sql condition to use to do the update only on relevant needed row(s).
 * 
 * @return int number of affected row(s)
 * 
 * @throws Exception on qry format or sql execution fail
 * 
 */

function update($table,$qry,$condition){
	$res = $this->vrt->updates("
		UPDATE $table SET
		$qry
		WHERE
		$condition
		");
	if($res){
		return mysqli_affected_rows($this->vrt->vrtdb());
	} else {
		throw new Exception("Update Failed. Try again.");
	}
}

//End of class
}

