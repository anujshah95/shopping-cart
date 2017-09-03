Shoppig Cart API

RESTFul shopping cart api using Object oriented PHP

************
Instructions
************

1. Download folder,move to the root folder of web server.
2. Give permissions (644)
3. Import SQL (Path : sql/ShoppingCart.sql)
4. API Descriptions

Category
	http://localhost/shopping-cart/api/category/create (POST)
	-To create a category
	-Required fields are :
		sCategoryName,txtCategoryDescription,iCategoryTax
	
	http://localhost/shopping-cart/api/category/retrieve (GET)
	
	http://localhost/shopping-cart/api/category/update (POST)

	http://localhost/shopping-cart/api/category/delete?iCategoryId=1 (DELETE)
	
Product
	http://localhost/shopping-cart/api/product/create (POST)
	
	http://localhost/shopping-cart/api/product/retrieve (GET)

	http://localhost/shopping-cart/api/product/update (POST)
	
	http://localhost/shopping-cart/api/product/delete?iProductId=5 (DELETE)
	
Cart
	http://localhost/shopping-cart/api/cart/create (POST)
	
	http://localhost/shopping-cart/api/cart/retrieve (GET)

	http://localhost/shopping-cart/api/cart/update (POST)

	http://localhost/shopping-cart/api/cart/delete?iCartId=8 (DELETE)

	http://localhost/shopping-cart/api/cart/cartAmount?target=total (GET)

	http://localhost/shopping-cart/api/cart/cartAmount?target=total-tax (GET)

	http://localhost/shopping-cart/api/cart/cartAmount?target=total-discount (GET)
