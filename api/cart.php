<?php
	/* File : cart.php
	 * Author : Anuj Shah
	 * 
	*/
	require_once("./Rest.inc.php");
	class Cart extends REST {
		private $sTableName = "carts";

		public function __construct()
		{
			parent::__construct();	// Parent contructor initialization
		}

	    /**
	        * Function Name : create
	        * create function used to create cart
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
			$this->validation(array('sCartName','iProductId','iTotal','iTotalDiscount','iTotalWithDiscount','iTotalTax','iTotalWithTax','iGrandTotal'));

			$arrCartData = array(
				'sCartName'			=> $this->_arrRequest['sCartName'],
				'iProductId' 		=> $this->_arrRequest['iProductId'],
				'iTotal'			=> $this->_arrRequest['iTotal'],
				'iTotalDiscount'	=> $this->_arrRequest['iTotalDiscount'],
				'iTotalWithDiscount'=> $this->_arrRequest['iTotalWithDiscount'],
				'iTotalTax'			=> $this->_arrRequest['iTotalTax'],
				'iTotalWithTax'		=> $this->_arrRequest['iTotalWithTax'],
				'iGrandTotal'		=> $this->_arrRequest['iGrandTotal'],
				'dCreated'			=> date("Y-m-d H:i:s")
			);

			$iCartId  = $this->InsertRecord($this->sTableName,$arrCartData);
			$iStatus  = ($iCartId>0) ? "Success" : "False";
			$sMessage = ($iCartId>0) ? "Cart added successfully." : "Fail to add.";

			$arrResponse['status']	= $iStatus;
			$arrResponse['message']	= $sMessage;
			$this->response($this->json($arrResponse), 200);
		}
		
	    /**
	        * Function Name : update
	        * update function used to update cart
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
			$this->validation(array('iProductId'));
			
			$iProductId = (int)$this->_arrRequest['iProductId'];

			if($iProductId > 0){
				$sWhere 		= "iProductId = '".$iProductId."'";
				$iDeleteStatus 	= $this->DeleteRecord($this->sTableName,$sWhere);
				$iStatus 		= ($iDeleteStatus>0) ? "Success" : "False";
				$sMessage		= ($iDeleteStatus>0) ? "Cart updated." : "Fail to update.";
			}else{
				$iStatus  = "False";
				$sMessage = "Invalid input.";
			}
			$arrResponse['status']	= $iStatus;
			$arrResponse['message']	= $sMessage;
			$this->response($this->json($arrResponse), 200);
		}

	    /**
	        * Function Name : delete
	        * delete function used to delete cart
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
			$this->validation(array('iCartId'));

			$iCartId = (int)$this->_arrRequest['iCartId'];

			if($iCartId > 0){
				$sWhere 		= "iCartId = '".$iCartId."'";
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
	        * retrieve function used to retrieve cart products
	        *
	        * @return json
	    */	
		public function retrieve()
		{
			//Validate request method
			if($this->get_request_method() != "GET"){
				$this->method_not_allowed();
			}

			$arrGetData   = array("fields"=>"c.sCartName,p.sProductName,c.iTotal,c.iTotalDiscount,c.iTotalWithDiscount,c.iTotalTax,c.iTotalWithTax,c.iGrandTotal");
			$arrCartList  = $this->GetRecord($this->sTableName.' c',$arrGetData,'cart-join');
			$iStatus 	  = (count($arrCartList)>0) ? 'Success' : 'False';
			$sMessage	  = (count($arrCartList)>0) ? 'Total '.count($arrCartList).' record(s) found.' : "Record not found.";
			$arrData 	  = (count($arrCartList)>0) ? $arrCartList : "Record not found.";
			$iTotalRecord = count($arrCartList);

			$arrResponse['status']		= $iStatus;
			$arrResponse['message']		= $sMessage;
			$arrResponse['total_record']= $iTotalRecord;
			$arrResponse['data']		= $arrData;
			$this->response($this->json($arrResponse), 200);
		}

	    /**
	        * Function Name : cart_amount
	        * cart_amount function used to retrieve total,total tax and total discount
	        *
	        * @return json
	    */	
		public function cart_amount()
		{
			//Validate request method
			if($this->get_request_method() != "GET"){
				$this->method_not_allowed();
			}

			$this->validation(array('target'));

			$arrAllowed=array('total','total-discount','total-tax');
			$sTarget=$this->_arrRequest['target'];

			if(!in_array($sTarget, $arrAllowed)) $this->method_not_found();

			$sField="";
			if($sTarget=='total') $sField='iGrandTotal';
			if($sTarget=='total-discount') $sField='iTotalDiscount';
			if($sTarget=='total-tax') $sField='iTotalTax';

			$arrResult  = $this->GetCartAmount($this->sTableName,$sField);
			$iStatus 	= (count($arrResult)>0) ? 'Success' : 'False';
			$arrData 	= (count($arrResult)>0) ? $arrResult : "Record not found.";

			$arrResponse['status']		= $iStatus;
			$arrResponse['data']		= $arrData;
			$this->response($this->json($arrResponse), 200);
		}
	}
?>