var uploadImage = angular.module("UploadImageModule", ['mgcrea.ngStrap','angular-img-cropper'])
    .config(function($interpolateProvider){
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
    });