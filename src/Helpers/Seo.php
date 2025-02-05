<?php

namespace Vrainsietech\Vrtmvc\Helpers;


/**
 * SEO Manager.
 * 
 * Enter the details as per your desire and how you wish the SEO to find and index your web application. 
 * 
 */


class Seo {
	static function title(){
		return "VrtMvc - PHP Framework";
	}

	static function description(){
		return "VrtMvc is a PHP MVC framework that is very simple to use yet so powerful with the latest security measures while making the work for a developer very easy. Stress with your app logic only, go DRY. Accomplish tasks faster saving more than 60% time you would have taken starting from scratch or using other frameworks.";
	}

	static function themeColor(){
		return "#343434";
	}

	static function canorgurl(){
		return "https://vrainsietech.com";
	}

	static function faviconsurl(){
		return "/assets/icons";
	}

	static function ogtitle(){
		return "VrtMvc PHP Framework";
	}

	static function ogimage(){
		return "https://vrainsietech.com/assets/images/ogsimage.png";
	}

	static function logo(){
		return "/assets/images/logo.png";
	}
}