<?php
namespace Vrainsitech\Vrtmvc\Models;
use Vrainsietech\Vrtmvc\VrtDb;

/**
 * Database Tables.
 * 
 * Provide sql file with tables or create table(s) manually. Pass in the file or the sql create table statement. This function will create the table for you in the database already created. So, it is wise to call this method after you have first called the dbCreate.
 * 
 * @param string $tables sql file name or path. File must only contain sql create table statements
 * 
 * @return boolean true or false depending with outcome, ofcourse true on success
 * 
 * @throws Exception when file path  is not valid, when execution fails for any reason.
 * 
 **/

class dbTables extends VrtDb {
	private $tables;

	function __construct($tables){
		$this->table = $tables;
	}

	function createTables(){


	if (!file_exists($sqlFilePath)) {
       throw new Exception("SQL file not found: " . $this->table);
    }

    $sql = file_get_contents($this->table);

        if ($this->vrtdb()->multi_query($sql)) {
            do {
                if ($result = $this->vrtdb()->store_result()) {
                    $result->free();
                }
                if (!$this->vrtdb()->more_results()) {
                    break;
                }
            } while ($this->vrtdb()->next_result());
            return true;
        } else {
            throw new Exception("Error executing SQL: " . $this->vrtdb()->error);
        }

    }
}