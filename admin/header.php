<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo ($file=='login.php')?'Admin Login - '.DISPLAYSITENAME.'' : $pagetitle.' | '.DISPLAYSITENAME.' Admin Panel';?></title>
<link href="<?php echo SITE_CSS;?>admin_style.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="<?php echo SITE_IMG; ?>favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo SITE_IMG; ?>favicon.png" type="image/x-icon" />
<script type="text/javascript" src="<?php echo SITE_JS;?>jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_JS; ?>ui/jquery-ui-1.8.21.custom.js"></script>
<script type="text/javascript" src="<?php echo SITE_JAVA;?>jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_JAVA;?>admin.js"></script>
</head>
<body>

<!--Main table Start-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <!--header Start-->
  <tr>
    <td valign="top">
    <div class="menu_bar">
        <div class="left_menu">
            <ul>
                <li><a title="NCrypted" class="logo_icon" href="http://www.ncrypted.com/" target="_blank"></a></li>
                <li><div class="site_name"><a title="<?php echo DISPLAYSITENAME; ?>" href="<?php print SITE_URL;?>" target="_blank"><?php echo DISPLAYSITENAME; ?></a></div></li>
            </ul>
        </div>
        <div class="right_nav">
            <?php if($file=='login.php'){ echo '&nbsp;';} else { ?>
            	<?php echo ucfirst($_SESSION["admin_user"]); ?>,
                <a title="Logout" href="<?php echo SITE_ADM;?>logoffadmin.php"> Logout</a>
           
		  <?php } ?>
        </div>
    </div>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="header">
        <tr>
          <td valign="middle" align="left" width="50%" style="padding-left: 15px;">
          	<a href="<?php echo SITE_ADM;?>home.php" title="<?php echo DISPLAYSITENAME; ?>">
          		<img src="<?php echo SITE_ADM_IMG;?>logoc.png" alt="<?php echo DISPLAYSITENAME; ?>" border="0" />
            </a>
          </td>
          <td valign="top" align="right" width="50%" class="headerright">
		  <?php if($file=='login.php'){ echo '&nbsp;';} else { ?>
          	<ul>
            	<?php /*?><li><a href="<?php echo SITE_ADM;?>logoffadmin.php">Log Out</a></li><?php */?>
                <?php /*?><li>Welcome, <?php echo $_SESSION["admin_user"]; ?></li><?php */?>
                <li><b>Login From:</b> <?php echo $_SERVER['REMOTE_ADDR']; ?></li>
                <li><b>Date :</b> <?php $cur_times=time(); echo date ("Y-m-d H:i a",$cur_times); ?></li>
            </ul>
		  <?php } ?>
          </td>
        </tr>
      </table></td>
  </tr>
  <!--header end-->
  <!--content Start-->
  <tr>
    <td valign="top">
<?php if($file!='login.php') { ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td class="content-left-bg"></td>
	  <td valign="top" class="content-login">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="10" colspan="3"></td>
		  </tr>
		  <tr>
			<td width="193" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td width="10" align="left"><img src="<?php echo SITE_ADM_IMG;?>title-left.gif" alt="img" /></td>
							<td class="title-bg">Admin Task</td>
							<td width="10" align="right"><img src="<?php echo SITE_ADM_IMG;?>title-right.gif" alt="img" /></td>
						  </tr>
						</table>
					</td>
				  </tr>
				  <tr>
					<td valign="top" class="leftmenu">
						<?php require_once(DIR_ADM."menu.php");?>
					</td>
				  </tr>                      
				</table>
			</td>
			<td width="10"></td>
			<td valign="top">
<?php } ?>	
