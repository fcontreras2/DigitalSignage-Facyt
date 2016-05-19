var publish=angular.module("PublishModule",["angular-repeat-n","mgcrea.ngStrap"]).config(function($interpolateProvider){$interpolateProvider.startSymbol("{[{").endSymbol("}]}")}).config(["$httpProvider",function($httpProvider){$httpProvider.defaults.withCredentials="",$httpProvider.defaults.useXDomain=!1,$httpProvider.defaults.headers.common["X-Requested-With"]="XMLHttpRequest"}]).config(function($datepickerProvider){angular.extend($datepickerProvider.defaults,{dateFormat:"dd/MM/yyyy",startWeek:1})});publish.filter("range",function(){return function(input,init,total){total=parseInt(total);for(var i=init;total>=i;i++)input.push(i);return input}}),publish.service("publishService",function(){this.ajaxGetPublish=function(data,$scope){var url=Routing.generate("ds_facyt_infrastructure_api_get_publish_type_status");$.ajax({method:"POST",data:data,url:url,success:function(data){$scope.pagination=data.pagination,$scope.publish=data.publish,$scope.$apply()}})},this.getCurrentModalPreview=function($modal,$scope){var currentModal=null;switch($scope.type){case"Text":currentModal=$modal({scope:$scope,template:"modal-previewText.tpl",show:!1});break;case"Image":currentModal=$modal({scope:$scope,template:"modal-previewImage.tpl",show:!1})}return currentModal},this.setColorStatus=function(status_select){var response=0;switch(status_select){case 0:response="status-new";break;case"1":response="status-change";break;case"2":response="status-active";break;case"3":response="status-canceled";break;case"4":response="status-finish";break;default:response=null}return response}}),publish.controller("PublishController",["$scope","$filter","publishService","$modal","$alert","$timeout",function($scope,$filter,publishService,$modal,$alert,$timeout){var initializing=!1;$scope.pagination=data.data.pagination,$scope.publish=data.data.publish,$scope.status=data.status,$scope.type=data.type,$scope.status_select=data.status,$scope.alert_message=!1;var initializing=!1,currentModal=($modal({scope:$scope,template:"modal-info.tpl",show:!1}),publishService.getCurrentModalPreview($modal,$scope));$scope.color_status=publishService.setColorStatus($scope.status_select),$scope.urlNewPublish=Routing.generate("ds_facyt_infrastructure_admin_new_"+data.type.toLowerCase()),$scope.$watch("status_select",function(){if(initializing){$scope.alert_message=1;var start_date=null,end_date=null;$scope.start_date&&(start_date=moment($scope.start_date,"DD/MM/YYYY").format("YYYY-MM-DD")),$scope.end_date&&(end_date=moment($scope.end_date,"DD/MM/YYYY").format("YYYY-MM-DD")),$scope.color_status=publishService.setColorStatus($scope.status_select);var data=angular.toJson({status:$scope.status_select,type:$scope.type,page:0,start_date:start_date,end_date:end_date});publishService.ajaxGetPublish(data,$scope),$timeout(function(){$scope.alert_message=!1},1500)}}),$scope.$watch("start_date",function(){if(initializing){$scope.alert_message=!0;var start_date=moment($scope.start_date,"DD/MM/YYYY");$scope.end_date||($scope.end_date=start_date.add(7,"days").format("DD/MM/YYYY"));var end_date=moment($scope.end_date,"DD/MM/YYYY");start_date.isAfter(end_date)&&($scope.end_date=start_date.add(1,"days").format("DD/MM/YYYY"));var data=angular.toJson({status:$scope.status_select,type:$scope.type,page:0,start_date:start_date.format("YYYY-MM-DD"),end_date:end_date.format("YYYY-MM-DD")});publishService.ajaxGetPublish(data,$scope),$timeout(function(){$scope.alert_message=!1},1500)}}),$scope.$watch("end_date",function(){if(initializing){if($scope.alert_message=!0,$scope.start_date){var start_date=moment($scope.start_date,"DD/MM/YYY/"),end_date=moment($scope.end_date,"DD/MM/YYY/");start_date.isAfter(end_date)&&($scope.start_date=end_date.subtract(1,"days").format("DD/MM/YYYY"))}else $scope.start_date=moment($scope.end_date,"DD/MM/YYYY").subtract(7,"days").format("DD/MM/YYYY");$timeout(function(){$scope.alert_message=!1},1500)}}),$scope.generatePagination=function(page){var start_date=null,end_date=null;if($scope.alert_message=1,null!=$scope.start_date)var start_date=moment($scope.start_date,"DD/MM/YYYY").format("YYYY-MM-DD");if(null!=$scope.end_date)var end_date=moment($scope.start_date,"DD/MM/YYYY").format("YYYY-MM-DD");var data=angular.toJson({status:$scope.status_select,type:$scope.type,page:page,start_date:start_date,end_date:end_date,page:page});publishService.ajaxGetPublish(data,$scope),$timeout(function(){$scope.alert_message=!1},1500)},$scope.modalPreviewPublish=function(publish_id){$scope.indexPreview=publish_id,$scope.color_status_preview=publishService.setColorStatus($scope.publish[publish_id].status),currentModal.$promise.then(currentModal.show);var publish_type=data.type.toLowerCase(),auxUrl="ds_facyt_infrastructure_admin_edit_"+publish_type;switch(publish_type){case"text":$scope.urlEdit=Routing.generate(auxUrl,{textId:$scope.publish[publish_id].id});break;case"image":$scope.urlEdit=Routing.generate(auxUrl,{imageId:$scope.publish[publish_id].id})}},$scope.deletePublish=function(publishIndex){var url=Routing.generate("ds_facyt_infrastructure_admin_publish_delete"),data=angular.toJson({publish_id:$scope.publish[publishIndex].id,type:$scope.type});$scope.alert_message=4,$.ajax({method:"POST",data:data,url:url,success:function(data){$scope.publish.splice(publishIndex,1),currentModal.$promise.then(currentModal.hide),$timeout(function(){$scope.alert_message=!1},3e3)}})},$scope.updateImportant=function(publishIndex){var important=null;1==$scope.publish[publishIndex].important?(important=!1,$scope.alert_message=3):(important=!0,$scope.alert_message=2);var url=Routing.generate("ds_facyt_infrastructure_admin_update_important"),data=angular.toJson({publish_id:$scope.publish[publishIndex].id,type:$scope.type,important:important});$.ajax({method:"POST",data:data,url:url,success:function(data){$scope.publish[publishIndex].important=important,currentModal.$promise.then(currentModal.hide),$timeout(function(){$scope.alert_message=!1},3e3),$scope.$apply()}})},$timeout(function(){initializing=!0,$scope.$apply()})}]);