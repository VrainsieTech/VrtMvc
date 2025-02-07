<?php
namespace Vrainsietech\VrtMvc\Core\Model;
use Vrainsietech\Vrtmvc\Core\VrtDb;

/**
 * Model - Base Model with all CRUD operations.
 * 
 * Extending to this class when creating models. It provides all the needed CRUD operations. The Delete operation has some more advanced methods to use to be able to delete data permanently or temporarily for some period of time. Use permanent delete with CAUTION. The default table is not provide. Be  sure to provide that in your controllers*
 * 
 */

class Model extends VrtDb {
	private $vrt;

	function __construct(VrtDb $vrt){
		$this->vrt = $vrt;
	}

	/*//////////////////////////////////////////////////
	\\                     READ DATA                  \\
	//////////////////////////////////////////////////*/

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
		$res = $this->vrt->queryman("SELECT * FROM $table WHERE $key = $value LIMIT 1");
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

	function findAll($table, $order = ['id','ASC'], $limit = 10, $soft = 'false'){

		$orders = array('ASC','DESC');
		$limits = "LIMIT $limit";
		if(!in_array($order[1],$orders)){
			throw new Exception("ORDER BY Clause can only be either 'ASC' or 'DESC'");
			return;
		}

		if($soft == 'true'){
			$filter = "";
		} else {
			$filter = "WHERE autodelete = 'notset'";
		}

		$direction = $order[1]; 
		$column = $this->vrt->cleaner($order[0]);

		if($limit === 'all') $limits ="";

		$res = $this->vrt->queryman("SELECT * FROM $table $filter ORDER BY $column $direction $limits ");
		if($res){
			if($this->vrt->rowman($res) == 1){
			while($data = $this->vrt->fetchman($res)){
				return $data;
			}

			} else {
				throw new Exception("No records Found");
			}
		} else  {
			throw new Exception("Failed. Something went wrong.");
		}
	}


	/*//////////////////////////////////////////////////
	\\                   UPDATE DATA                  \\
	//////////////////////////////////////////////////*/

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


	/*//////////////////////////////////////////////////
	\\                   DELETE DATA                  \\
	//////////////////////////////////////////////////*/


	/**
	 * Soft Delete.
	 * 
	 * This method simply updates the user/data state to a state that mimicks deletion; banned. In this state, data in this row(s) is ignored when searched for implicitly. Data set for deletion through softDel() has a default auto permanent delete day which is 180 days since the time softDel() was called on that row(s).
	 * 
	 * @param string $table Table to get the row(s) from. 
	 * @param string $condition Sql statement setting conditions necessary for updates. No defaults provided.
	 * 
	 * @return int Number of affected row(s)
	 * 
	 * @throws Exception On failure of sql or if states or condition aint valid.
	 * 
	 */

	function softDel($table, $condition){
		$autodel = $this->vrt->vrttime("+180 days");

		$res = $this->vrt->updates("
			UPDATE $table SET
			autodelete = '$autodel',
			state = 'banned'
			WHERE
			$condition
			");

		if($res){
			return mysqli_affected_rows($this->vrt->vrtdb());
		} else {
			throw new Exception("Soft Deletion Failed. Try Again");
		}
	}

	/**
	 * Revert Soft Deletion.
	 * 
	 * This method simply updates the user/data state to active/valid status. This is only possible if the data has not been auto permanent deleted. This makes data available as always. To Revert all soft deleted data once in a column, set condition to 'all'. It's risky though to update all records blindly. Use 'all' for condition with care.
	 * 
	 * @param string $table Table to get the row(s) from. 
	 * @param string $condition Sql statement setting conditions necessary for updates. No defaults provided.
	 * 
	 * @return int Number of affected row(s)
	 * 
	 * @throws Exception On failure of sql or if states or condition aint valid.
	 * 
	 */

	function Revert($table,$condition){
		$autodel = 'notset';
		if($condition === 'all'){
			$rule = '';
		} else {
			$rule = "WHERE $condition";
		}

		$res = $this->vrt->updates("
			UPDATE $table SET
			autodelete = '$autodel',
			state = 'valid'
			$rule
			");

		if($res){
			return mysqli_affected_rows($this->vrt->vrtdb());
		} else {
			throw new Exception("Reverting Failed. Try Again");
		}
	}

	/**
	 * Permanent Deletion.
	 * 
	 * This method permanently deletes the record(s) from the table provide and has no way of reverting. Handle with care. To avoid accidental deletion of all data from a table, you must provide condition(s) to adhere to before. To delete all records, provide 'allrecords' for condition.
	 * 
	 * @param string $table Table to get the row(s) from. 
	 * @param string $condition Sql statement setting condition(s) necessary for Deletions. No defaults provided.
	 * 
	 * @return int Number of affected row(s)
	 * 
	 * @throws Exception On failure of sql or if states or condition aint valid.
	 * 
	 */

	function PermDel($table, $condition){
		if($condition === 'allrecords'){
			$rule = '';
		} else {
			$rule = "WHERE $condition";
		}

		$res = $this->vrt->queryman("DELETE FROM $table $rule");

		if($res){
			return mysqli_affected_rows($this->vrt->vrtdb());
		} else {
			throw new Exception("Deletion Failed. Try Again");
		}
	}


	/**
	 * Auto Permanent Deletion.
	 * 
	 * This method Deletes automatically any data from any given table where the auto delete date is due.
	 * 
	 * @param string $table Table to get the row(s) from.
	 * 
	 * 
	 */

	function AutoDel($table){
		$timenow= $this->vrt->vrttime();
		$this->vrt->queryman("DELETE FROM $table WHERE autodelete <= '$timenow'");
	}


	//End of class
}