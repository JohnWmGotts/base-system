<?php

	define('FROMEMAILADDRESS',"From: admin@".strtolower(DISPLAYSITENAME).".com");
	
	define('RNF','Record not found');
	
	// Succes Messages
	define("CHANGEPSW","We have sent an Email on your email Address with instruction to Reset your Password ");
	define("ADD","Record was Added Successfully");
	define("EDIT","Record was Edited Successfully");
	define("DEL","Record was Deleted Successfully");
	define("REGSUS","You have registered Successfully. Check mail to activate your account ");
	
	// Error Messages
	define('ER_ALPHANUM',' must contain only letters, numbers, underscore or dashes');
	define('ER_TIT','Please enter title');

	// Login Page
	define('ER_USER','Please enter user name');
	define('ER_FULLNAME','Please enter full name');
	define('ER_PSW','Please enter password');
	define('ER_INVUP','Invalid username or password');
	define('ER_PCS','Password is case-sensitive');
	define('ER_EMAIL','Please enter Email Address');
	define('ER_PSW_MIN','<br>Enter Password atleast 6 characters long');
	define('ER_PSW_MAX','<br>Password should not be  more than  30 characters long');
	define('ER_CPSW_MIN','<br>Enter Confirmed  Password atleast 6 characters long');
	define('ER_CPSW_MAX','<br>Confirmed  Password should not be more than  30 characters long');

	// Change Password
	define('ER_OPSW','Please enter old password');
	define('ER_CPSW','Please enter confirmed password');
	define('ER_OPSWINC','Your old password is incorrect');
	define('ER_SAMEPSW','Please enter the same password as above');
	
	//user page
	define('ER_UNAME_MIN','<br>Name should be atleast 4 characters long');
	define('ER_UNAME_MAX','<br>Name should not be more than 25 characters long');
	define('ER_UBIOGRAPHY_MAX','<br>Biography should not be more than 300 characters long');
	define('ER_UPWD_MIN','<br>Password should be atleast 6 characters long');
	define('ER_UPWD_VALID','<br>The password must contain a minimum of one lower case character, one upper case character and one digit<br>');
	define('ER_UEMAIL','<br>Please Enter a valid email');
	
	// CMS Page
	define('ER_CONT','Please enter content');
	
	// Constant Page
	define('ER_KEY','Please enter key');
	define('ER_VALUE','Please enter value');

	// Image Page	
	define('ER_IMG','Please select image');
//	define('ER_IMGTYPE','Only '.IMGEXT.' type images allowed');
	define('ER_IMGSIZE','Only less than or equal to 5kb image size allowed');
	define('ER_IMGRMV','Image Remove Successfully');
	define('ER_IMGADD','Image Added Successfully');
	
	//No image
	define("NOIMG",SITE_IMG.'site/no_image.jpg');
	define("NOIMG2",SITE_IMG.'site/no_imagenew.jpg');
	
	//No Slider image
	define("NOSLIMG",SITE_IMG.'site/no_image_slider.jpg');
	define("NOSLIMG1",DIR_IMG.'site/no_image_slider.jpg');
	
	// Edit Static Content
	define("ER_PAGETIT",'Enter a page title');
	define("ER_METAAU",'Enter your name - for internal use only');
	define("ER_METAKEY", 'Enter appropriate page keywords');
	define("ER_METADESC", 'Enter a page description');

?>