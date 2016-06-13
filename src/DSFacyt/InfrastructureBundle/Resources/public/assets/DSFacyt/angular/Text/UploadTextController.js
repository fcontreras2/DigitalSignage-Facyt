uploadText.controller('UploadTextController', ['$scope','$window','$timeout',
    function ($scope, $window, $timeout) {
        
        $scope.data = data;
        $scope.data.publish_time = '7:00 AM'
        $scope.alert_message = null;
        
        $scope.setData = function(){
            var url = Routing.generate('ds_facyt_infrastructure_user_text_set');
            var data = angular.toJson($scope.data);
            $scope.alert_message = 1;
            
            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {
                    $timeout( function(){
                        $scope.alert_message = false;
                    },3000);                    
                    $window.location.href = Routing.generate('ds_facyt_infrastructure_user_text_homepage');
                }                
            });
        }
    }]);