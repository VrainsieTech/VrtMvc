<?php
namespace Vrainsitech\Vrtmvc\Models;
use Vrainsietech\Vrtmvc\Core\VrtDb;

/**
 * Database Tables.
 * 
 * Provide sql file with tables or create table(s) manually. Pass in the file or the sql create table statement. This function will create the table for you in the database already created. So, it is wise to call this method after you have first called the dbCreate.
 * 
 * @param string $tables sql file name or path. File must only contain sql table statements
 * 
 * @return boolean true or false depending with outcome, ofcourse true on success
 * 
 * @throws Exception when file path  is not valid, when execution fails for any reason.
 * 
 **/

class dbTables extends VrtDb {
	private $tables;
    private $vrt;

	function __construct($tables, VrtDb $vrt){
		$this->table = $tables;
        $this->vrt = $vrt;
	}

	function createTables(){


	if (!file_exists($this->table)) {
       throw new Exception("SQL file not found: " . $this->table);
    }

    $sql = file_get_contents($this->table);

        if ($this->$vrt->vrtdb()->multi_query($sql)) {
            do {
                if ($result = $this->$vrt->vrtdb()->store_result()) {
                    $result->free();
                }
                if (!$this->$vrt->vrtdb()->more_results()) {
                    break;
                }
            } while ($this->$vrt->vrtdb()->next_result());
            return true;
        } else {
            throw new Exception("Error executing SQL: " . $this->$vrt->vrtdb()->error);
        }

    }
}