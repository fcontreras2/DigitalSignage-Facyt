var text=angular.module("TextModule",["angular-repeat-n","mgcrea.ngStrap"]).config(function($interpolateProvider){$interpolateProvider.startSymbol("{[{").endSymbol("}]}")}).config(["$httpProvider",function($httpProvider){$httpProvider.defaults.withCredentials="",$httpProvider.defaults.useXDomain=!1,$httpProvider.defaults.headers.common["X-Requested-With"]="XMLHttpRequest"}]).config(function($datepickerProvider){angular.extend($datepickerProvider.defaults,{dateFormat:"dd/MM/yyyy",startWeek:1})});text.filter("range",function(){return function(input,init,total){total=parseInt(total);for(var i=init;total>=i;i++)input.push(i);return input}}),text.service("textService",function(){this.checkStatus=function(data){$.each(data,function(index,value){switch(value.status){case 0:value.classStatus="fa fa-circle";break;case 1:value.classStatus="fa fa-circle-o";break;case 1:value.classStatus="fa fa-circle-thin"}})}}),text.controller("TextController",["$scope","$filter","textService","$modal","$alert","$timeout",function($scope,$filter,textService,$modal,$alert,$timeout){function checkEmptyData(alertEmptyData){return $scope.data.length?!1:($scope.data=[],!0)}$scope.data=data.texts,$scope.pagination=data.pagination,$scope.btnAction="fa fa-trash",$scope.selectedDate={date:new Date("2012-09-01")},$scope.indexEditText=null,textService.checkStatus($scope.data);var alertEmptyData=$alert({title:"Sin publicaciones",content:"No tiene ninguna publicación de tipo texto",placement:"top",type:"info",show:!1,container:"#box-alert"});checkEmptyData(alertEmptyData)&&alertEmptyData.$promise.then(function(){alertEmptyData.show()});var myOtherModal=$modal({scope:$scope,template:"modal-deleteText.tpl",show:!1});$scope.modalDeleteText=function(text_id){$scope.indexPreview=text_id,myOtherModal.$promise.then(myOtherModal.show)};var alertDeleteSuccess=$alert({title:"Publicación Eliminada",content:"Se ha eliminado correctamente el texto",placement:"top",type:"success",show:!1,container:"#box-alert"});$scope.deleteText=function(indexData){var url=Routing.generate("ds_facyt_infrastructure_user_text_delete"),data=angular.toJson({text_id:$scope.data[indexData].text_id});$.ajax({method:"POST",data:data,url:url,success:function(data){$scope.data.splice(indexData,1),myOtherModal.$promise.then(myOtherModal.hide),checkEmptyData()?alertEmptyData.$promise.then(function(){alertEmptyData.show()}):alertDeleteSuccess.$promise.then(function(){alertDeleteSuccess.show()})}})},$scope.generatePagination=function(pagination){$scope.urlPagination=Routing.generate("ds_facyt_infrastructure_user_text_homepage",{page:pagination})}}]);