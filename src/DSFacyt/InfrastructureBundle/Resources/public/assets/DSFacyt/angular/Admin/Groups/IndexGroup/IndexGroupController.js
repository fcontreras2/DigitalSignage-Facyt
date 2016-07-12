indexGroup.controller('IndexGroupController', ['$scope','$window','$timeout','IndexGroupService',
    function ($scope, $window, $timeout,IndexGroupService) {
        
        $scope.pagination = data.pagination;
        console.log(data.groups);
        $scope.groups = data.groups;
        $scope.groupsInputs = {};
        $scope.permisson = {};
        $scope.urlEdit = null;

        $scope.generatePagination = function (page)
        {
            var data = angular.toJson({
                'page': page
            })

            IndexUserService.ajaxGetUsers(data, $scope);
        };        

        $scope.changePermisson = function(id, type, index)
        {
            console.log(id);
            console.log(type);
            console.log(index);
        }
    }]);