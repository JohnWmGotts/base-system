<?php
//==================================================================
//
//
//===================================================================
//

class DB {

    var $db, $conn;
	static $rowrs;//record row	
	static $totalrows;// total rows
	static $Paging;// pagging values
	static $InfoArray;//return array
	static $depth = 1;					// Child level depth.
	static $top_level_on = 1;			// What top-level category are we on?
	static $exclude = array();			// Define the exclusion array
	var $country_lists;
	var $currencysym_lists;
	var $refconv_lists;

    public function __construct($server, $database, $username, $password){
		if(USE_PCONNECT)
		{
			$this->conn = mysql_pconnect($server, $username, $password);
		} 
		else
		{
			$this->conn = mysql_connect($server, $username, $password);
		}
        $this->db = mysql_select_db($database,$this->conn);
		$this->country_lists[0] = "US";
		$this->country_lists[1] = "IE";
		$this->country_lists[2] = "AT";
		$this->country_lists[3] = "AU";
		$this->country_lists[4] = "BE(Dutch)";
		$this->country_lists[5] = "BE(French)";
		$this->country_lists[6] = "INR";
		$this->country_lists[7] = "CA";
		$this->country_lists[8] = "SG";
		$this->country_lists[9] = "HK";
		$this->country_lists[10] = "FR";
		$this->country_lists[11] = "DE";
		$this->country_lists[12] = "IT";
		$this->country_lists[13] = "ES";
		$this->country_lists[14] = "CH";
		$this->country_lists[15] = "UK";
		$this->country_lists[16] = "NL";
		
		asort($this->country_lists);
		
		// Courrency Symbol List
		$this->currencysym_lists[0] = "$"; //US
		$this->currencysym_lists[1] = "&euro;"; //IE
		$this->currencysym_lists[2] = "&euro;"; //AT
		$this->currencysym_lists[3] = "AU $"; // AU
		$this->currencysym_lists[4] = "&euro;"; //BE (Dutch)
		$this->currencysym_lists[5] = "&euro;"; //BE (French)
		$this->currencysym_lists[6] = "Rs."; // IN
		$this->currencysym_lists[7] = "C $"; // CA
		$this->currencysym_lists[8] = "$"; // US (SG expired)
		$this->currencysym_lists[9] = "$"; // US (HK expired)
		$this->currencysym_lists[10] = "&euro;"; //FR
		$this->currencysym_lists[11] = "&euro;"; //DE
		$this->currencysym_lists[12] = "&euro;"; //IT
		$this->currencysym_lists[13] = "&euro;"; //ES
		$this->currencysym_lists[14] = "CHF"; //CH
		$this->currencysym_lists[15] = "&pound;"; // UK
		$this->currencysym_lists[16] = "&euro;"; //NL
		
		// Refrence Convert
		$this->refconv_lists[0] = "USD"; //US
		$this->refconv_lists[1] = "EUR"; //IE
		$this->refconv_lists[2] = "EUR"; //AT
		$this->refconv_lists[3] = "AUD"; // AU
		$this->refconv_lists[4] = "EUR"; //BE (Dutch)
		$this->refconv_lists[5] = "EUR"; //BE (French)
		$this->refconv_lists[6] = "INR"; // IN
		$this->refconv_lists[7] = "CAD"; // CA
		$this->refconv_lists[8] = "USD"; // UK (SG expired)
		$this->refconv_lists[9] = "USD"; // UK (HK expired)
		$this->refconv_lists[10] = "EUR"; //FR
		$this->refconv_lists[11] = "EUR"; //DE
		$this->refconv_lists[12] = "EUR"; //IT
		$this->refconv_lists[13] = "EUR"; //ES
		$this->refconv_lists[14] = "EUR"; //CH
		$this->refconv_lists[15] = "GBP"; // UK
		$this->refconv_lists[16] = "EUR"; //NL

    }
	/*funciton to insert the rows in tables*/
    public function insert($table, $insert_values) {

        foreach($insert_values as $key=>$value) {
            $keys[] = $key;
            $insertvalues[] = '\''.$value.'\'';
        }

        $keys = implode(',', $keys);
        $insertvalues = implode(',', $insertvalues);

        $sql = "INSERT INTO $table ($keys) VALUES ($insertvalues)";
       	if(mysql_query($sql))
		{
			return true;
		}
		else
		{
			return false;
		}

    }
	/*function to update the row of table*/
    public function update($table, $keyColumnName, $id, $update_values) {
        foreach($update_values as $key=>$value) {
            $sets[] = $key.'=\''.$value.'\'';
        }
        $sets = implode(',', $sets);
        $sql = "UPDATE $table SET $sets WHERE $keyColumnName = '$id'";
        mysql_query($sql);
    }
	public function updateByCondition($table,$keyColumnName,$condition)
	{
        foreach($keyColumnName as $key=>$value) {
            $sets[] = $key.'=\''.$value.'\'';
        }
        $sets = implode(',', $sets);
		foreach($condition as $key=>$value) {
			$i++;
			if(count($condition)>$i)
			{
				$conditionSets[] = $key.'='.$value.' AND';
			}
			else
			{
				$conditionSets[] = $key.'='.$value;
			}
		}
		$conditionSets = implode(' ', $conditionSets);
        $sql = "UPDATE $table SET $sets WHERE $conditionSets";
        mysql_query($sql);
		
	}
	/*function to delete the row of table*/
    public function deleteByCondition($table, $condition) 
	{
		foreach($condition as $key=>$value)
		{
			$i++;
			if(count($condition)>$i)
			{
				$conditionSets[] = $key.'='.$value.' AND';
			}
			else
			{
				$conditionSets[] = $key.'='.$value;
			}
		}
		$conditionSets = implode(' ', $conditionSets);
	  $sql = "DELETE from $table WHERE $conditionSets"; 
       mysql_query($sql);
    }
	public function delete($table, $keyColumnName, $id, $limit=1) {
		
	  $sql = "DELETE from $table WHERE $keyColumnName = '$id' LIMIT $limit"; 
       mysql_query($sql);
    }
	/*function to select the coloums/rows of table*/
	public function selectRows($fields='*', $table='users' ,$limit=10) {
		if(is_array($fields))
		{
			$fields = implode(",",$fields);
		}
	   $sql = "SELECT $fields from $table LIMIT $limit"; 
        $result = mysql_query($sql);
		$returnArray = array();
		while($row = mysql_fetch_assoc($result))
		{
			$returnArray[] = $row;
		}
		return $returnArray;
    }
	/*rows with pagging*/
	public function selectRowsByPagging($fields='*', $table ,$page=1,$perpage=10) {
		if(is_array($fields))
		{
			$fields = implode(",",$fields);
		}
	    $sql = "SELECT $fields from $table"; 
        $result = DB::select($sql,$page,$perpage,6,2,0);				
		$returnArray = array();
		if($result[0]>0)
		{
			while($row = mysql_fetch_array($result[1]))
			{
				$returnArray[] = $row;
			}
		}		
		return $returnArray;
    }
	
	/* To get the category image*/
	function categoryImage($catId)
	{		
		
		$table="productimages";
		$fields="*";
		$id='*';
		$key = array("productId"=>0,"approved" => 1, "isCategory"=>1,"categoryId"=>$catId);
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields);
		if(count($fetchUser)>0)
		{
			return $fetchUser;
		}
		else
		{
			$fetchUser[0]['image640By480']= "../images/default.gif";
			$fetchUser[0]['image640by480Height']= 480;
            $fetchUser[0]['image640by480Width'] = 640;
			$fetchUser[0]['image400by300'] ="../images/default.gif";;
            $fetchUser[0]['image400by300Height'] = 300;
            $fetchUser[0]['image400by300Width'] = 400;
            $fetchUser[0]['image100by80'] = "../images/default_100_75.gif";
            $fetchUser[0]['image100by80Height'] = 75;
            $fetchUser[0]['image100by80Width'] = 100;
			return $fetchUser;
		}
	}
	function serviceImage($catId)
	{		
		
		$table="productimages";
		$fields="*";
		$id='*';
		$key = array("productId"=>0,"approved" => 1, "isService" => 1, "isCategory"=>0,"categoryId"=>$catId);
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields);
		if(count($fetchUser)>0)
		{
			return $fetchUser;
		}
		else
		{
			$fetchUser[0]['image640By480']= "../images/default.gif";
			$fetchUser[0]['image640by480Height']= 480;
            $fetchUser[0]['image640by480Width'] = 640;
			$fetchUser[0]['image400by300'] ="../images/default.gif";;
            $fetchUser[0]['image400by300Height'] = 300;
            $fetchUser[0]['image400by300Width'] = 400;
            $fetchUser[0]['image100by80'] = "../images/default_100_75.gif";
            $fetchUser[0]['image100by80Height'] = 75;
            $fetchUser[0]['image100by80Width'] = 100;
			return $fetchUser;
		}
	}
	
	/*to get the category images**/
	function categoryIdToName($catId)
	{
		$table = 'categories';
		$fields = 'category_name';
		$id = $catId;
		$key = 'category_id';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['category_name'];
	}
	function storecategoryIdToName($catId)
	{
		$table = 'storecategory';
		$fields = 'name';
		$id = $catId;
		$key = 'cat_id';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['name'];
	}
	function serviceIdToName($catId)
	{
		$table = 'services';
		$fields = 'category_name';
		$id = $catId;
		$key = 'category_id';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['category_name'];
	}
	function getSellername($catId)
	{
		$table = 'users';
		$fields = 'firstName,secondName';
		$id = $catId;
		$key = 'userId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['firstName']." ".$fetchUser[0]['secondName'];
	}
	function getEbayname($catId)
	{
		$table = 'users';
		$fields = 'ebayUserName';
		$id = $catId;
		$key = 'userId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);
		if(count($fetchUser[0])>0)
		{
			return $fetchUser[0]['ebayUserName'];
		}
		else
		{
			return false;
		}
	}
	function getFreelancername($catId)
	{
		$table = 'users';
		$fields = 'freelancerUserName';
		$id = $catId;
		$key = 'userId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);
		if(count($fetchUser[0])>0)
		{
			return $fetchUser[0]['freelancerUserName'];
		}
		else
		{
			return false;
		}
	}
	function getElancename($catId)
	{
		$table = 'users';
		$fields = 'elanceUserName';
		$id = $catId;
		$key = 'userId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);
		if(count($fetchUser[0])>0)
		{
			return $fetchUser[0]['elanceUserName'];
		}
		else
		{
			return false;
		}
	}
	function getOdeskname($catId)
	{
		$table = 'users';
		$fields = 'odeskUserName';
		$id = $catId;
		$key = 'userId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);
		if(count($fetchUser[0])>0)
		{
			return $fetchUser[0]['odeskUserName'];
		}
		else
		{
			return false;
		}
	}
	function conditionIdToName($catId)
	{
		$table = 'productcondition';
		$fields = 'conditionText';
		$id = $catId;
		$key = 'conditionId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['conditionText'];
	}
	function itemIdToHandlingtime($catId)
	{
		$table = 'shippingdetails';
		$fields = 'handlingTime';
		$id = $catId;
		$key = 'productId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['handlingTime'];
	}
	function itemIdToExcludecountry($catId)
	{   
		$countryArry= array();
		$table = 'shippingdetails';
		$fields = 'excludedLocation';
		$id = $catId;
		$key = 'productId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);	
		$countryArry=explode(',',$fetchUser[0]['excludedLocation']);
		$contents="";	
		//print_r($countryArry); die();
		for($i=0; $i<count($countryArry); $i++)
		{
			$con_id= $countryArry[$i];
			if($con_id >0)
			  $contents.=$this->countryIdToName($con_id).",";  
			else
			  echo "";  
		}
		$contents = rtrim($contents,",");
		return $contents;
	}
	function userIdToName($catId)
	{
		$table = 'users';
		$fields = 'userName';
		$id = $catId;
		$key = 'userId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['userName'];
	}
	function itemIdToName($catId)
	{
		$table = 'trades';
		$fields = 'productName';
		$id = $catId;
		$key = 'tradeId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['productName'];
	}
	function IsUserExist($uid)
	{
		$table = "users";
		$fields = "*";
		$condition = array("userId" => $uid, "status" => 1);
		$users = $this->get_record_by_conditions($fields,$table,$condition,$limit=10);
		if($users == false)
		{
			return false;
		}
		else
		{
			return $users;
		}
		//$sql = "select userId from users where userId=".$uid." and status=1";
		
	}
	/* To get the country,city and state*/
	function countryIdToName($catId)
	{
		$table = 'countries';
		$fields = 'Country';
		$id = $catId;
		$key = 'CountryId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['Country'];
	}
	function stateIdToName($catId)
	{
		$table = 'regions';
		$fields = 'Region';
		$id = $catId;
		$key = 'RegionID';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['Region'];
	}
	function cityIdToName($catId)
	{
		$table = 'cities';
		$fields = 'City';
		$id = $catId;
		$key = 'CityId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['City'];
	}
	function productidToName($catId)
	{
		$table = 'trades';
		$fields = 'productName';
		$id = $catId;
		$key = 'tradeId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);		
		return $fetchUser[0]['productName'];
	}
	function productidToPrice($catId)
	{
		$table = 'trades';
		$fields = 'productPrice,discount';
		$id = $catId;
		$key = 'tradeId';
		$limit=1;
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields,$limit);
		$Initial_price=$fetchUser[0]['productPrice'];
		$discount_price=$fetchUser[0]['discount'];
		$final_price=$Initial_price-(($Initial_price*$discount_price)/100);		
		return $final_price;
	}
	function productidToShippincharge($catId)
	{
		$id=$catId;
		$table = "shippingdetails";
		$fields = "shippingCost";
		$keyColumnName = 'productId';
		$fetchUser = $this->get_record_by_ID($table,$keyColumnName,$id,$fields,$limit='10');
		$shipping_price=$fetchUser[0]['shippingCost'];
		return $shipping_price;
	}
	/* To get the product image*/
	function tradeImage($catId)
	{		
		
		$table="productimages";
		$fields="*";
		$id='*';
		$key = array("isCategory"=>0,"tradeId"=>$catId);
		$fetchUser = $this->get_record_by_ID_Pagging($table, $key, $id, $fields = "*",$page=1,$perpage=10);
		if(count($fetchUser)>0)
		{		
			return $fetchUser;
		}
		else
		{
			$fetchUser[0]['productImageId'] = 0;
			$fetchUser[0]['image640By480']= BASE_URL."images/default.gif";
			$fetchUser[0]['image640by480Height']= 480;
            $fetchUser[0]['image640by480Width'] = 640;
			$fetchUser[0]['image400by300'] =BASE_URL."images/default.gif";;
            $fetchUser[0]['image400by300Height'] = 300;
            $fetchUser[0]['image400by300Width'] = 400;
            $fetchUser[0]['image100by80'] = BASE_URL."images/default_100_75.gif";
            $fetchUser[0]['image100by80Height'] = 75;
            $fetchUser[0]['image100by80Width'] = 100;
			return $fetchUser;
		}
	}
	/*to get the product images**/
	/* To get the product image*/
	function productImage($catId)
	{		
		
		$table="productimages";
		$fields="*";
		$id='*';
		$key = array("isCategory"=>0,"tradeId"=>$catId);
		$fetchUser = $this->get_record_by_ID($table,$key,$id,$fields);
		if(count($fetchUser)>0)
		{		
			return $fetchUser;
		}
		else
		{
			$fetchUser[0]['image640By480']= "images/default.gif";
			$fetchUser[0]['image640by480Height']= 480;
            $fetchUser[0]['image640by480Width'] = 640;
			$fetchUser[0]['image400by300'] ="images/default.gif";;
            $fetchUser[0]['image400by300Height'] = 300;
            $fetchUser[0]['image400by300Width'] = 400;
            $fetchUser[0]['image100by80'] = "images/default_100_75.gif";
            $fetchUser[0]['image100by80Height'] = 75;
            $fetchUser[0]['image100by80Width'] = 100;
			return $fetchUser;
		}
	}
	/*to get the product images**/
	
	/*function to select the coloums/rows of table with order by clause*/
	public function selectRowsOrderBy($fields='*', $table='users' ,$limit=10,$orderByClause='',$order='ASC') {
		if(is_array($fields))
		{
			$fields = implode(",",$fields);
		}
		if($orderByClause=='')
		{
			die("Order By Clause Should Not Be Blanked");
		}
	    $sql = "SELECT $fields from $table ORDER BY $orderByClause $order LIMIT $limit"; 
        $result = mysql_query($sql);
		$returnArray = array();
		while($row = mysql_fetch_assoc($result))
		{
			$returnArray[] = $row;
		}
		return $returnArray;
    }
	/*function with pagging supported*/
	public function selectRowsOrderByPagging($fields='*', $table='users',$orderByClause='',$order='ASC',$page=1,$perpage=10) {
		if(is_array($fields))
		{
			$fields = implode(",",$fields);
		}
		if($orderByClause=='')
		{
			die("Order By Clause Should Not Be Blanked");
		}
	    $sql = "SELECT $fields from $table ORDER BY $orderByClause $order"; 
        $result = DB::select($sql,$page,$perpage,6,2,0);
		$returnArray = array();
		if($result[0]>0)
		{
			while($row = mysql_fetch_assoc($result[1]))
			{
				$returnArray[] = $row;
			}
		}
		return $returnArray;
    }
	public function selectRowsOrderIDByPagging($keyColumnName,$fields='*', $table='users',$orderByClause='',$order='ASC',$page=1,$perpage=10) {
		if(is_array($fields))
		{
			$fields = implode(",",$fields);
		}
		if(is_array($keyColumnName))
		{
			foreach($keyColumnName as $key=>$value) {
				$i++;
				if(count($keyColumnName)>$i)
				{
					$sets[] = $key.'='.$value.' AND';
				}
				else
				{
					$sets[] = $key.'='.$value;
				}
			}
			$sets = implode(' ', $sets);
			$sql = "SELECT $fields FROM $table WHERE ".$sets."ORDER BY ". $orderByClause." ".$order;
		}
		else
		{
			$sets = $keyColumnName;			
			$sql = "SELECT $fields FROM $table WHERE $sets = '$id'  ORDER BY $orderByClause $order"; 
		}		
		if($orderByClause=='')
		{
			die("Order By Clause Should Not Be Blanked");
		}
	    $sql = "SELECT $fields from $table"; 
        $result = DB::select($sql,$page,$perpage,6,2,0);
		$returnArray = array();
		if($result[0]>0)
		{
			while($row = mysql_fetch_assoc($result[1]))
			{
				$returnArray[] = $row;
			}
		}
		return $returnArray;
    }
	/*function to get the row of table by using the particular id*/
    public function get_record_by_ID($table, $keyColumnName, $id, $fields = "*",$limit=10){
		$i=0;
		///echo "hello";
		if(is_array($keyColumnName))
		{
			foreach($keyColumnName as $key=>$value) {
				$i++;
				if(count($keyColumnName)>$i)
				{
					$sets[] = $key.'='.$value.' AND';
				}
				else
				{
					$sets[] = $key.'='.$value;
				}
			}
			$sets = implode(' ', $sets);
			$sql = "SELECT $fields FROM $table WHERE ".$sets." LIMIT $limit";
		}
		else
		{
			$sets = $keyColumnName;			
			$sql = "SELECT $fields FROM $table WHERE $sets = '$id' LIMIT $limit"; 
		}		
        $result = mysql_query($sql);
        $returnArray = array();
		while($row = @mysql_fetch_assoc($result))
		{
			$returnArray[] = $row;
		}		
		return $returnArray;

    }
	public function get_record_by_ID_Pagging($table, $keyColumnName, $id, $fields = "*",$page=1,$perpage=10){
		$i=0;
		///echo "hello";
		if(is_array($keyColumnName))
		{
			foreach($keyColumnName as $key=>$value) {
				$i++;
				if(count($keyColumnName)>$i)
				{
					$sets[] = $key.'='.$value.' AND';
				}
				else
				{
					$sets[] = $key.'='.$value;
				}
			}
			$sets = implode(' ', $sets);
			$sql = "SELECT $fields FROM $table WHERE ".$sets;
		}
		else
		{
			$sets = $keyColumnName;			
			$sql = "SELECT $fields FROM $table WHERE $sets = '$id'"; 
		}
		//$sql = "SELECT $fields FROM $table WHERE $keyColumnName = '$id'";
        $result = DB::select($sql,$page,$perpage,6,2,0);
		$returnArray = array();
        if($result[0]>0)
		{
			while($row = mysql_fetch_assoc($result[1]))
			{
				$returnArray[] = $row;
			}
		}		
	return $returnArray;

    }
	public static function db_query($query)
	{
		$result = mysql_query($query);
		return $result;
	}
	public function get_record_by_conditions($fields,$table,$condition,$limit=10)
	{
		if(is_array($fields))
		{
			$fields = implode(",",$fields);
		}
		foreach($condition as $key=>$value) {
            $sets[] = $key.'=\''.$value.'\'';
        }
        $sets = implode(' and ', $sets);
		$query = "SELECT $fields FROM $table WHERE $sets LIMIT $limit";
		$result = mysql_query($query);
		if(mysql_num_rows($result)>0)
		{
			return mysql_fetch_assoc($result);
		}
		else
		{
			return false;
		}
		
		
	}
	/*function to get all the records on basis of the group*/
    public function get_records_by_group($table, $groupKeyName, $groupID, $orderKeyName = '', $order = 'ASC', $fields = '*',$limit=10){
        $orderSql = ' LIMIT $limit';
        if($orderKeyName != '') $orderSql = " ORDER BY $orderKeyName $order LIMIT $limit";
        $sql = "SELECT * FROM $table WHERE $groupKeyName = '$groupID'" . $orderSql;
        $result = mysql_query($sql);
        while($row = mysql_fetch_assoc($result)) {

            $records[] = $row;

        }
        return $records;
    }

    private function query($sql) {
        $return_result = mysql_query($sql, $this->conn);
        if($return_result) {
            return $return_result;
        } else {
            $this->sql_error($sql);
        }
    }

    private function sql_error($sql) {
        echo mysql_error($this->conn).'<br>';
        die('error: '. $sql);
    }
	/*funciton for the categories breadcrumbs dynamic*/
	public function categoryBreadcrumbs($sub_cat_id,$catt=0)
	{		
		if($catt==0)
		{
		$pa=$sub_cat_id;
		$count=0;
		while($pa!=0)
		{
			$query44="select * from `categories` where category_id=$pa";
			$res44=$this->query($query44);
			$row44=mysql_fetch_assoc($res44);
			$pa=$row44['parent_id'];
			if($sub_cat_id == $row44['category_id'])
			{
				$name_arr[$count]=$row44['category_name'];
			}
			else
			{
				$name_arr[$count]="<a href='category.php?catId=".base64_encode($row44['category_id'])."' class='link'>".$row44['category_name']."</a>";
			}											
			$count+=1;
		}
		}		
		return (@array_reverse($name_arr));
			
		}
		public function serviceBreadcrumbs($sub_cat_id,$catt=0)
	{		
		if($catt==0)
		{
		$pa=$sub_cat_id;
		$count=0;
		while($pa!=0)
		{
			$query44="select * from `services` where category_id=$pa";
			$res44=$this->query($query44);
			$row44=mysql_fetch_assoc($res44);
			$pa=$row44['parent_id'];
			if($sub_cat_id == $row44['category_id'])
			{
				$name_arr[$count]=$row44['category_name'];
			}
			else
			{
				$name_arr[$count]="<a href='service.php?catId=".base64_encode($row44['category_id'])."' class='link'>".$row44['category_name']."</a>";
			}											
			$count+=1;
		}
		}		
		return (@array_reverse($name_arr));
			
		}
/*funciton for the categories breadcrumbs dynamic*/
/* pagging function for the object oriented*/
	function onlyPagging($page,$per_page,$totallink,$dpaging = 0,$prevnext = 0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$temp_pagevars='')
	{
	  if($withpagging==1)
	   {
		   if($paggingtype=="get")
		   {
			  if($prevnext==1)
			  {
				  if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
					   /* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='$PHP_SELF?page=1".$extrapara."'>First</a>&nbsp;&nbsp;"; 
					  }
					   /* Print out our prev link */ 
					   if($this->InfoArray["PREV_PAGE"]) 
					   { 
						  //echo "<a class='link' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'>Previous</a>&nbsp;"; 
					   }
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  //echo "&nbsp;<a class='link' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
				   }
				}
			  
			   if($dpaging==1 || $dpaging==2)
			   {
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   echo "<table border='0' cellpadding='3' cellspacing='1'><tr>";
						   if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  	   { 
						  	echo "<td><a class='link_top' href='$PHP_SELF?".$this->Paging->PageVarName."=1".$extrapara."'>First</a></td>"; 
					  	   }
						   if($this->InfoArray["PREV_PAGE"]) 
					   	   { 
						  	echo "<td><a class='link_top' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'>Previous</a></td>"; //<img src='img/prev.png' border='0'/>
					       }
						   echo "<td><div class='b_pager'><table border='0' cellpadding='0' cellspacing='0'><tr>";
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								echo "<td align='center' width='20' height=18><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								 //echo $this->InfoArray["PAGE_NUMBERS"][$i] . ""; 
							  }
							  else
							  { 
								 echo "<td align='center' width='20' height=18><a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  } 
						  } 
						  echo "</tr></table></div></td>";
					   }
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  echo "<td><a class='link_top' href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a></td>"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					   if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  echo "<td><a class='link_top' href='$PHP_SELF?".$this->Paging->PageVarName."=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a></td></tr></table>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
			else
			{
				if($prevnext==1)
			    {
					/* Print out our prev link */ 
					   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
					   {
					   if($this->InfoArray["PREV_PAGE"]) 
					   { 
						  echo "<a class='link_top' href=javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].",'".$temp_pagevars."');><img src='images/bt_previous.gif' border='0' /></a>&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					   /* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  echo "&nbsp;<a class='bluelink' href=javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');><img src='images/bt_next.gif'  border='0' /></a>&nbsp;"; 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].",'".$temp_pagevars."');' class='link2'>Next >></a>&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   }
					  } 
				}			   
				if($dpaging==1 || $dpaging==2)
				{
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  //echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($InfoArray["PREV_PAGE"]) 
					   { 
						  //echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'>Previous</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   /* Example of how to print our number links! */ 
						   echo "<div class='b_pager'><table border='0' cellpadding='0' cellspacing='0'><tr>";
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								echo "<td align='center' width='20' height=18><b>".$this->InfoArray["PAGE_NUMBERS"][$i]."</b></td>"; 
								 //echo $this->InfoArray["PAGE_NUMBERS"][$i] . ""; 
							  }
							  else
							  { 
								 echo "<td align='center' width='20' height=18 ><a href=javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].",'".$temp_pagevars."');>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a></td>"; 
							  } 
						  } 
						  echo "</tr></table></div>";
						   
						 /*  for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } */
					   }
					   /* Print out our next link */ 
					   if($InfoArray["NEXT_PAGE"]) { 
						 // echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					   if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  //echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
		}
	}
	function select($qy,$page,$per_page,$totallink,$dpaging=0,$withpagging = 1,$extrapara='',$paggingtype='get',$paggingfunction='',$paggingvar='page')
	{
	/*
		$dpaging is for whether we want to display paging or not
		0 means paging not display
		1 means short paging only next,previous not number paging
		2 means long paging display 
		
		$paggingfunction
		name of javascript function		
	*/
		$rs=mysql_query($qy) or die(mysql_error()."<br>".$qy);
		$num_rows = mysql_num_rows($rs);
		$this->totalrows=$num_rows;
		$iarry[0]=$num_rows;
		$page = $page;

		$prev_page = $page - 1; 
		$next_page = $page + 1;
		$page_start = ($per_page * $page) - $per_page;
		$pageend=0;
		
		if ($num_rows <= $per_page) { 
			$num_pages = 1; 
		} else if (($num_rows % $per_page) == 0) { 
			$num_pages = ($num_rows / $per_page); 
		} else { 
			$num_pages = ($num_rows / $per_page) + 1; 
		} 
		$num_pages = (int) $num_pages; 
		if (($page > $num_pages) || ($page < 0))
		{ 
			//echo ("You have specified an invalid page number"); 
		}
		
		if($num_rows>0)
		{
			$pagestart=0;
			$pageend=0;
			$pagestart = (($page-1) * $per_page)+1;
			if($num_pages == $page)
			{
				$pageend = $num_rows;
			}
			else
			{
				$pageend = $pagestart + ($per_page - 1);
			}
		}
		
		/* Instantiate the paging class! */ 
	   $this->Paging = new PagedResults(); 
	
	   /* This is required in order for the whole thing to work! */ 
	   $this->Paging->TotalResults = $num_pages; 
	
	   /* If you want to change options, do so like this INSTEAD of changing them directly in the class! */ 
	   $this->Paging->ResultsPerPage = $per_page; 
	   $this->Paging->LinksPerPage = $totallink; 
	   $this->Paging->PageVarName = $paggingvar;
	   $this->Paging->TotalResults = $num_rows; 
	   if($paggingtype!="get")
	   {
		   	$this->Paging->PagePaggingType="post";
	   }
	
	   /* Get our array of valuable paging information! */ 
	   $this->InfoArray = $this->Paging->InfoArray(); 
	   
	   $qy1=$qy." LIMIT $page_start, $per_page ";
	   $rowrs=mysql_query($qy1) or die(mysql_error()."<br>".$qy1);
	   
	   if($withpagging==1)
	   {
		   if($paggingtype=="get")
		   {
			   if($dpaging==1 || $dpaging==2)
			   {
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=1".$extrapara."'>First</a> | &nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					/* Print out our next link */ 
					   if($this->InfoArray["NEXT_PAGE"]) { 
						  echo " <a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["NEXT_PAGE"].$extrapara."'>Next</a>&nbsp;&nbsp;"; 
					   } else { 
						  echo " Next&nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PAGE_NUMBERS"][$i].$extrapara."'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } 
					   }
					   /* Print out our prev link */ 
					   if($this->InfoArray["PREV_PAGE"]) 
					   { 
						  echo "<a href='$PHP_SELF?".$this->Paging->PageVarName."=".$this->InfoArray["PREV_PAGE"].$extrapara."'>Previous</a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						  echo "Previous | &nbsp;&nbsp;"; 
					   } 
					   /* Print our last link */ 
					   if($InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  echo " <a href='$PHP_SELF?".$this->Paging->PageVarName."=" . $this->InfoArray["TOTAL_PAGES"].$extrapara."'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
			else
			{
				if($dpaging==1 || $dpaging==2)
				{
				   if (count($this->InfoArray["PAGE_NUMBERS"])>1)
				   {
						/* Print our first link */ 
					  if($this->InfoArray["CURRENT_PAGE"]!= 1) 
					  { 
						  echo "<a href='javascript:".$paggingfunction."(1);'>First</a>&nbsp;&nbsp;"; 
					  }
					  else
					  { 
						  //echo "&lt;&lt;&nbsp;&nbsp;&nbsp;"; 
					  }
					
					   /* Print out our prev link */ 
					   if($InfoArray["PREV_PAGE"]) 
					   { 
						  echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PREV_PAGE"].");'><img src='images/bt_previous.gif' border='0' /></a> | &nbsp;&nbsp;"; 
					   }
					   else
					   { 
						 // echo "Previous | &nbsp;&nbsp;"; 
					   } 
					
						if($dpaging==2)
						{
						   /* Example of how to print our number links! */ 
						   for($i=0; $i<count($this->InfoArray["PAGE_NUMBERS"]); $i++) 
						   { 
							  if($this->InfoArray["CURRENT_PAGE"] == $this->InfoArray["PAGE_NUMBERS"][$i])
							  { 
								 echo $this->InfoArray["PAGE_NUMBERS"][$i] . " | "; 
							  }
							  else
							  { 
								 echo "<a href='javascript:".$paggingfunction."(".$this->InfoArray["PAGE_NUMBERS"][$i].");'>".$this->InfoArray["PAGE_NUMBERS"][$i]."</a> | "; 
							  } 
						  } 
					   }
					   /* Print out our next link */ 
					   if($InfoArray["NEXT_PAGE"]) { 
						  echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'><img src='images/bt_next.gif'  border='0' /></a>&nbsp;&nbsp;"; 
					   } else { 
						  //echo " Next&nbsp;&nbsp;"; 
					   } 
					
					   /* Print our last link */ 
					   if($this->InfoArray["CURRENT_PAGE"]!= $this->InfoArray["TOTAL_PAGES"])
					   { 
						  echo " <a href='javascript:".$paggingfunction."(".$this->InfoArray["NEXT_PAGE"].");'>Last</a>"; 
					   }
					   else
					   { 
						  //echo " &gt;&gt;"; 
					   }
					
					}
				}
			}
		}
		$page_start = ($per_page * $page) - $per_page;
		$iarry[1]=$rowrs;
		$iarry[2]=$page_start+1;
		$iarry[3]=$pageend;
		return $iarry;			
	}
	//function for selecting records & paging
	function highlight_this($text, $words)
	{
		$words = trim($words);
		$the_count = 0;
		$wordsArray = explode(' ', $words);
			foreach($wordsArray as $word) {
			 if(strlen(trim($word)) != 0)
			
			 //exclude these words from being replaced
			 $exclude_list = array("word1", "word2", "word3");
			// Check if it's excluded
			if($word!="")
			{
			if ( in_array( strtolower($word), $exclude_list ) ) {
	   
			} else {
				//$text = str_replace($word, "<span class=\"highlight\">".$word."</span>", $text, $count);
		//		$text = str_replace($word, "<span class=\"highlight\">".$word."</span>", $text);
				$text = preg_replace ( "/".$word."/i", "<span class=\"highlight\">".$word."</span>", $text );
				//$the_count = $count + $the_count;
				}
			}
			   
		}
		//added to show how many keywords were found
		//echo "<br><div class=\"emphasis\">A search for <strong>" . $words. "</strong> found <strong>" . $the_count . "</strong> matches within the " . $the_place. ".</div><br>";
	   
		return $text;
	}
public function add_file($no,$p_tupe)
	{
		$qry1="select * from photo_dir where dir_type='$p_tupe'";
		$rs1=mysql_query($qry1);
		$row=mysql_fetch_array($rs1);
		$old_no=$row["files"];
		$new_no=$old_no+$no;		
		$qry2="update photo_dir set files=".$new_no." where dir_type='$p_tupe'";
		$rs2=mysql_query($qry2);
	}
	
	/*function to dedeuct file in photo directory 
	$no=no of photo,$p_type=profile type*/
	
	public function deduct_file($no,$p_tupe)
	{
		$qry1="select * from photo_dir where dir_type='$p_tupe'";
		$rs1=mysql_query($qry1);
		$row=mysql_fetch_array($rs1);
		$old_no=$row["files"];
		$new_no=$old_no-$no;		
		$qry2="update photo_dir set files=".$new_no." where dir_type='$p_tupe'";
		$rs2=mysql_query($qry2);
	}
	public function currency_convert($from,$to,$tempprice)
	{		
		$table = 'convert_currency';
		$field = 'cprice';
		$key = 'ccode';
		$from_array = $this->get_record_by_ID($table, $key, $from, $field,1);
		$from_rat = $from_array[0]['cprice'];
		$table = 'convert_currency';
		$field = 'cprice';
		$key = 'ccode';
		$to_array = $this->get_record_by_ID($table, $key, $to, $field,1);
		$to_rat = $to_array[0]['cprice'];
		$symbol = $this->currencysym_lists[array_search($to,$this->country_lists)];	
		return $symbol."".number_format(round($tempprice * ($to_rat/$from_rat),2),2);		
	}
	public function currency_convert_withoutSymbol($from,$to,$tempprice)
	{		
		$table = 'convert_currency';
		$field = 'cprice';
		$key = 'ccode';
		$from_array = $this->get_record_by_ID($table, $key, $from, $field,1);
		$from_rat = $from_array[0]['cprice'];
		$table = 'convert_currency';
		$field = 'cprice';
		$key = 'ccode';
		$to_array = $this->get_record_by_ID($table, $key, $to, $field,1);
		$to_rat = $to_array[0]['cprice'];
		$symbol = $this->currencysym_lists[array_search($to,$this->country_lists)];	
		return number_format(round($tempprice * ($to_rat/$from_rat),2),2);		
	}
	public function currency_Symbol()
	{
		return $this->currencysym_lists[array_search($to,$this->country_lists)];	
	}
}

/*class for pagging*/
class PagedResults { 

   /* These are defaults */ 
   var $TotalResults; 
   var $CurrentPage = 1; 
   var $PageVarName = "page";
   var $PagePaggingType = "get"; 
  // var $ResultsPerPage = 20; 
   var $ResultsPerPage = 12; 
   var $LinksPerPage = 15; 

   function InfoArray() { 
      $this->TotalPages = $this->getTotalPages(); 
      $this->CurrentPage = $this->getCurrentPage(); 
      $this->ResultArray = array( 
                           "PREV_PAGE" => $this->getPrevPage(), 
                           "NEXT_PAGE" => $this->getNextPage(), 
                           "CURRENT_PAGE" => $this->CurrentPage, 
                           "TOTAL_PAGES" => $this->TotalPages, 
                           "TOTAL_RESULTS" => $this->TotalResults, 
                           "PAGE_NUMBERS" => $this->getNumbers(), 
                           "MYSQL_LIMIT1" => $this->getStartOffset(), 
                           "MYSQL_LIMIT2" => $this->ResultsPerPage, 
                           "START_OFFSET" => $this->getStartOffset(), 
                           "END_OFFSET" => $this->getEndOffset(), 
                           "RESULTS_PER_PAGE" => $this->ResultsPerPage, 
                           ); 
      return $this->ResultArray; 
   } 

   /* Start information functions */ 
   function getTotalPages() { 
      /* Make sure we don't devide by zero */ 
      if($this->TotalResults != 0 && $this->ResultsPerPage != 0) { 
         $result = ceil($this->TotalResults / $this->ResultsPerPage); 
      } 
      /* If 0, make it 1 page */ 
      if(isset($result) && $result == 0) { 
         return 1; 
      } else { 
         return $result; 
      } 
   } 

   function getStartOffset() { 
      $offset = $this->ResultsPerPage * ($this->CurrentPage - 1); 
      if($offset != 0) { $offset++; } 
      return $offset; 
   } 

   function getEndOffset() { 
      if($this->getStartOffset() > ($this->TotalResults - $this->ResultsPerPage)) { 
         $offset = $this->TotalResults; 
      } elseif($this->getStartOffset() != 0) { 
         $offset = $this->getStartOffset() + $this->ResultsPerPage - 1; 
      } else { 
         $offset = $this->ResultsPerPage; 
      } 
      return $offset; 
   } 

   function getCurrentPage() { 
	  if($this->PagePaggingType=="get")
	  {
		  if(isset($_GET[$this->PageVarName])) { 
    	     return $_GET[$this->PageVarName]; 
	      } else { 
    	     return $this->CurrentPage; 
	      } 
	  }
	  else
	  {
	  	if(isset($_POST[$this->PageVarName])) { 
    	     return $_POST[$this->PageVarName]; 
	      } else { 
    	     return $this->CurrentPage; 
	      }
	  }
   } 

   function getPrevPage() { 
      if($this->CurrentPage > 1) { 
         return $this->CurrentPage - 1; 
      } else { 
         return false; 
      } 
   } 

   function getNextPage() { 
      if($this->CurrentPage < $this->TotalPages) { 
         return $this->CurrentPage + 1; 
      } else { 
         return false; 
      } 
   } 

   function getStartNumber() { 
      $links_per_page_half = $this->LinksPerPage / 2; 
      /* See if curpage is less than half links per page */ 
      if($this->CurrentPage <= $links_per_page_half || $this->TotalPages <= $this->LinksPerPage) { 
         return 1; 
      /* See if curpage is greater than TotalPages minus Half links per page */ 
      } elseif($this->CurrentPage >= ($this->TotalPages - $links_per_page_half)) { 
         return $this->TotalPages - $this->LinksPerPage + 1; 
      } else { 
         return $this->CurrentPage - $links_per_page_half; 
      } 
   } 

   function getEndNumber() { 
      if($this->TotalPages < $this->LinksPerPage) { 
         return $this->TotalPages; 
      } else { 
         return $this->getStartNumber() + $this->LinksPerPage - 1; 
      } 
   } 

   function getNumbers() { 
      for($i=$this->getStartNumber(); $i<=$this->getEndNumber(); $i++) { 
         $numbers[] = $i; 
      } 
      return $numbers; 
   } 
} 

?>
