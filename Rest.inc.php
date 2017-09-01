<?php
	/* File : Rest.inc.php
	 * Author : Anuj Shah
	 * 
	*/
	class REST {
	    // Database credentials
	    private $_sHost 		= "localhost";
	    private $_sDBName 		= "shopping_cart";
	    private $_sUserName 	= "root";
	    private $_sPassword 	= "anujshah";
		private $_iCode 		= 200;

		public $_sContentType 	= "application/json";
		public $_arrRequest 	= array();
		
		public function __construct()
		{
			$this->inputs();
			$this->_arrCon=$this->dbConnect();	// Initiate Database connection
		}
		
	    /**
	        * Function Name : inputs
	        * inputs function used check input method and store data in var
	        *
	        * @return array
	    */
		private function inputs()
		{
			switch($this->get_request_method()){
				case "POST":
					$this->_arrRequest = $this->cleanInputs($_POST);
					break;
				case "GET":
				case "DELETE":
					$this->_arrRequest = $this->cleanInputs($_GET);
					break;
				case "PUT":
					parse_str(file_get_contents("php://input"),$this->_arrRequest);
					$this->_arrRequest = $this->cleanInputs($this->_arrRequest);
					break;
				default:
					$this->method_not_allowed();
					break;
			}
		}

	    /**
	        * Function Name : get_request_method
	        * get_request_method function used to return request method
	        *
	        * @return string
	    */
		public function get_request_method()
		{
			return $_SERVER['REQUEST_METHOD'];
		}

	    /**
	        * Function Name : cleanInputs
	        * cleanInputs function used to clean string
	        *
	        * @return array
	    */
		private function cleanInputs($arrData)
		{
			$arrCleanInput = array();
			if(is_array($arrData)){
				foreach($arrData as $k => $v){
					$arrCleanInput[$k] = $this->cleanInputs($v);
				}
			}else{
				if(get_magic_quotes_gpc()){
					$arrData = trim(stripslashes($arrData));
				}
				$arrData = strip_tags($arrData);
				$arrCleanInput = trim($arrData);
			}
			return $arrCleanInput;
		}

	    /**
	        * Function Name : dbConnect
	        * dbConnect function used to connect db
	        *
	        * @return array
	    */
		private function dbConnect()
		{
			/*
			$arrCon=new PDO("mysql:host={$this->_sHost};dbname={$this->_sDBName}", $this->_sUserName,$this->_sPassword,
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			return $arrCon;
			*/
			 $arrCon = mysqli_connect($this->_sHost,$this->_sUserName,$this->_sPassword,$this->_sDBName);
			if (mysqli_connect_errno()){
		  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  		exit;
		  	}else{
		  		return $arrCon;
		  	}
		}

	    /**
	        * Function Name : response
	        * response function used to set headers and print it
	        *
	        * @return array
	    */
		public function response($arrData,$iStatus)
		{
			$this->_iCode = ($iStatus)?$iStatus:200;
			$this->set_headers();
			echo $arrData;
			exit;
		}

	    /**
	        * Function Name : get_status_message
	        * get_status_message function used to store diff http code
	        *
	        * @return string
	    */		
		private function get_status_message()
		{
			$iStatus = array(
						100 => 'Continue',  
						101 => 'Switching Protocols',  
						200 => 'OK',
						201 => 'Created',  
						202 => 'Accepted',  
						203 => 'Non-Authoritative Information',  
						204 => 'No Content',  
						205 => 'Reset Content',  
						206 => 'Partial Content',  
						300 => 'Multiple Choices',  
						301 => 'Moved Permanently',  
						302 => 'Found',  
						303 => 'See Other',  
						304 => 'Not Modified',  
						305 => 'Use Proxy',  
						306 => '(Unused)',  
						307 => 'Temporary Redirect',  
						400 => 'Bad Request',  
						401 => 'Unauthorized',  
						402 => 'Payment Required',  
						403 => 'Forbidden',  
						404 => 'Not Found',  
						405 => 'Method Not Allowed',  
						406 => 'Not Acceptable',  
						407 => 'Proxy Authentication Required',  
						408 => 'Request Timeout',  
						409 => 'Conflict',  
						410 => 'Gone',  
						411 => 'Length Required',  
						412 => 'Precondition Failed',  
						413 => 'Request Entity Too Large',  
						414 => 'Request-URI Too Long',  
						415 => 'Unsupported Media Type',  
						416 => 'Requested Range Not Satisfiable',  
						417 => 'Expectation Failed',  
						500 => 'Internal Server Error',  
						501 => 'Not Implemented',  
						502 => 'Bad Gateway',  
						503 => 'Service Unavailable',  
						504 => 'Gateway Timeout',  
						505 => 'HTTP Version Not Supported');
			return ($iStatus[$this->_iCode])?$iStatus[$this->_iCode]:$iStatus[500];
		}		
		
	    /**
	        * Function Name : set_headers
	        * set_headers function used to set headers
	        *
	    */		
		private function set_headers()
		{
			header("HTTP/1.1 ".$this->_iCode." ".$this->get_status_message());
			header("Content-Type:".$this->_sContentType);
		}

	    /**
	        * Function Name : json
	        * json function used to encode array to json
	        *
	        * @return json
	    */	
		public function json($arrData)
		{
			if(is_array($arrData)){
				return json_encode($arrData);
			}
		}

	    /**
	        * Function Name : validation
	        * validation function used to validate required field
	        *
	        * @return json
	    */	
		public function validation($arrRequired)
		{
			//Check each field is not empty
			$bError = FALSE;
			$iStatus=$sMessage="";
			foreach($arrRequired as $sField){
			  	if(empty($this->_arrRequest[$sField])){
			    	$bError 	= TRUE;
			  		$iStatus  	= "False";
			  		$sMessage 	= "All fields are required";
			    	break;
			  	}
			  	if($sField=='iCategoryId' || $sField=='iProductId'){
			  		if($this->_arrRequest[$sField]<=0){
			  			$bError   = TRUE;
			  			$iStatus  = "False";
			  			$sMessage = "id is invalid";
			  			break;
			  		}
			  	}
			}

			if($bError){
				$arrResponse['status']	= $iStatus;
				$arrResponse['message']	= $sMessage;
				$this->response($this->json($arrResponse), 200);
			}
			return TRUE;
		}

	    /**
	        * Function Name : method_not_allowed
	        * method_not_allowed function used to display not allowed method error
	        *
	        * @return json
	    */	
		public function method_not_allowed()
		{
			$arrResponse['status']	= 'False';
			$arrResponse['message']	= 'Method not allowed';
			$this->response($this->json($arrResponse),406);
		}

	    /**
	        * Function Name : method_not_found
	        * method_not_found function used to display not found method error
	        *
	        * @return json
	    */
		public function method_not_found()
		{
			$arrResponse['status']	= 'False';
			$arrResponse['message']	= 'Method not found';
			$this->response($this->json($arrResponse),406);
		}

	    /**
	        * Function Name : InsertRecord
	        * InsertRecord function used to insert record to db
	        *
	        * @return int
	    */
		public function InsertRecord($sTableName, array $arrValues)
		{
			$iInsertId=0;	
			if(!empty($arrValues)){
				$sQueryString = "insert into ".$sTableName." set ";

				foreach($arrValues as $key=>$value){
					$sQueryString.=$key." = '".addslashes(mysqli_real_escape_string($this->_arrCon,$value))."' , ";	
				}

				$sQueryString = trim($sQueryString," , ");
				mysqli_query($this->_arrCon,$sQueryString);
				$iInsertId = mysqli_insert_id($this->_arrCon);
				mysqli_close($this->_arrCon);
			}
			return $iInsertId;
		}

	    /**
	        * Function Name : UpdateRecord
	        * UpdateRecord function used to update record to db
	        *
	        * @return int
	    */
		public function UpdateRecord($sTableName,array $arrValues,$sWhere="")
		{
			$iTotalUpdated=0;
			if(!empty($arrValues)){
				$sQueryString = "update ".$sTableName." set ";

				foreach($arrValues as $key=>$value){
					$sQueryString.=$key." = '".addslashes(mysqli_real_escape_string($this->_arrCon,$value))."' , ";
				}
				
				$sQueryString = trim($sQueryString," , ");

				if($sWhere!=""){
					$sQueryString.=" where ".$sWhere;
				}
				
				mysqli_query($this->_arrCon,$sQueryString);
				$iTotalUpdated = mysqli_affected_rows($this->_arrCon);
				mysqli_close($this->_arrCon);
			}
			return $iTotalUpdated;
		}

	    /**
	        * Function Name : DeleteRecord
	        * DeleteRecord function used to delete record from db
	        *
	        * @return int
	    */
		public function DeleteRecord($sTableName, $sWhere)
		{
			$iDeleteStatus=0;
			$sQueryString = "delete from ".$sTableName." ";

			if($sWhere!=""){
				$sQueryString.=" where ".$sWhere;
			}
			mysqli_query($this->_arrCon,$sQueryString);
			$iDeleteStatus = mysqli_affected_rows($this->_arrCon);
			mysqli_close($this->_arrCon);
			return $iDeleteStatus;
		}

	    /**
	        * Function Name : GetRecord
	        * GetRecord function used to get record from db
	        *
	        * @return array
	    */
		public function GetRecord($sTableName,array $arrData,$sJoinCondition=NULL)
		{
			$arrRecord = array();
			$sJoin 	   = "";

			if(!isset($arrData['fields']) || $arrData['fields']==""){
				$arrData['fields']="*";
			}

			if($sJoinCondition=='product-join'){
				$sJoin		= "LEFT JOIN categories c ON c.iCategoryId = p.iCategoryId";
			}
			if($sJoinCondition=='cart-join'){
				$sJoin		= "LEFT JOIN products p ON c.iProductId = p.iProductId";
			}
			$sQueryString 	= "select ".$arrData['fields']." from ".$sTableName." ".$sJoin." where 1=1 ";
			$objQuery  		= mysqli_query($this->_arrCon,$sQueryString);

			if(@mysqli_num_rows($objQuery)>0){
				while($arrResult=mysqli_fetch_assoc($objQuery)){
					$arrRecord[] = $arrResult;
				}
				mysqli_free_result($objQuery);
			}
			mysqli_close($this->_arrCon); 
			return $arrRecord;
		}

	    /**
	        * Function Name : GetCartAmount
	        * GetCartAmount function used to calculate field and return
	        *
	        * @return array
	    */
		public function GetCartAmount($sTableName,$sField)
		{
			$arrResult=array();
			if($sField!=""){
				$sQueryString 	= "select sum(".$sField.") as ".$sField." from ".$sTableName." where 1=1 ";
				$objQuery  		= mysqli_query($this->_arrCon,$sQueryString);

				if(@mysqli_num_rows($objQuery)>0){
					$arrResult=mysqli_fetch_assoc($objQuery);
					mysqli_free_result($objQuery);
				}
				mysqli_close($this->_arrCon); 
			}
			return $arrResult;
		}
	}	
?>