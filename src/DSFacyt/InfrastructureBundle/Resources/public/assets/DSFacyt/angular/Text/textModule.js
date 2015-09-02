var text = angular.module("TextModule", ['angular-repeat-n', 'mgcrea.ngStrap'])


.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

