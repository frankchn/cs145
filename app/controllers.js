function FeaturedCategoriesController($scope, $cookies, Categories) {
	$scope.categories = Categories.query({top: 6});
	$scope.orderProp = 'CategoryID';
}

function AllCategoriesController($scope, $cookies, Categories) {
	$scope.categories = Categories.query();
}

function CurrentTimeController($scope, $cookies, $route, Time) {
	$scope.current_time = Time.get();

	$scope.update = function() {
		$scope.current_time.$save();
		$('#changetime_control').addClass('success');
		setTimeout("$('#changetime_control').removeClass('success');", 5000);
		$route.reload();
	}
}

function UserSearchController($scope, $route, $cookies, Users) {
	$scope.numitems = 20;
	$scope.userid = '';
	$scope.minrep = '';
	$scope.maxrep = '';
	$scope.location = '';
	$scope.country = '';
	$scope.orderby = 'UserID ASC';

	$scope.search = function() {
		$scope.users = Users.query({
			UserIDLike: $scope.userid,
			MinRep: $scope.minrep,
			MaxRep: $scope.maxrep,
			LocationLike: $scope.location,
			CountryLike: $scope.country,
			numitems: $scope.numitems,
			orderby: $scope.orderby
		});
	}

	$scope.search();	
}

function UserController($scope, $route, $routeParams, $cookies, Users, Items, Bids) {
	$scope.user = Users.get({UserID: $routeParams.UserID});
	$scope.items = Items.query({userid: $routeParams.UserID, closed: 1});
	$scope.bids = Bids.query({userid: $routeParams.UserID, closed: 1});
}

function LoginController($scope, $route, $cookies, Users) {
	if(typeof $cookies.auctionbase_user == "undefined" || $cookies.auctionbase_user == "") {
		$scope.current_status = "You are not currently logged in as any user.";
	} else {
		$scope.current_status = "You are currently logged in as " + $cookies.auctionbase_user + ".";
	}

	$scope.login = function() {
		var x = Users.login({UserID: $scope.username, Password: $scope.password}, function() {
			$('#logincontrol').addClass('success');
			$('#logincontainer').hide();
			$('#loginsuccess').show();
		}, function() {
			$('#logincontrol').addClass('error');
			$('#loginerror').show();
		});
		$route.reload();
	}
}

function EndingSoonController($scope, $cookies, Items) {
	$scope.items = Items.query({numitems: 15});
}

function ItemListController($scope, $routeParams, $cookies, Items, Categories) {
	$scope.CategoryID = -1;

	if(typeof $routeParams.CategoryID != "undefined") {
		$scope.CategoryID = $routeParams.CategoryID;
		$scope.categories = Categories.query({category: $scope.CategoryID});
	}

	$scope.numitems = 20;
	$scope.items = Items.query({numitems: 20, category: $scope.CategoryID});

	$scope.update = function() {
		opt_category = $scope.CategoryID;
		opt_search = $scope.keyword != undefined ? $scope.keyword : '';
		opt_min = $scope.minprice != undefined ? $scope.minprice : '';
		opt_max = $scope.maxprice != undefined ? $scope.maxprice : '';
		opt_items = $scope.numitems != undefined ? $scope.numitems : '';
		opt_itemid = $scope.itemid != undefined ? $scope.itemid : '';
		opt_closed = $scope.closed != undefined ? $scope.closed : 0;

		$scope.items = Items.query({itemidlike: opt_itemid, category: opt_category, closed: opt_closed, search: opt_search, min: opt_min, max: opt_max, numitems: opt_items});
	};
}

function ItemController($scope, $routeParams, $cookies, Items, Bids, Users, Categories) {
	if(typeof $cookies.auctionbase_user == "undefined" || $cookies.auctionbase_user == "") {
		$scope.user_status = "You are not currently logged in as any user.";
		$scope.UserID = '';
	} else {
		$scope.user_status = "You are currently logged in as " + $cookies.auctionbase_user + ".";
		$scope.UserID = $cookies.auctionbase_user;
	}

	$scope.item = Items.get({itemid: $routeParams.ItemID, closed: 1}, function() {
		$scope.seller = Users.get({UserID: $scope.item.UserID});

        imageSearch.setSearchCompleteCallback(this, function() {
        	if (imageSearch.results && imageSearch.results.length > 0) {
        		result = imageSearch.results[0];
        		$('#item_image').attr('src', result.url);
        	}
        }, null);
        // Find me a beautiful car.
        imageSearch.execute($scope.item.Name);
	});
	$scope.categories = Categories.query({itemid: $routeParams.ItemID});
	$scope.bids = Bids.query({itemid: $routeParams.ItemID});

	$scope.submit_bid = function() {
		$('.biderror').hide();

		if(isNaN($scope.new_bid)) {
			$('#error_bidinvalid').show();
			return false;
		}

		Bids.save({ItemID: $scope.item.ItemID, Amount: $scope.new_bid}, function() {
			$('#error_okay').show();
		}, function() {
			$('#error_bidtoolow').show();
		});

		$scope.item = Items.get({itemid: $routeParams.ItemID, closed: 1});
		$scope.bids = Bids.query({itemid: $routeParams.ItemID});
	}
}
