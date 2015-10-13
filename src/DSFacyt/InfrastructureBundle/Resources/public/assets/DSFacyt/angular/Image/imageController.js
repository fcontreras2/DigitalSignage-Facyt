image.controller('ImageController', ['$scope','$filter', 'imageService', '$modal', '$alert',
    function ($scope, $filter,imageService, $modal, $alert) {

        $scope.data = data;

        var alertEmptyData = $alert(
            {
                title: 'Sin publicaciones',
                content: 'No tiene ninguna publicación de tipo texto',
                placement: 'top',
                type: 'info',
                show: false,
                container:'#empty-table'
            });

        checkEmptyData(alertEmptyData);        

        function checkEmptyData(alertEmptyData) {
            if (!$scope.data.length ) {
                $scope.data = [];
                alertEmptyData.$promise.then(function() {alertEmptyData.show();});
            }
        }

    }]);