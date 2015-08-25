var exampleModule = angular.module("ExampleModule", ['angular-repeat-n', 'mgcrea.ngStrap'])

    
.config(function($interpolateProvider){
	$interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
 
