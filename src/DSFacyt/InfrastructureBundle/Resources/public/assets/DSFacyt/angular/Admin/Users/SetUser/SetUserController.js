setUser.controller('SetUserController', ['$scope','$window','$timeout','SetUserService',
    function ($scope, $window, $timeout,SetUserService) {
        $scope.data = data;

        $scope.setData = function() {
            var url = Routing.generate('ds_facyt_infrastructure_admin_user_set');
            var data = angular.toJson($scope.data);            
            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {                    
                    $window.location.href = Routing.generate('ds_facyt_admin_user');
                }                
            });
        }
    }]);