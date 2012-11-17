angular.module('auctionbase', []).
	config(['$routeProvider', function($routeProvider) {
	$routeProvider.
		when('/', {templateUrl: 'app/partials/home.html'}).
		when('/readme', {templateUrl: 'app/partials/readme.html'}).
		otherwise({redirectTo: '/'});
	}]);