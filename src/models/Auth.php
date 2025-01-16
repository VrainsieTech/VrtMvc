<?php
namespace Vrainsietech\Vrtmvc\Models;
use Vrainsitech\Vrtmvc\VrtDb;

/**
 * Authentication Manager.
 * 
 * Handles: Registration, Login and Password Resseting. By default, to all data being stored in the database, they all have a created at value being the current time but the VrtMvc version YmdHis. All the default user table has the created_at field. Learn more about the default user table field from the registration controller.
 * 
 */

class Auth extends VrtDb {
	protected $vrt;

	function __construct(VrtDb $vrt){
		$this->vrt = $vrt;
	}


	/**
	 * Register new User.
	 * 
	 * This method takes in four arguments. In order, Username, Email, Phone and Password. All this data needs validation done on the controller. Some other defaults will be added when data is being  saved to database. Ensure all security checks are done prior, though a last check is done here before saving.
	 * 
	 * @param string $username
	 * @param string $email
	 * @param string $phone
	 * @param string $password
	 * 
	 * @return string 'Success'
	 * 
	 * @throws Exception on failure or validating data.
	 * 
	 */

	function register($username,$email,$phone,$password){
		//Final validation.
		$data = func_num_args();
		$phonemax = 12; //Adjust as needed 
		if($data == 4){
			// Validate that phone is only numbers
			$onlydigits = preg_match('/^[0-9]+$/',$phone);
			if($onlydigits && strlen($phone) == $phonemax){
				//Username, Email and Phone must be unique.
				$exists = 0;
				$keys = array('username','email','phone');
				$values = array($username,$email,$phone);
				$table = "users"; //You can set different users' table in .env
				foreach($keys as $key){
					foreach($values as $value){
						$isin = self::similar($key,$value,$table);
						if($isin > 0) $exists++;
						break;
					}
				}

				if($exists == 0){
					//Hash Password and store
					$password = password_hash($password, PASSWORD_DEFAULT);
					//Set defaults
					$created_at = $updated_at = $this->vrt->vrttime();

					$create = $this->vrt->qryman("INSERT INTO $table(username,email,phone,password,created_at,updated_at)
						VALUES('$username','$email','$phone','$password','$created_at','$updated_at')");

					if($create){
						return "Success";
					} else {
						throw new Exception("Registration Failed. Please Try Again.");
					}
				} else {
					throw new Exception("Sorry, $key has already been used.")
				}

			} else {
				throw new Exception("Phone Number Validation Failed, Must be only digits and only $phonemax digits.");
			}
		}else{
			throw new Exception("Please Provide all details to successfully register. Only $data provided. You need 4");
		}
	}

	/**
	 * Login User.
	 * 
	 * User can login with either Username or Email. Provide arguments in order.
	 * 
	 * @param string $identifier
	 * @param string $password
	 * 
	 * @return string 'Success'
	 * 
	 * @throws Exception on failure or invalid data
	 * 
	 */

	function login($identifier, $password){
		//validate all args passed
		$valids = func_num_args();
		$blanks = 0; //data that is space and not valid info
		if($valid == 2){
			//Verify no empties
			$checks = array($identifier, $password);
			foreach($checks as $check){
				if($check === null || empty($check)){
					$blanks++;
					break;
				}
			}

			if($blanks == 0){
				//Sanitize
					$password  = $this->vrt->cleaner($password);
					$identifier = $this->vrt->cleaner($identifier);
				// No blanks check in tables
				$valid_user = 0;
				$key1 = 'username';
				$key2 = 'email';
				$key3 = 'password';
				$table = 'users'; 


				$checks = array($key1,$key2);
				foreach($checks as $check){
					$isin = self::similar($check,$identifier,$table);
					if($isin > 1) $valid_user++;
				}

				if($valid_user > 0){
					$data = $this->vrt->qryman("SELECT * FROM $table WHERE username = '$identifier' OR email = '$identifier' LIMIT 1");
					$pass_hash = $data['password'];
					$logtrials = $data['logtrials'];
					$banlifts = $data['banlifts'];
					$useris = $data['id'];
					$timenow = $this->vrt->vrttime();
					//Just in case user was banned for wrong password 
					if($banlifts == 'notbanned'){
						//Validate password
						if(password_verify($password,$pass_hash)){
							//Set all session neccessities
							$_SESSION['useris'] = $useris;
							//Just for any reason, reset logtrials
							if($logtrials < 5){
								$this->vrt->updates("UPDATE $table SET logtrials = 5 WHERE id = $useris LIMIT 1")
							}
							return "Success";
						} else {
							//Update trials counter
							if(($logtrials - 1) == 0){
								//Ban user 
								$banlift = $this->vrt->vrttime("+24 hours");
								$this->vrt->update("UPDATE $table SET banlifts = '$banlift',
								logtrials = 0 WHERE id = $useris LIMIT 1");
								// Notify
								throw new Exception("Too many failed logins. You are banned until $banlift");
							} else {
								//Only update logtrials
								$attempts = $logtrials--;
								$this->vrt->updates("UPDATE $table SET logtrials = $attempts 
									WHERE id = $useris LIMIT 1");
								throw new Exception("Sorry, invalid password, please try again, you have few attempts left.");
							}
						}

					} else {
						//try to set free then retry login
						if($timenow > $banlifts){
							$this->vrt->updates("UPDATE $table SET banlifts = 'notbanned',
							logtrials = 5
							WHERE id = $useris LIMIT 1");

							//Recall login
							self::login($identifier,$password);
						} else {
						throw new Exception("Sorry, login to this account is forbidden until $this->vrt->humandate($banlifts)");
					}
					}
				} else {
					throw new Exception("No such Username or Email. Provide valid username or Email to login");
				}
			} else {
				throw new Exception("Password or Username can't be empty.");
			}

		} else {
			throw new Exception("Please Provide all details, Email/Username and Password");
		}
	}


	/**
	 * Similar data in Database check.
	 * 
	 * Confirms if the provided data is  already existing in the database or not. Provide data to check and the table to check from. Use to validate tokens during ressets or check existence of same data during registration and much pretty anything else that needs validation. Provide the arguments in order. Key, value then table.
	 * 
	 * @param string $key
	 * @param string|int $value
	 * @param string $table
	 * 
	 * @return int 1|0 1 if available,  0 if no similar data is available.
	 *
	 * @throws Exception on empty $key,$value,$table provided
	 *  
	 **/

	function similar($key,$value,$table){
		// Confirm no empties
		$valid = 0;
		$incomings = array($key,$value,$table);

		foreach($incomings as $incoming){
			if($incoming === null || empty($incoming)){
				break;
			} else {
				$valid++;
			}
		}

		if($valid == 3){
			//Sanitize all data
			$key = $this->vrt->cleaner($key);
			$value = $this->vrt->cleaner($value);
			$table = $this->vrt->cleaner($table);
			return $this->vrt->rowman($this->vrt->qryman("SELECT * $table WHERE $key = '$value' LIMIT 1"));
		} else {
			throw new Exception("Please Provide All Parameters...");
		}
	}


//End of class.
}