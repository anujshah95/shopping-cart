<?php
	/* File : category.php
	 * Author : Anuj Shah
	 * 
	*/
	require_once("./Rest.inc.php");
	class Category extends REST {
		private $sTableName = "categories";

		public function __construct()
		{
			parent::__construct();	// Parent contructor initialization
		}

	    /**
	        * Function Name : create
	        * create function used to create category
	        *
	        * @return json
	    */
		public function create()
		{
			//Validate request method
			if($this->get_request_method() != "POST"){
				$this->method_not_allowed();
			}

			// Input validations
			$this->validation(array('sCategoryName','txtCategoryDescription','iCategoryTax'));

			$arrCategoryData = array(
				'sCategoryName'			=> $this->_arrRequest['sCategoryName'],
				'txtCategoryDescription'=> $this->_arrRequest['txtCategoryDescription'],
				'iCategoryTax'			=> $this->_arrRequest['iCategoryTax'],
				'dCreated'				=> date("Y-m-d H:i:s")
			);

			$iCatId   = $this->InsertRecord($this->sTableName,$arrCategoryData);
			$iStatus  = ($iCatId>0) ? "Success" : "False";
			$sMessage = ($iCatId>0) ? "Category added successfully." : "Fail to add.";

			$arrResponse['status']	= $iStatus;
			$arrResponse['message']	= $sMessage;
			$this->response($this->json($arrResponse), 200);
		}

	    /**
	        * Function Name : update
	        * update function used to update category
	        *
	        * @return json
	    */
		public function update()
		{
			//Validate request method
			if($this->get_request_method() != "POST"){
				$this->method_not_allowed();
			}
			
			// Input validations
			$this->validation(array('iCategoryId'));
			
			if(isset($this->_arrRequest['sCategoryName'])){
				$arrCategoryData['sCategoryName']=$this->_arrRequest['sCategoryName'];
			}
			if(isset($this->_arrRequest['txtCategoryDescription'])){
				$arrCategoryData['txtCategoryDescription']=$this->_arrRequest['txtCategoryDescription'];
			}
			if(isset($this->_arrRequest['iCategoryTax'])){
				$arrCategoryData['iCategoryTax']=$this->_arrRequest['iCategoryTax'];
			}
			$arrCategoryData['dModified'] = date("Y-m-d H:i:s");
			$iCategoryId = (int)$this->_arrRequest['iCategoryId'];

			$sWhere	 = "iCategoryId = '".$iCategoryId."'";
			$bStatus = $this->UpdateRecord($this->sTableName,$arrCategoryData,$sWhere);
			$iStatus = ($bStatus>0) ? "Success" : "False";
			$sMessage= ($bStatus>0) ? "Updated successfully." : "Fail to update.";

			$arrResponse['status']	= $iStatus;
			$arrResponse['message']	= $sMessage;
			$this->response($this->json($arrResponse), 200);
		}

	    /**
	        * Function Name : delete
	        * delete function used to delete category
	        *
	        * @return json
	    */
		public function delete()
		{
			//Validate request method
			if($this->get_request_method() != "DELETE"){
				$this->method_not_allowed();
			}

			// Input validations
			$this->validation(array('iCategoryId'));

			$iCategoryId = (int)$this->_arrRequest['iCategoryId'];

			if($iCategoryId > 0){
				$sWhere 		= "iCategoryId = '".$iCategoryId."'";
				$iDeleteStatus 	= $this->DeleteRecord($this->sTableName,$sWhere);
				$iStatus 		= ($iDeleteStatus>0) ? "Success" : "False";
				$sMessage		= ($iDeleteStatus>0) ? "Deleted successfully." : "Fail to delete.";
			}else{
				$iStatus  = "False";
				$sMessage = "Invalid input.";
			}
			$arrResponse['status']	= $iStatus;
			$arrResponse['message']	= $sMessage;
			$this->response($this->json($arrResponse), 200);
		}

	    /**
	        * Function Name : retrieve
	        * retrieve function used to retrieve category
	        *
	        * @return json
	    */
		public function retrieve()
		{
			//Validate request method
			if($this->get_request_method() != "GET"){
				$this->method_not_allowed();
			}

			$arrGetData   = array("fields"=>"iCategoryId,sCategoryName,txtCategoryDescription,iCategoryTax,dCreated");
			$arrCatList	  = $this->GetRecord($this->sTableName,$arrGetData);
			$iStatus 	  = (count($arrCatList)>0) ? 'Success' : 'False';
			$sMessage	  = (count($arrCatList)>0) ? 'Total '.count($arrCatList).' record(s) found.' : "Record not found.";
			$arrData 	  = (count($arrCatList)>0) ? $arrCatList : "Record not found.";
			$iTotalRecord = count($arrCatList);

			$arrResponse['status']		= $iStatus;
			$arrResponse['message']		= $sMessage;
			$arrResponse['total_record']= $iTotalRecord;
			$arrResponse['data']		= $arrData;
			$this->response($this->json($arrResponse), 200);
		}
	}
?>