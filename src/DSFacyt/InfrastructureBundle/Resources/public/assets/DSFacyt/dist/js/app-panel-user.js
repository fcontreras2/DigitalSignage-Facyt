var user=angular.module("UserModule",["angular-repeat-n","mgcrea.ngStrap"]).config(function($interpolateProvider){$interpolateProvider.startSymbol("{[{").endSymbol("}]}")}).config(["$httpProvider",function($httpProvider){$httpProvider.defaults.withCredentials="",$httpProvider.defaults.useXDomain=!1,$httpProvider.defaults.headers.common["X-Requested-With"]="XMLHttpRequest"}]).config(function($datepickerProvider){angular.extend($datepickerProvider.defaults,{dateFormat:"dd/MM/yyyy",startWeek:1})});user.filter("range",function(){return function(input,init,total){total=parseInt(total);for(var i=init;total>=i;i++)input.push(i);return input}}),user.service("userService",function(){}),user.controller("UserController",["$scope","$filter","userService","$modal","$alert",function($scope,$filter,textService,$modal,$alert){$scope.data=data}]);