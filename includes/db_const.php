<?php
	$const_qry="SELECT con_key,con_value FROM constant WHERE status=1";
	$const_res=$con->recordselect($const_qry);
	if(mysql_num_rows($const_res)>0) {
		while($const_row=mysql_fetch_array($const_res)) {
			define(strtoupper($const_row['con_key']),$const_row['con_value']);
		}
	}
?>