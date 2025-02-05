<?php
require "authheader.php";
$alert ="";
$formis ="";
if(isset($_GET['token']) && !empty($_GET['token'])){
	$formis = "class='d-none'";
}
?>

	<!-- Password Reset Request Form.-->
	<form <?php echo $formis;?> aria-label="Password-reset-requestForm" method="POST">
		<div class="flexer flxcenter"><?php echo $alert;?></div>
		<div>
			<label for="email" id="email-label">Email:</label><br>
			<input type="email" name="email" id="email"
			 aria-required="true" aria-labelledby="email-label" 
			 placeholder="Enter Registered" required>
		</div>

		<hr>

		<div class="flexer flxbetween">
			<button type="submit" class="btn btn-primary">Request</button>
			<button type="button" class="btn btn-secondary" onclick="nav('login')">Login</button>
		</div>

		
	</form>

	<!-- New Password Set Form.-->
	<form <?php echo $formis;?> aria-label="New-password-setForm" method="POST">
		<div class="flexer flxcenter"><?php echo $alert;?></div>
		<div>
			<label for="password" id="password-label">Password:</label><br>
			<input type="password" name="password" id="password"
			 aria-required="true" aria-labelledby="password-label" 
			 placeholder="Enter Password" required>
		</div>

		<div>
			<label for="confirm-password" id="confirm-password-label">Confirm Password:</label><br>
			<input type="password" name="confirmpassword" id="confirm-password"
			 aria-required="true" aria-labelledby="confirm-password-label" 
			 placeholder="Confirm password" required>
		</div>

		<hr>

		<div class="flexer flxbetween">
			<button type="submit" class="btn btn-primary">Reset</button>
			<button type="button" class="btn btn-secondary" onclick="nav('login')">Login</button>
		</div>

		<hr>
		<p class="description" onclick="nav('register')">Sign Up</p>
		
	</form>



<?php
include "authfooter.php";
?>