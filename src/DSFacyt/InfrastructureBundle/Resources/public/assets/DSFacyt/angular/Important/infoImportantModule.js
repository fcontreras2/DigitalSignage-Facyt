var infoimportant = angular.module("infoImportantModule", [
	'angular-repeat-n',
	'ds.clock',
	"ngSanitize",
	"com.2fdevs.videogular",
	"com.2fdevs.videogular.plugins.controls",
	"com.2fdevs.videogular.plugins.overlayplay",
	"com.2fdevs.videogular.plugins.buffering",
	"com.2fdevs.videogular.plugins.poster",
	'socialLinks'])
	
    .config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });

    infoimportant.filter('range', function() {
	  return function(val, range) {
	    range = parseInt(range);
	    for (var i=0; i<range; i++)
	      val.push(i);
	    return val;
	  }
	});