<?php
	/* File : product.php
	 * Author : Anuj Shah
	 * 
	*/
	require_once("./Rest.inc.php");
	class Product extends REST {
		public function __construct()
		{
			parent::__construct();	// Parent contructor initialization
		}

	    /**
	        * Function Name : create
	        * create function used to create product
	        *
	        * @return json
	    */	
		public function create()
		{
			//Validate request method
			if($this->getRequestMethod() != "POST"){
				$this->methodNotAllowed();
			}
			
			// Input validations
			$this->validation(array('iCategoryId','sProductName','txtProductDescription','iProductPrice'));

			$arrProductData = array(
				'iCategoryId'			=> $this->_arrRequest['iCategoryId'],
				'sProductName' 			=> $this->_arrRequest['sProductName'],
				'txtProductDescription'	=> $this->_arrRequest['txtProductDescription'],
				'iProductPrice'			=> $this->_arrRequest['iProductPrice'],
				'iProductDiscount'		=> $this->_arrRequest['iProductDiscount'],
				'dCreated'				=> date("Y-m-d H:i:s")
			);

			$iProId   = $this->insertRecord($this->_sProductTable,$arrProductData);
			$iStatus  = ($iProId>0) ? "Success" : "False";
			$sMessage = ($iProId>0) ? "Product added successfully." : "Fail to add.";

			$arrResponse['status']	= $iStatus;
			$arrResponse['message']	= $sMessage;
			$this->response($this->json($arrResponse), 200);
		}

	    /**
	        * Function Name : update
	        * update function used to update product
	        *
	        * @return json
	    */	
		public function update()
		{
			//Validate request method
			if($this->getRequestMethod() != "POST"){
				$this->methodNotAllowed();
			}
			
			// Input validations
			$this->validation(array('iProductId'));

			if(isset($this->_arrRequest['iCategoryId'])){
				$arrProData['iCategoryId']=$this->_arrRequest['iCategoryId'];
			}
			if(isset($this->_arrRequest['sProductName'])){
				$arrProData['sProductName']=$this->_arrRequest['sProductName'];
			}
			if(isset($this->_arrRequest['txtProductDescription'])){
				$arrProData['txtProductDescription']=$this->_arrRequest['txtProductDescription'];
			}
			if(isset($this->_arrRequest['iProductPrice'])){
				$arrProData['iProductPrice']=$this->_arrRequest['iProductPrice'];
			}
			if(isset($this->_arrRequest['iProductDiscount'])){
				$arrProData['iProductDiscount']=$this->_arrRequest['iProductDiscount'];
			}
			$arrProData['dModified'] = date("Y-m-d H:i:s");
			$iProductId = (int)$this->_arrRequest['iProductId'];

			$sWhere	 = "iProductId = '".$iProductId."'";

			$bStatus = $this->updateRecord($this->_sProductTable,$arrProData,$sWhere);
			$iStatus = ($bStatus>0) ? "Success" : "False";
			$sMessage= ($bStatus>0) ? "Updated successfully." : "Fail to update.";

			$arrResponse['status']	= $iStatus;
			$arrResponse['message']	= $sMessage;
			$this->response($this->json($arrResponse), 200);
		}

	    /**
	        * Function Name : delete
	        * delete function used to delete product
	        *
	        * @return json
	    */
		public function delete()
		{
			//Validate request method
			if($this->getRequestMethod() != "DELETE"){
				$this->methodNotAllowed();
			}

			// Input validations
			$this->validation(array('iProductId'));

			$iProductId = (int)$this->_arrRequest['iProductId'];

			if($iProductId > 0){
				$sWhere 		= "iProductId = '".$iProductId."'";
				$iDeleteStatus 	= $this->deleteRecord($this->_sProductTable,$sWhere);
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
	        * retrieve function used to retrieve product
	        *
	        * @return json
	    */
		public function retrieve()
		{
			//Validate request method
			if($this->getRequestMethod() != "GET"){
				$this->methodNotAllowed();
			}

			$arrGetData   = array("fields"=>"p.iProductId,c.sCategoryName,p.sProductName,p.txtProductDescription,p.iProductPrice,p.iProductDiscount,p.dCreated");
			$arrProList	  = $this->getRecord($this->_sProductTable.' p',$arrGetData,'product-join');
			$iStatus 	  = (count($arrProList)>0) ? 'Success' : 'False';
			$sMessage	  = (count($arrProList)>0) ? 'Total '.count($arrProList).' record(s) found.' : "Record not found.";
			$arrData 	  = (count($arrProList)>0) ? $arrProList : "Record not found.";
			$iTotalRecord = count($arrProList);

			$arrResponse['status']		= $iStatus;
			$arrResponse['message']		= $sMessage;
			$arrResponse['total_record']= $iTotalRecord;
			$arrResponse['data']		= $arrData;
			$this->response($this->json($arrResponse), 200);
		}
	}
?>