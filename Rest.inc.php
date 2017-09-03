<?php
	/* File : Rest.inc.php
	 * Author : Anuj Shah
	 * 
	*/
	require_once("DbConfig.php");
	class REST extends DbConfig{
		private $_iCode 		= 200;

		public $_sContentType 	= "application/json";
		public $_arrRequest 	= array();
		
		public function __construct()
		{
			parent::__construct();  // Parent contructor initialization
			$this->inputs();
		}
		
	    /**
	        * Function Name : inputs
	        * inputs function used check input method and store data in var
	        *
	        * @return array
	    */
		private function inputs()
		{
			switch($this->getRequestMethod()){
				case "POST":
					$this->_arrRequest = $this->cleanInputs($_POST);
					break;
				case "GET":
				case "DELETE":
					$this->_arrRequest = $this->cleanInputs($_GET);
					break;
				default:
					$this->methodNotAllowed();
					break;
			}
		}

	    /**
	        * Function Name : getRequestMethod
	        * getRequestMethod function used to return request method
	        *
	        * @return string
	    */
		public function getRequestMethod()
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
	        * Function Name : response
	        * response function used to set headers and print it
	        *
	        * @return array
	    */
		public function response($arrData,$iStatus)
		{
			$this->_iCode = ($iStatus)?$iStatus:200;
			$this->setHeaders();
			echo $arrData;
			exit;
		}

	    /**
	        * Function Name : getStatusMessage
	        * getStatusMessage function used to store diff http code
	        *
	        * @return string
	    */		
		private function getStatusMessage()
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
	        * Function Name : setHeaders
	        * setHeaders function used to set headers
	        *
	    */		
		private function setHeaders()
		{
			header("HTTP/1.1 ".$this->_iCode." ".$this->getStatusMessage());
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
				echo $sField; 
				$arrResponse['status']	= $iStatus;
				$arrResponse['message']	= $sMessage;
				$this->response($this->json($arrResponse), 200);
			}
			return TRUE;
		}

	    /**
	        * Function Name : methodNotAllowed
	        * methodNotAllowed function used to display not allowed method error
	        *
	        * @return json
	    */	
		public function methodNotAllowed()
		{
			$arrResponse['status']	= 'False';
			$arrResponse['message']	= 'Method not allowed';
			$this->response($this->json($arrResponse),406);
		}

	    /**
	        * Function Name : methodNotFound
	        * methodNotFound function used to display not found method error
	        *
	        * @return json
	    */
		public function methodNotFound()
		{
			$arrResponse['status']	= 'False';
			$arrResponse['message']	= 'Method not found';
			$this->response($this->json($arrResponse),406);
		}

	    /**
	        * Function Name : checkMethodExists
	        * checkMethodExists function used to check whether method is exists or not in respected file
	        *
	        * @return boolean
	    */
		public function checkMethodExists($objFile,$sMethodName)
		{
            if((int)method_exists($objFile,$sMethodName) > 0){
                return TRUE;
            }
            return FALSE;
		}

	    /**
	        * Function Name : insertRecord
	        * insertRecord function used to insert record to db
	        *
	        * @return int
	    */
		public function insertRecord($sTableName, array $arrValues)
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
	        * Function Name : updateRecord
	        * updateRecord function used to update record to db
	        *
	        * @return int
	    */
		public function updateRecord($sTableName,array $arrValues,$sWhere="")
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
	        * Function Name : deleteRecord
	        * deleteRecord function used to delete record from db
	        *
	        * @return int
	    */
		public function deleteRecord($sTableName, $sWhere)
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
	        * Function Name : getRecord
	        * getRecord function used to get record from db
	        *
	        * @return array
	    */
		public function getRecord($sTableName,array $arrData,$sJoinCondition=NULL)
		{
			$arrRecord = array();
			$sJoin 	   = "";

			if(!isset($arrData['fields']) || $arrData['fields']==""){
				$arrData['fields']="*";
			}

			if($sJoinCondition=='product-join'){
				$sJoin		= "LEFT JOIN $this->_sCategoryTable c ON c.iCategoryId = p.iCategoryId";
			}
			if($sJoinCondition=='cart-join'){
				$sJoin		= "LEFT JOIN $this->_sProductTable p ON c.iProductId = p.iProductId";
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
	        * Function Name : getCartAmount
	        * getCartAmount function used to calculate field and return
	        *
	        * @return array
	    */
		public function getCartAmount($sTableName,$sField)
		{
			$arrResult=array();
			if($sField!=""){
				$sQueryString = "select sum(".$sField.") as ".$sField." from ".$sTableName." where 1=1 ";
				$objQuery  	  = mysqli_query($this->_arrCon,$sQueryString);

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