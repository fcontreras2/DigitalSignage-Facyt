indexGroup.controller('IndexGroupController', ['$scope','$window','$timeout','IndexGroupService',
    function ($scope, $window, $timeout,IndexGroupService) {
        
        $scope.pagination = data.pagination;
        $scope.groups = data.groups;
        $scope.groupsInputs = {};
        $scope.inputs_check = {};

        for (var i = 0; i < $scope.groups.length; i++) {
            $scope.inputs_check[i] = {};
            $scope.inputs_check[i].text  = $scope.groups[i].permissons.indexOf('text') !== -1 ? true: false;
            $scope.inputs_check[i].image = $scope.groups[i].permissons.indexOf('image') !== -1 ? true: false;
            $scope.inputs_check[i].video = $scope.groups[i].permissons.indexOf('video') !== -1 ? true: false;

        };

        $scope.generatePagination = function (page)
        {
            var data = angular.toJson({
                'page': page
            })

            IndexUserService.ajaxGetUsers(data, $scope);
        };        

        $scope.changePermisson = function(id, type, index)
        {
            var url = Routing.generate('ds_facyt_infrastructure_admin_group_edit',{'group_id':id});
            var data = angular.toJson($scope.inputs_check[index]);             

            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {                    
                    console.log('Ok');
                }                
            });
        }

        $scope.setNewGroup = function() {
            var url = Routing.generate('ds_facyt_infrastructure_admin_group_new');
            var data = angular.toJson({
                'name': $scope.newGroup
            });             

            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {                                        
                    $window.location.href = Routing.generate('ds_facyt_admin_group_homepage');
                }                
            });
        }
    }]);