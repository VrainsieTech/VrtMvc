<?php
require "authheader.php";
?>

	
	<!-- Login Form.-->
	<form aria-label="loginForm">
		<div>{{$alert}}</div>
		<div>
			<label for="username" id="username-label">Username:</label><br>
			<input type="text" name="username" id="username"
			 aria-required="true" aria-labelledby="username-label" 
			 placeholder="Enter Username" required>
		</div>

		<div>
			<label for="email" id="email-label">Email:</label><br>
			<input type="email" name="email" id="email"
			 aria-required="true" aria-labelledby="email-label" 
			 placeholder="Enter Email" required>
		</div>

		<div>
			<label for="phone" id="phone-label">Phone:</label><br>
			<input type="text" name="phone" id="phone"
			 aria-required="true" aria-labelledby="phone-label" 
			 placeholder="Enter Phone" required>
		</div>

		<div>
			<label for="password" id="password-label">Password:</label><br>
			<input type="password" name="password" id="password"
			 aria-required="true" aria-labelledby="password-label" 
			 placeholder="Enter password" required>
		</div>

		<div>
			<label for="confirm-password" id="confirm-password-label">Confirm Password:</label><br>
			<input type="password" name="confirmpassword" id="confirm-password"
			 aria-required="true" aria-labelledby="confirm-password-label" 
			 placeholder="Confirm password" required>
		</div>


		

		<hr>

		<div class="flexer flxbetween">
			<button type="submit" class="btn btn-primary">Sign Up</button>
			<button type="button" class="btn btn-secondary" onclick="nav('login')">Login</button>
		</div>

		<hr>
		<p class="description" onclick="nav('reset')"></p>
		
	</form>



<?php
include "authfooter.php";
?>