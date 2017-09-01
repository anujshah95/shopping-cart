<?php
    /* File : init.php
     * Author : Anuj Shah
     * 
    */
    require_once("Rest.inc.php");
    class Init extends REST {
        public function __construct()
        {
            parent::__construct();  // Parent contructor initialization
        }

        /**
            * Function Name : initAPI
            * initAPI function used initialize api,check method exist or not and return appropriate message
            *
            * @return array
        */
        public function initAPI()
        {            
            if(isset($_REQUEST['request'])){
                $sRequest     = strtolower(trim($_REQUEST['request']));

                require_once("api/category.php");
                require_once("api/product.php");
                require_once("api/cart.php");
                $cat  = new Category;
                $pro  = new Product;
                $cart = new Cart;
                
                switch ($sRequest){
                    case 'api/category/create':
                        $cat->create();
                        break;
                    case 'api/category/retrieve':
                        $cat->retrieve();
                        break;
                    case 'api/category/update':
                        $cat->update();
                        break;
                    case 'api/category/delete':
                        $cat->delete();
                        break;
                    case 'api/product/create':
                        $pro->create();
                        break;
                    case 'api/product/retrieve':
                        $pro->retrieve();
                        break;
                    case 'api/product/update':
                        $pro->update();
                        break;
                    case 'api/product/delete':
                        $pro->delete();
                        break;
                    case 'api/cart/create':
                        $cart->create();
                        break;
                    case 'api/cart/delete':
                        $cart->delete();
                        break;
                    case 'api/cart/update':
                        $cart->update();
                        break;
                    case 'api/cart/retrieve':
                        $cart->retrieve();
                        break;
                    case 'api/cart/cart-amount':
                        $cart->cart_amount();
                        break;
                    default:
                        $this->method_not_found();
                        break;
                }
            }
            $this->method_not_found();
        }
    }
    // Initiiate Library
    $init = new Init;
    $init->initAPI();
?>