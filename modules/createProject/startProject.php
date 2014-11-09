<?php
require "../../includes/config.php";
if(!isset($_SESSION) || ($_SESSION['userId']=='')) {
	$_SESSION['msg'] = "Please login to start new project.";
	$_SESSION['RedirectUrl'] = get_url();
    redirect($login_url);
    exit();
}
	$uid =$_SESSION['userId'];
	if($_POST['id']=='on') {
		/*start the project*/
		$useremail = mysql_fetch_assoc($con->recordselect("SELECT emailAddress from users where userId = ".$uid));
		$insertQuery = "INSERT INTO projects(`userId`,`acceptTerms`) VALUES(".$uid.",1)";
		$con->insert($insertQuery);
		$projectId = mysql_insert_id();
		$_SESSION['projectId'] = $projectId;
		$projId = $_SESSION['projectId'];
		$insertQuery = "INSERT INTO projectbasics 
		(projectTitle,projectCategory,shortBlurb,projectLocation,projectStart,projectEnd,fundingGoal,projectId) VALUES ('', '', '', '', '','', '',$projectId)";
		$con->insert($insertQuery);
		$insertQuery = "INSERT INTO projectstory(projectVideo,projectDescription,projectId)
		VALUES('','',$projectId)";
		$con->insert($insertQuery);
		$artical="";
		$artical="<html><head><style>.body{font-family:Arial, Helvetica, sans-serif; font-size:12px; }</style></head>";
		$artical.="<body><strong>Hello there! </strong><br />";
		$artical.="<br />We noticed you started a project on ".DISPLAYSITENAME." awesome. Whether you've been planning your project for months or you're just toying with the idea, here are some first steps to get you going:<br /><br />";
		$artical.="<br /><strong>1. Check out other projects</strong>";
		$artical.="<br />The easiest way to get inspiration for your own project is to look at others. Explore successful projects in your category, figure out what works and what doesn't, and take notes! <br /><br />";
		$artical.="<br /><strong>2. Become a backer </strong>";
		$artical.="<br />If you haven't done it already, find a project you like, and back it! Backing a project gives you a feel for the experience of supporting someone's work and going along for the ride. It's also a nice way to participate in the ".DISPLAYSITENAME." community.  <br /><br />";
		$artical.="<br /><strong>3. Visit ".DISPLAYSITENAME." School</strong>";
		$artical.="<br />We've compiled a series of tips and best practices for every step of your project's progress. At this stage in the game, our advice on Defining Your Project, Making Your Video, and Creating Rewards will probably be the most useful.<br /><br />";
		$artical.="<br /><strong>4. Show your friends</strong>";
		$artical.="<br />If you get stuck or just want a second opinion, having a friend look at what you've got can be really helpful and reassuring. Just click Get preview link at the top of your project preview and share the link to your project. <br /><br />";
		$artical.="<br />Keep in mind that every project is the story of someone pursuing something meaningful to them. You just need to tell yours!<br /><br />";
		$artical.="<br /><br />Best of luck with it!<br />".DISPLAYSITENAME." Team</body></html>";
		$subject="You have started a project on ".DISPLAYSITENAME."!";
		$mailbody=$artical;
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html\r\n";
		$headers .= FROMEMAILADDRESS;
			
		@mail(base64_decode($useremail['emailAddress']), $subject, $mailbody, $headers);
		
		print $_SESSION['projectId'];
	}
?>