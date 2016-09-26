uploadText.controller('UploadTextController', ['$scope','$window','$timeout','UploadTextService',
    function ($scope, $window, $timeout,UploadTextService) {
        
        $scope.data = data;
        $scope.data.publish_time = '7:00 AM'
        $scope.alert_message = null;
        $scope.color_status = UploadTextService.setColorStatus($scope.data.status);
        console.log($scope.data);
        $scope.setData = function(){
            var url = Routing.generate('ds_facyt_infrastructure_admin_text_set');
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
                    $window.location.href = Routing.generate('ds_facyt_infrastructure_get_publish_type_status',{'type':'text','status': $scope.data.status});
                }                
            });
        }

        $scope.deleteData = function() {
            var url = Routing.generate('ds_facyt_infrastructure_admin_publish_delete');
            var data  = angular.toJson({'type':'Text','publish_id':$scope.data.id});
            $.ajax({
                method: 'POST',
                data: data,
                url: url, 
                success: function(data) {
                    alert('bien');
                },
                error: function(data){
                    alert('mal');
                }
            });
        }

        $scope.$watch('data.status', function() {$scope.color_status = UploadTextService.setColorStatus($scope.data.status);});
    }]);