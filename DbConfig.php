<?php
    /* File : DbConfig.php
     * Author : Anuj Shah
     * 
    */
    class DbConfig {
        // Database credentials
        private $_sHost     = "localhost";
        private $_sUserName = "root";
        private $_sPassword = "anujshah";
        private $_sDBName   = "ShoppingCart";

        //Table Name
        public $_sProductTable  = "Products";
        public $_sCategoryTable = "Categories";
        public $_sCartTable     = "Carts";

        public function __construct()
        {
            $this->_arrCon=$this->dbConnect();  // Initiate Database connection
        }


        /**
            * Function Name : dbConnect
            * dbConnect function used to connect db
            *
            * @return array
        */
        public function dbConnect()
        {
            /*
            $arrCon=new PDO("mysql:host={$this->_sHost};dbname={$this->_sDBName}", $this->_sUserName,$this->_sPassword,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            return $arrCon;
            */
            $arrCon = @mysqli_connect($this->_sHost,$this->_sUserName,$this->_sPassword,$this->_sDBName);
            if (mysqli_connect_errno()){
                echo "Failed to connect : " . mysqli_connect_error();
                exit;
            }else{
                return $arrCon;
            }
        }
    }
?>