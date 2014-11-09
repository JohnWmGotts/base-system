<?php
	require_once("../includes/config.php");
	$pagetitle = 'Manage Contents';
	
	if(isset($_GET['action'])) {
		extract($_GET);
	}
	
	// Delete Content code start
	if(isset($_GET['action']) && $_GET['action']=='delete') {
		// Delete Query HERE
	}
	// Delete Content code end
	
	// Form Post code start
	if(isset($_POST['action']) && ($_POST['action']=='edit')) {
		//print_r($_POST);
		extract($_POST);
		// Validation
		$obj = new validation();
		$obj->add_fields($title, 'req', ER_PAGETIT);
		$obj->add_fields($meta_author, 'req', ER_METAAU);
		$obj->add_fields($meta_keyword, 'req', ER_METAKEY);
		$obj->add_fields($meta_desc, 'req', ER_METADESC);
		
		$error = $obj->validate();
		// Add / Edit Query Code Start
		if($error=='') {
			/*if($action=='add') {
				$insert="INSERT INTO content (title,ar_title,meta_author,ar_meta_athor,meta_keyword,ar_meta_keyword,meta_desc,ar_meta_desc,description,ar_description,status,created,ipaddress) VALUES ('".addslashes($title)."','".addslashes($ar_title)."','".addslashes($meta_author)."','".addslashes($ar_meta_author)."','".addslashes($meta_keyword)."','".addslashes($ar_meta_keyword)."','".addslashes($meta_desc)."','".addslashes($ar_meta_desc)."','".addslashes($description)."','".addslashes($ar_description)."','".$status."',CURRENT_TIMESTAMP,'".get_ip_address()."')";
				$con->insert($insert);
				$msg='ADD';
			} else*/ if($action=='edit') {	
			    $table='content';
				$keyColumnName='id';
				$id=$id;
				$update_values=array("title"=>addslashes($title),"meta_author"=>addslashes($meta_author),"meta_keyword"=>addslashes($meta_keyword),"meta_desc"=>addslashes($meta_desc),"description"=>addslashes($description),"status"=>$status);
				$updateQuery = "update content set title='".addslashes($title)."' , meta_author = '".addslashes($meta_author)."' , meta_keyword ='".addslashes($meta_keyword)."', meta_desc = '".addslashes($meta_desc)."', description = '".addslashes($description)."', status = '".$status."' where id=".$id." Limit 1";
				$con->update($updateQuery);
				$msg='EDIT';
			}
			redirect(SITE_ADM."static_content.php?msg=".$msg);
		} // Add / Edit Query Code End
	}
	// Form Post code end
	
	// Content Edit select query code start
	if(isset($_GET['action']) && ($_GET['action']=='edit' || $_GET['action']=='view')) {
		$action=$_GET['action'];
		$table='content';
		$fields='*';
		$keyColumnName='id';
		$id=$_GET['id'];
		$get_content_detail = mysql_fetch_assoc($con->recordselect("SELECT * from content where id=".$id));
		//$get_content_detail=$con->get_record_by_ID($table, $keyColumnName, $id, $fields,$limit=1);
		//$erow=mysql_fetch_array($eres);
		//extract($get_content_detail[0]);
	}
	// Content Edit select query code end
	
	// Content listing select query, pagging, sorting code start
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
		if(!isset($_GET) || !isset($_GET['page']) || $_GET['page']=='' || $_GET['page']<0 || !is_numeric($_GET['page']) || $_GET['page']==0)
		{
			$page=1;
			$_GET['page']=1;
		}
		else
		{
			$page = $_GET['page'];
		}
		$qry="SELECT id,module,title,if(status='1','Active','Deactive') AS status FROM content ORDER BY ".$or_qry;
		$arr_rs=$con->recordselect($qry);
		//$tot=$arr_rs[0];
	}
	// Content listing select query, pagging, sorting code end
	
	$content="static_content";
	require_once(DIR_ADM_TMP."main_page.tpl.php");
?>