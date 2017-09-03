<?php
    /* File : Init.php
     * Author : Anuj Shah
     * 
    */
    require_once("Rest.inc.php");
    class Init extends REST{
        public function __construct()
        {
            parent::__construct();  // Parent contructor initialization
            // ini_set('display_errors',0); //Turn off PHP Errors
        }

        /**
            * Function Name : InitAPI
            * initAPI function used initialize api,check method exist or not and return appropriate message
            *
            * @return array
        */
        public function InitAPI()
        {
            if(isset($_REQUEST['request'])){
                $sRequest    = strtolower(trim($_REQUEST['request']));
                $arrPath     = explode("/", $sRequest); // splitting the path
                $sMethodName = end($arrPath);           // get the method name
                $sSource     = dirname($sRequest);      // finds directory name

                switch ($sSource){
                    case 'api/category':
                        require_once("api/Category.php");
                        $objCat       = new Category;
                        $bExistStatus = $this->checkMethodExists($objCat,$sMethodName);
                        if($bExistStatus){
                            $objCat->$sMethodName();
                        }
                        $this->methodNotFound();
                        break;
                    case 'api/product':
                        require_once("api/Product.php");
                        $objProduct   = new Product;
                        $bExistStatus = $this->checkMethodExists($objProduct,$sMethodName);
                        if($bExistStatus){
                            $objProduct->$sMethodName();
                        }
                        $this->methodNotFound();
                        break;
                    case 'api/cart':
                        require_once("api/Cart.php");
                        $objCart      = new Cart;
                        $bExistStatus = $this->checkMethodExists($objCart,$sMethodName);
                        if($bExistStatus){
                            $objCart->$sMethodName();
                        }
                        $this->methodNotFound();
                        break;
                    default:
                        $this->methodNotFound();
                        break;
                }
            }else{
                $this->methodNotFound();
            }
        }
    }
    // Initiiate Library
    $init = new Init;
    $init->InitAPI();
?>