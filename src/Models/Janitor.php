<?php
namespace Vrainsietech\Vrtmvc\Models;
use Vrainsietech\Vrtmvc\Core\VrtDb;

/**
 * Deletion and states Manager.
 * 
 * Janitor does soft deleting, i.e, changing user status from active to banned, suspends user in regards to how dormant they are and also provides method to auto delete a user who was set to soft deletion if state has not changed for a given number of days, ability to revert soft deletions back to valid users and also a method to permanently delete data from the Database from any table completely. CAUTION! Permanent deletion has no way to revert, use it only when necessary.
 * 
 */

class Janitor extends VrtDb {
	private $vrt;

	function __construct(VrtDb $vrt){
		$this->vrt = $vrt;
	}
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