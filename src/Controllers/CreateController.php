<?php
namespace Vrainsietech\Vrtmvc\Controllers;
use Vrainsietech\Vrtmvc\Cores\VrtDb;

/**
 * General new data Creation.
 * 
 * Create a new record for any give table or Database. All new data(s) to be created is simply a new sql INSERT statement. Provides Default columns.
 * 
 * 
 */

class CreateController extends VrtDb {
	private $vrt;

	function __construct(VrtDb $vrt){
		$this->vrt = $vrt;
	}

	/**
	 * Insert New data.
	 * 
	 * Create the data and make ready to be inserted to any table. Incoming data undergoes sanitization. Please validate data to be sure its the right type expected.
	 * 
	 * @param string $table Table to store record
	 * @param array $data A key='value' data to be insterted. Must be  in order of table structure column or order in the row.
	 * 
	 * @return int Affected row(s)
	 * 
	 * @throws Excepion On any form of failure encountered sql or wrong data format.
	 * 
	 */


	function addNew($table, Request $request){
		

	}
	//End of Class
}