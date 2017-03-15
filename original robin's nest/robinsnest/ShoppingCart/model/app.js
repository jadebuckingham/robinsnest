'use strict';

// the route provides parses the URL and injects the appropriate partial page
// the first part defines the storeAppp object that represents the application. It contains a routeProvider which specifies which view should be displayed based on the URL
// when the URL ends with /cart, the app should display the view defined in the partials/shoppingCart.htm file
var storeApp = angular.module('Store', []).
  config(['$routeProvider', function($routeProvider) {
$routeProvider.
    when('/shop', { 
      templateUrl:'view/shop.htm',
      controller: storeController }).
    when('/products/:productSku', {
      templateUrl:'view/product.htm',
      controller: storeController }).
    when('/cart', { 
      templateUrl:'view/checkout.htm',
      controller: storeController }).
    otherwise({
      redirectTo:'/shop' });
}]);

// when the shoppingCart object is created, it automatically loads its contents from local storage, so users can add items ot the cart, close the application, and continue shopping later on. 

// the service creates a store object that contains a list of the products available and a shoppingCart object that represents the shopping cart
// creates a data service that provides a store and a shopping cart that will be shared by all views (instead of creating fresh ones for each view)
storeApp.factory("DataService", function () {

    // create store
    var myStore = new store();
    // create shopping cart
    var myCart = new shoppingCart("Store");

    // enable PayPal checkout
    myCart.addCheckoutParameters("PayPal", "jade.buckingham@live.co.uk");

    // return data object with store and cart
    return {
        store: myStore,
        cart: myCart
    };
});