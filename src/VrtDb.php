<?php 
namespace Vrainsietech\Vrtmvc;

/**
 * Main Database Connection Class.
 * 
 * Creates the db connection using a procedural approach for MySQLi Database as default Database. The Db defaults are used first to connect to the db to enable creation of a new database, user and granting all priviledges to the user. The values used are sourced from the initial call of the class dbCreate Method. A few more more MySQLi CRUD database operations are added and can be called anywhere in any other class(s).
 * 
 * @return object of mysqli connection and other usefull generals.
 * 
 **/

 class VrtDb {
 	/**
 	 * Database and user creation fully priviledged.
 	 * 
 	 * @var string $dbName
 	 * @var string $dbUser
 	 * @var string $dbPass
 	 * 
 	 * 
 	 * @throws Exception When Connection fails.
 	 *
 	 */

 	private $dbName = ENV('OrgDbName');
 	private $dbUser = ENV('OrgDbUser');
 	private $dbPass = ENV('OrgDbPass');
 	private $dbHost = 'localhost';

 	function dbCreate() {
 	   /**
 		 * New Database Creation for Every New Organization.
 		 * 
 		 * Not everyone using this software might have access  directly to Cpanel to do the database creation, so this method allows a universal usage of the software on the go. The Database created has it's own unique name and unique user having all priviledges by default. Either way, you can still pass in your specific dbname, user and password. By default. This data is added to .env in the organization's specific folder. Once user registers as an organization, a specific unique folder is created using a some values provided during registration, or defaults in the .env if none is provided.
 		 * 
 		 * @return int 1 on success.
 		 * 
 		 * @throws Exception on failure.
 		 */

 		//Get root connection
 		$con = self::rootConn();

 		if($con){
 			$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
 			$dbc = mysqli_query($con,$sql);
 			if($dbc){
 				return 1;
 			} else {
 				throw new Exception("Database Creation Failed. ".mysqli_connect_error($dbc))
 			}
 		}

 	}


 	   /** 
 		 * Creates a priviledged user.
 		 * 
 		 * After Database Creation, this method executes by default and uses the username provided in the .env and the created database. The method can also be executed manually if there is need to create a different user for the same database. Each time, auto called or manually called, the user created will allways have all database priviledges. That is the default setting. To manually call, provide different values for a username and password to affect or just username if using the same password.
 		 * 
 		 * @param string $dbpass
 		 * @param string $dbuser
 		 * 
 		 * @return int 1 on success.
 		 * 
 		 * @throws Exception on failure.
 		 * 
 		 */
 	function dbUser($dbpass,$dbuser){
 		//Get root Conn
 		$con = self::rootConn();

 		$sql ="CREATE USER '$dbuser'@'localhost' IDENTIFIED BY '$dbpass';
 		GRANT ALL PRIVILEGES ON $dbName.* TO '$dbuser'@'localhost';
 		FLUSH PRIVILEGES";

 		if(mysqli_querry($con,$sql)){
 			return 1;
 		} else {
 			throw new Exception("Failed to Create new User. ".mysqli_connect_error($con));
 		}


 	}

   /**
 	 * Specific User and Dd Connector.
 	 * 
 	 * Only Call this method Once you have created a database and user. Though defaults will be used for demo purposes. This is the softwares database connection entry point that handles all other Mysqli database operations. Use it anytime you need to perform any supported transactions. Its uses the values provided in the .env.
 	 * 
 	 * @throws Exception on failure.
 	 * 
 	 * @return object of mysqli connection for a specified user and database
 	 * 
 	 */

 	protected function vrtdb(){
 		$vrtdb = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);
 		if($vrtdb){
 			return $vrtdb;
 		} else {
 			throw new Exception("Connection Failed. ".mysqli_connect_error($vrtdb));
 		}
 	}


 	/**
 	 * Query Manager.
 	 * 
 	 * This method manages all the queries. That is, Pass in the SQL query you have as an argument when invoking the method at any time.
 	 * 
 	 * @param $qry string
 	 * @return object Transaction object which can be success or failure.
 	 * 
 	 */

 	function queryman($qry){
 		$con = self::vrtdb();
 		return mysqli_query($con,$qry);
 	}

 	/**
 	 * Number of row(s) Manager.
 	 * 
 	 * This method handles row(s) returned as a result of a query. Pass in the result of a query either stored as a variable whose value is the result object from the query or a full statement using query manager syntax.
 	 * @param object $res
 	 * @return object Transaction object which can be success or failure.
 	 * 
 	 */

 	function rowman($res){
 		return mysqli_num_rows($res);
 	}


 	/**
 	 * Fetch Manager.
 	 * 
 	 * This method fetches the result. hands out the result as an associative array. Pass in the result of a query either stored as a variable whose value is the result object from the query or a full statement using query manager syntax. 
 	 * 
 	 * @param object $res
 	 * @return object Transaction object which can be success or failure.
 	 * 
 	 */

 	function fetchman($res){
 		return mysqli_fetch_array($res);
 	}

 	/**
 	 * Updates Manager.
 	 * 
 	 * Update tables easily. Pass in a string of the update statement either as a variable whose value is the statement or just a string directly of the update statement. DO NOT ADD CONNECTION to the string REMEMBER to SPECIFY THE 'WHERE' CLAUSE. 
 	 * 
 	 * @param string $qry
 	 * @return boolean true or false.
 	 * 
 	 **/

 	function updates($qry){
 		return self::queryman($qry);
 	}


 	/**
 	 * Date/Time Formatter to YmdHis Format. Default Software timestamp
 	 * 
 	 * By default, this software uses the hosts default timezone in the .htacess. To override, change the timezone value in the .htacess to match your local time. You can also set the default zone in your. Pass in an argument of desired date; a day before now or a future date to have it formatted. Considering using the syntax for php datetime formating acceptable string arguments. This Method when called with no argument, gives current time.
 	 * 
 	 * @param string $arg.
 	 * @return string custom time from argument or current time when no argument passed in format YmdHis.
 	 * 
 	 */

 	function vrttime($arg = null){
 		if($arg !== null){
 			return date('YmdHis', strtotime($arg));
 		} else {
 			return date('YmdHis',strtotime('now'));
 		}
 	}


 	/**
 	 * Human Date Format.
 	 * 
 	 * For some reason, you may want to give the user a human readable date than the system date that is YmdHis format. Achieve this by passing in the YmdHis string to this method. This converts  the machine date to human date in format Y/m/d H:i:s.
 	 * 
 	 * @param string $sys_date
 	 * 
 	 * @return string human readable date.
 	 * 
 	 * @throws Exception if system date is not provided or string provided does not qualify as a YmdHis Format datetiime
 	 */

 	function humandate($sys_date){
 		if(!$sys_date || strlen($sys_date) != 14){
 			throw new Exception("Please Provide date in Format YmdHis eg. 20250120134525");
 		} else {
 			$year = substr($sys_date,0,4);
 			$month = substr($sys_date,5,2);
 			$day = substr($sys_date,7,2);
 			$hour = substr($sys_date,9,2);
 			$min = substr($sys_date,11,2);
 			$sec = substr($sys_date,13,2);

 			return $year."/".$month."/".$day." ".$hour.":".$min.":".$sec;
 		}
 	}

 	/**
 	 * User input sanitizer.
 	 * 
 	 * All user inputs should be sanitized to avoid any chance of sql injection. Since this software has no need to use prepared statements, always remember to call this method on every user input send by post or get methods or even all those sennd through ajax. This takes care of strip slashing and htmlspecialchars and all that.
 	 * 
 	 * @param string $str
 	 * 
 	 * @return string sanitized and safe to be used in sql transaction.
 	 * 
 	 */

 	function cleaner($str){
 		if(!is_string($str)) return "";
 		$str= filter_var($str, FILTER_SANITIZE_STRING);
 		$con = self::rootConn();
 		$str = mysqli_real_escape_string($con,$str);
 		return $str;

 	}

 	/**
 	 * Sweet Alert.
 	 * 
 	 * This method serves as the default point to give graphical information, error and success messages to the user and also redirecting a user to a specific page when need be. Pass in 2 arguments, the message and background color for the message. Add the file name to the background color if after the message, the user is supposed to be redirected elsewhere. The background color is always bgscs for success or bgerr for error or bgwrn for warning, addinng a file, eg bgscsdashboard will show the success message then redirect user to dashboard.
 	 * 
 	 * @param string $msg
 	 * @param string $bg
 	 * 
 	 * @return string a html element string that that shows info or error message.
 	 * 
 	 */

 	function swal($msg,$bg){
        $ids = substr(uniqid(),7,4);
        $redirect = "nn";
        if(strlen($bg) > 5){
            $redirect = substr($bg,5);
            $bg= substr($bg,0,5);
        }
      return "<div id='$ids' class='alert $bg'>
        $ms
        <script>kill('$ids','$redirect'); </script>
        </div>";
    }



 	/**
 	 * Default MySQLi Connector.
 	 * 
 	 * The default connection before any other connections of specific Databases and Usernames, The root connection.
 	 * 
 	 * @return object $con, a connection object from mysqli procedural way.
 	 * 
 	 * @throws Exception on failure.
 	 * 
 	 */

 	function rootConn(){
 		$rpass = '';
 		$ruser = 'root';
 		$host = 'localhost';
 		$con = mysqli_connect($host,$ruser,$rpass);

 		if(!$con){
 			throw new Exception("Root Connection Failed: ".mysqli_connect_error($con));
 		} else {
 			return $con;
 		}
 	}


 	//End of Class.
 }