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
			<label for="password" id="password-label">Password:</label><br>
			<input type="password" name="password" id="password"
			 aria-required="true" aria-labelledby="password-label" 
			 placeholder="Enter password" required>
		</div>

		<hr>

		<div class="flexer flxbetween">
			<button type="submit" class="btn btn-primary">Login</button>
			<button type="button" class="btn btn-secondary" onclick="nav('register')">Sign Up</button>
		</div>

		<hr>
		<p class="description" onclick="nav('reset')">Forgotten Password</p>
		
	</form>


<?php
include "authfooter.php";
?>