function FeaturedCategoriesController($scope) {
	$scope.categories = [
		{"categoryname": "Computers"},
		{"categoryname": "Glassware"},
		{"categoryname": "Books"},
		{"categoryname": "Electronics"},
		{"categoryname": "Games"}
	];
}

function CurrentTimeController($scope) {
	$scope.current_time = 'YYYY-MM-DD HH:MM:SS';
}

function EndingSoonController($scope) {
	$scope.items = [
		{"name": "Auction 1", "description": "Lorem Ipsum dolor sit amet."},
		{"name": "Auction 2", "description": "Lorem Ipsum dolor sit amet."},
		{"name": "Auction 3", "description": "Lorem Ipsum dolor sit amet."},
		{"name": "Auction 4", "description": "Lorem Ipsum dolor sit amet."},
		{"name": "Auction 5", "description": "Lorem Ipsum dolor sit amet."},
		{"name": "Auction 6", "description": "Lorem Ipsum dolor sit amet."},
	];
}
