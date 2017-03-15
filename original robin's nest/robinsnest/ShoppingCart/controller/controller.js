'use strict';

// the storeController function retrieves the store and cart from the dataservice and adds them to the $scope object
// the storeController objects will drive all the views in the application
function storeController($scope, $routeParams, DataService) {

    // store: contains the product list
    // cart: the shopping cart object
    // get store and cart from service
    $scope.store = DataService.store;
    $scope.cart = DataService.cart;

    // use routing to pick the selected product
    if ($routeParams.productSku != null) {
        $scope.product = $scope.store.getProduct($routeParams.productSku);
    }
}