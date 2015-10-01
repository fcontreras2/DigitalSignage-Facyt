text.controller('TextController', ['$scope','$filter', 'textService', '$modal', '$alert',
    function ($scope, $filter,textService, $modal, $alert) {

        $scope.data = data;

        $scope.selectedDate = {date: new Date("2012-09-01")};
        $scope.indexEditText = null;

        var alertEmptyData = $alert(
            {
                title: 'Sin publicaciones',
                content: 'No tiene ninguna publicación de tipo texto',
                placement: 'top',
                type: 'info',
                show: false,
                container:'#empty-table'
            });

        if (!$scope.data.length ) {
            $scope.data = [];
            alertEmptyData.$promise.then(function() {alertEmptyData.show();});
        }

    }]);