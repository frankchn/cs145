function FeaturedCategoriesController($scope, Categories) {
	$scope.categories = Categories.query({top: 6});
	$scope.orderProp = 'CategoryID';
}

function AllCategoriesController($scope, Categories) {
	$scope.categories = Categories.query();
}

function CurrentTimeController($scope, Time) {
	$scope.current_time = Time.get();
}

function EndingSoonController($scope, Items) {
	$scope.items = Items.query({numitems: 15});
}

function ItemListController($scope, Items) {
	$scope.items = Items.query();
	$scope.numitems = 50;

	$scope.update = function() {
		opt_search = $scope.keyword != undefined ? $scope.keyword : '';
		opt_min = $scope.minprice != undefined ? $scope.minprice : '';
		opt_max = $scope.maxprice != undefined ? $scope.maxprice : '';
		opt_items = $scope.numitems != undefined ? $scope.numitems : '';
		opt_closed = $scope.closed != undefined ? $scope.closed : 0;

		$scope.items = Items.query({closed: opt_closed, search: opt_search, min: opt_min, max: opt_max, numitems: opt_items});
	};
}

function ItemController($scope, $routeParams, Items, Bids) {
	$scope.items = Items.query({itemid: $routeParams.ItemID, closed: 1});
	$scope.bids = Bids.query({itemid: $routeParams.ItemID});
}
