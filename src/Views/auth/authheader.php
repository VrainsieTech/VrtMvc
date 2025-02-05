<?php

require "/includes/seomaster.php";
$brandlogo = ""; //path to a brand logo 512x512 is better.
$brandname = "Vrainsie Tech"; // Enter your brand name
$brandtag = "Tech that speaks to your vision";

?>
<section class="auth-container">

<section class="authheader"></section>

<section class="leftpane"></section>

<section class="auth">
	<!-- Branding-->
	<div class="flexer flxcenter">
		<div>
		<img src="<?php echo $brandlogo;?>" alt="Brand Logo" class="brandlogo">
		<div class="brandname"><?php echo $brandname;?></div>
		<div class="description"><?php echo $brandtag;?></div>
	    </div>
	</div>

