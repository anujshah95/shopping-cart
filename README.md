###################
Shoppig Cart API
###################

Rest API for shopping cart which allows to CRUD operations for category,product and cart


************
Instructions
************

1. Download folder,move to the appropriate directory.
2. Give permission
3. Import sql (Path : sql/shopping_cart.sql)
4. API Links

http://localhost/shoping-cart/api/cart/create (POST)

http://localhost/shoping-cart/api/cart/update (POST)

http://localhost/shoping-cart/api/cart/delete?iCategoryId=1 (DELETE)

http://localhost/shoping-cart/api/cart/retrieve (GET)

http://localhost/shoping-cart/api/product/create (POST)

http://localhost/shoping-cart/api/product/update (POST)

http://localhost/shoping-cart/api/product/delete?iProductId=5 (DELETE)

http://localhost/shoping-cart/api/product/retrieve (GET)

http://localhost/shoping-cart/api/cart/create (POST)

http://localhost/shoping-cart/api/cart/update (POST)

http://localhost/shoping-cart/api/cart/delete?iCartId=8 (DELETE)

http://localhost/shoping-cart/api/cart/retrieve (GET)

http://localhost/shoping-cart/api/cart/cart-amount?target=total (GET)

http://localhost/shoping-cart/api/cart/cart-amount?target=total-tax (GET)

http://localhost/shoping-cart/api/cart/cart-amount?target=total-discount (GET)
