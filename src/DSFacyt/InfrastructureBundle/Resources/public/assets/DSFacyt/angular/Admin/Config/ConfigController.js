indexConfig.controller('IndexConfigController', ['$scope','$timeout',
    function ($scope, $timeout) {

        $scope.data = data;
        console.log($scope.data);
        $scope.alert_message = false;


        $scope.updateConfig = function() {
        	var url = Routing.generate('ds_facyt_admin_config_update');
        	var data = angular.toJson($scope.data);
        	$scope.alert_message = 1;
	        $.ajax({
	            method: 'POST',
	            data: data,
	            url: url,
	            success: function() {
					$timeout(function() { $scope.alert_message = false;}, 1500);	            	
	            }
	        });
        }
    }]);