angular.module('auctionbase', ['abServices']).
	config(['$routeProvider', function($routeProvider) {
	$routeProvider.
		when('/', {templateUrl: 'app/partials/home.html'}).
		when('/category', {templateUrl: 'app/partials/category.html'}).
		when('/category/:CategoryID', {templateUrl: 'app/partials/item.html'}).
		when('/readme', {templateUrl: 'app/partials/readme.html'}).
		when('/login', {templateUrl: 'app/partials/login.html'}).
		when('/item', {templateUrl: 'app/partials/item.html'}).
		when('/user', {templateUrl: 'app/partials/user.html'}).
		when('/statistics', {templateUrl: 'app/partials/statistics.html'}).
		when('/user/:UserID', {templateUrl: 'app/partials/user_individual.html'}).
		when('/change_time', {templateUrl: 'app/partials/change_time.html'}).
		when('/item/:ItemID', {templateUrl: 'app/partials/item_individual.html'}).
		otherwise({redirectTo: '/'});
	}]);