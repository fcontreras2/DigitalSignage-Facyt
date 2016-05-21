var Transmition = angular.module("TransmitionModule", ['angular-repeat-n','ds.clock'])
    .config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });

    Transmition.filter('range', function() {
	  return function(val, range) {
	    range = parseInt(range);
	    for (var i=0; i<range; i++)
	      val.push(i);
	    return val;
	  }
	});