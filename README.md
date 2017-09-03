# Shoppig Cart API

RESTFul shopping cart api using Object oriented PHP

************
## Instructions
************

1. Download folder,move to the root folder of web server.
2. Give permissions (644)
3. Import SQL (Path : sql/ShoppingCart.sql)
4. API Descriptions

### Category

- http://localhost/shopping-cart/api/category/create (POST)
	- Used to create a category
	- Required fields are :
		sCategoryName,txtCategoryDescription,iCategoryTax
	
- http://localhost/shopping-cart/api/category/retrieve (GET)
	- Used to get a category list
	
- http://localhost/shopping-cart/api/category/update (POST)
	- Used to update a category
	- Required fields are :
		iCategoryId

- http://localhost/shopping-cart/api/category/delete?iCategoryId=1 (DELETE)
	- Used to delete a category
	- Required fields are :
		iCategoryId
	
### Product

- http://localhost/shopping-cart/api/product/create (POST)
	- Used to create a product
	- Required fields are :
		iCategoryId,sProductName,txtProductDescription,iProductPrice
	
- http://localhost/shopping-cart/api/product/retrieve (GET)
	- Used to get a product list
	
- http://localhost/shopping-cart/api/product/update (POST)
	- Used to update a product
	- Required fields are :
		iProductId

- http://localhost/shopping-cart/api/product/delete?iProductId=1 (DELETE)
	- Used to delete a product
	- Required fields are :
		iProductId
	
### Cart

- http://localhost/shopping-cart/api/cart/create (POST)
	- Used to create a cart
	- Required fields are :
		sCartName,iProductId,iTotal,iTotalDiscount,iTotalWithDiscount,iTotalTax,iTotalWithTax,iGrandTotal
	
- http://localhost/shopping-cart/api/cart/retrieve (GET)
	- Used to show the cart
	
- http://localhost/shopping-cart/api/cart/update (POST)
	- Used to update(remove product) a cart
	- Required fields are :
		iProductId

- http://localhost/shopping-cart/api/cart/delete?iCartId=1 (DELETE)
	- Used to delete a cart
	- Required fields are :
		iCartId

- http://localhost/shopping-cart/api/cart/cartAmount?target=total (GET)
	- Used to get cart total
	- Required fields are :
		target=total

- http://localhost/shopping-cart/api/cart/cartAmount?target=total-tax (GET)
	- Used to get cart total tax
	- Required fields are :
		target=total-tax

- http://localhost/shopping-cart/api/cart/cartAmount?target=total-discount (GET)
	- Used to get cart total discount
	- Required fields are :
		target=total-discount
		
************
## Naming conventions I follow : 
************

- Classes->PascalCase (i.e. Category)
- Methods->camelCase  (i.e. insertRecord)
- Variables->Hungarian notation (The prefix encodes the actual data type of the variable)
	- int iCaategoryId;
	- bool bStatus;
	- string sProductName;
	- boo
