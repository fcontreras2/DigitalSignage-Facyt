var user=angular.module("UserModule",["angular-repeat-n","mgcrea.ngStrap"]).config(function($interpolateProvider){$interpolateProvider.startSymbol("{[{").endSymbol("}]}")}).config(["$httpProvider",function($httpProvider){$httpProvider.defaults.withCredentials="",$httpProvider.defaults.useXDomain=!1,$httpProvider.defaults.headers.common["X-Requested-With"]="XMLHttpRequest"}]).config(function($datepickerProvider){angular.extend($datepickerProvider.defaults,{dateFormat:"dd/MM/yyyy",startWeek:1})});user.filter("range",function(){return function(input,init,total){total=parseInt(total);for(var i=init;total>=i;i++)input.push(i);return input}}),user.service("userService",function(){this.resetValues=function(originalData,editData){editData.identity_card=originalData.identity_card,editData.name=originalData.name,editData.last_name=originalData.last_name,editData.school=originalData.school,editData.school_id=originalData.school_id,editData.phone=originalData.phone}}),user.controller("UserController",["$scope","$filter","userService","$modal","$alert",function($scope,$filter,userService,$modal,$alert){$scope.data=data,$scope.profile_data_text=!0,$scope.editData={},$scope.change_password=!1,userService.resetValues($scope.data,$scope.editData),$scope.editProfile=function(){$scope.profile_data_text=!1},$scope.cancelEditProfile=function(){userService.resetValues($scope.data,$scope.editData),$scope.profile_data_text=!0},$scope.cancelChangePassword=function(){$scope.change_password=!1},$scope.sendEditData=function(){var url=Routing.generate("ds_facyt_infrastructure_user_edit_profile"),data=angular.toJson($scope.editData);$.ajax({method:"POST",data:data,url:url,success:function(data){userService.resetValues($scope.editData,$scope.data),console.log("editData",$scope.editData),console.log("data",$scope.data),$scope.profile_data_text=!0}})}}]);