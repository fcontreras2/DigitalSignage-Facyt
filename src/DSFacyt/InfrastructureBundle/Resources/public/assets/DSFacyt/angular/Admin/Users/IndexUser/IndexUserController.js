indexUser.controller('IndexUserController', ['$scope','$window','$timeout','IndexUserService',
    function ($scope, $window, $timeout,IndexUserService) {
        
        $scope.pagination = data.pagination;
        $scope.users = data.users;
        $scope.urlEdit = null;

        $scope.generatePagination = function (page)
        {
            var data = angular.toJson({
                'page': page
            })

            IndexUserService.ajaxGetUsers(data, $scope);
        };

        $scope.getUrlEdit = function(userId) {
        	$scope.urlEdit = Routing.generate('ds_facyt_admin_user_edit',{'id':userId});
        }
    }]);