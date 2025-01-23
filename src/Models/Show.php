<?php
namespace Vrainsietech\Vrtmvc\Models;
use Vrainsietech\Vrtmvc\Core\VrtDb;

/**
 * Look up for individual or general data.
 * 
 * Use methods from this class with other models. The main working usage here is to fetch data, an individual data eg by id or a whole table depending with the conditions (sql qry statement(s)) passed to the methods. This serves like the main abstract class that can be implemented anywhere else for the purposes of  data fetching. Each method has it's own needs but almost all will need a table you are fetching from and a string of querry you are looking for in Key='Value' format and any other conditions  needed to achieve what is your desire.
 * 
 */

class Show extends VrtDb {
	private $vrt;

	function __construct(VrtDb $vrt){
		$this->vrt = $vrt;
	}
	/**
	 * find Individually lookup for data from one row.
	 * 
	 * Regardless of the table you are fetching from, provide the key and value of the column you are fetching from. This fetches and a single row data from the table provided. Has no defaults, so provide all arguments.
	 * 
	 * @param string $table The table to fetch from.
	 * @param int|string $key The column in the table to fetch from.
	 * @param string $value value of the key Column in the table provided.
	 * 
	 * @return array Row containing the data requested in associative way.
	 * 
	 * @throws Exception If id or column name is wrong or qry has any issue.
	 * 
	 */

	function find($table, $key, $value){
		$res = $this->vrt->qryman("SELECT * FROM $table WHERE $key = $value LIMIT 1");
		if($res){
			if($this->vrt->rowman($res) == 1){
				$data = $this->vrt->fetchman($res);
				return $data;
			} else {
				throw new Exception("No record Found");
			}
		} else  {
			throw new Exception("Failed. Something went wrong.");
		}
	}


	/**
	 * findAll lookup for data from several rows.
	 * 
	 * Fetch several rows once, provide the limit of the data to be displayed or fetched. Default is 10. Though resource intensive, provide the string 'all', to fetch all records from the table. Be cautious when using this and always only use when its really actually necessary. By default, when displaying data, there is pagination to allow loading of just  relevant data needed. USE 'all' WITH CAUTION. Data show will not show records listed for soft Deletion. To include data listed for Deletion, set soft to be true, default is false.
	 * 
	 * @param string $table The table to fetch from.
	 * @param string $soft Optional, pass 'true' to show all records including with status not 'valid or active'
	 * @param int|string $limit Optional of data to fetch from a table for display
	 * @param array $order Optional column and direction to fetch data, default column is id and direction is ASC. Other Possible value is DESC.
	 * 
	 * @return array Rows containing the data requested in associative way.
	 * 
	 * @throws Exception If any param(s) are wrong or sql execution fails.
	 * 
	 */

	function findAll($table, $order = array($column ='id','ASC'), $limit = 10, $soft = 'false'){

		$orders = array('ASC','DESC');
		$limits = "LIMIT $limit";
		if(!in_array($order[1],$orders)){
			throw new Exception("ORDER BY Clause can only be either 'ASC' or 'DESC'")
			return;
		}

		if($soft == 'true'){
			$filter = "";
		} else {
			$filter = "WHERE autodelete = 'notset'";
		}

		$order = $order[1]; 

		if($limit === 'all') $limits ="";

		$res = $this->vrt->qryman("SELECT * FROM $table $filter ORDER BY $column $order $limits ");
		if($res){
			if($this->vrt->rowman($res) == 1){
				$data = $this->vrt->fetchman($res);
				return $data;
			} else {
				throw new Exception("No records Found");
			}
		} else  {
			throw new Exception("Failed. Something went wrong.");
		}
	}

	//End  of Class
}