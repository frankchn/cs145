angular.module('auctionbase', ['abServices']).
	config(['$routeProvider', function($routeProvider) {
	$routeProvider.
		when('/', {templateUrl: 'app/partials/home.html'}).
		when('/category', {templateUrl: 'app/partials/category.html'}).
		when('/readme', {templateUrl: 'app/partials/readme.html'}).
		when('/login', {templateUrl: 'app/partials/login.html'}).
		when('/item', {templateUrl: 'app/partials/item.html'}).
		when('/item/:ItemID', {templateUrl: 'app/partials/item_individual.html'}).
		otherwise({redirectTo: '/'});
	}]);