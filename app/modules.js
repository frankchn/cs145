angular.module('abServices', ['ngResource']).
    factory(
    	'Categories', 
    	function($resource) {
  			return $resource(
  				'api/categories.php', 
  				{}, 
  				{
  					query: {
  						method:'GET', 
  						isArray:true
  					}
  				}
  			);
		}
	);