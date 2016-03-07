publish.controller('PublishController', ['$scope','$filter', 'publishService', '$modal', '$alert',
    function ($scope, $filter,publishService, $modal, $alert)
    {
        $scope.pagination = data.data.pagination;
        $scope.publish = data.data.publish;
        $scope.status = data.status;
        $scope.type = data.type;

        $scope.$watch('status_select', function() {
            var url = Routing.generate('ds_facyt_infrastructure_api_get_publish_type_status');
            var data = angular.toJson({
                'status': $scope.status_select,
                'type' : $scope.type,
                'page' : 0
            });

            $.ajax({
                method: 'POST',
                data: data,
                url: url,
                success: function(data) {
                    $scope.pagination = data.pagination;
                    $scope.publish = data.publish;
                }
            });
        });
    }
]);