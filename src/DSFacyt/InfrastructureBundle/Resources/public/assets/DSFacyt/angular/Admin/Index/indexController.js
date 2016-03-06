index.controller('IndexController', ['$scope','$filter', 'indexService', '$modal', '$alert',
    function ($scope, $filter,indexService, $modal, $alert) {

        $scope.data = data;

        $scope.$watch('start_date', function() {
            $scope.end_date = angular.$input.$scope.start_date;
        });
    }]);