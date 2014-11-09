<?php
	require_once("../includes/config.php");
	
	if($_SESSION["admin_user"]=="")
	{
		print "<META http-equiv='refresh' content='0;URL=".SITE_ADM."index.php'>";
		exit;
	}
	
	// Delete Image code start
	if(isset($_GET['action']) && $_GET['action']=='delete') {
		/*$qry="UPDATE image SET status=0 WHERE id='".$_GET['id']."'";
		$con->update($qry);
		redirectPage(SITE_ADM."image.php?msg=DEL");		*/
	}
	// Delete Image code end
	
	// Form Post code start
	if(isset($_POST['action'])) {
		print_r($_POST);exit;
		extract($_POST);
		$obj = new validation();
		if($action=='add')
			$obj->add_fields($con_key, 'req', ER_KEY);
		$obj->add_fields($con_value, 'req', ER_VALUE);
		$error = $obj->validate();
	
		if($error=='') {
			if($action=='add') {
				$insert="INSERT INTO image (con_key,con_value,status,created) VALUES('".$con_key."','".$con_value."','".$status."','".date("Y-m-d H:i:s")."')";
				$con->insert($insert);
				$msg='ADD';
			} else if($action=='edit') {
				$update="UPDATE image SET con_value='".$con_value."', status='".$status."' WHERE id='".$id."'";
				$con->update($update);
				$msg='EDIT';
			}
			redirectPage(SITE_ADM."image.php?msg=".$msg);
		}
	}
	// Form Post code end
	
	// Image Edit select query code start
	if(isset($_GET['action']) && $_GET['action']=='edit') {
		$eqry="SELECT * FROM image WHERE id='".$_GET['id']."'";
		$eres=$con->recordselect($eqry);
		$erow=mysql_fetch_array($eres);
		extract($erow);
	}
	// Image Edit select query code end
	
	// Image listing select query, pagging, sorting code start
	if(! isset($_GET['action'])) {
		$extra='';
		$page=1;
		$per_page=10;
		
		// Sorting Code
		if(isset($_GET['sort']) && isset($_GET['field'])) {
			$extra='&field='.$_GET['field'].'&sort='.$_GET['sort'];
			$or_qry=$_GET['field'].' '.$_GET['sort'];
		} else {
			$or_qry='id DESC';
		}
		
		// Pagging Code
		if($_GET['ppage']!="" && is_numeric($_GET['ppage']))
		{
			$extra.="&ppage=".$_GET['ppage'];
			$per_page=$_GET['ppage'];
		}
		if(isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$page=$_GET['page'];
		}		
		
		$qry="SELECT id,name,ori_name,if(status=0,'Deactive','Active') AS status FROM image ORDER BY ".$or_qry;
		$arr_rs=$con->select($qry,$page,$per_page,8,2,0,$extra);
		$tot=$arr_rs[0];
	}
	// Image listing select query code end
	
	$content="image";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>