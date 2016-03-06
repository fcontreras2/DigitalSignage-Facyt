publish.controller('PublishController', ['$scope','$filter', 'publishService', '$modal', '$alert',
    function ($scope, $filter,publishService, $modal, $alert) {
    $scope.pagination = data.data.pagination;
    $scope.publish = data.data.publish;
}]);