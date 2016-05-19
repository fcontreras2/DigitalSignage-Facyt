var Transmition = angular.module("TransmitionModule", ['angular-repeat-n','ds.clock'])
    .config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });