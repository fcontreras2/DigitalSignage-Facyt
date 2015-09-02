text.controller('TextController', ['$scope','$filter', 'textService', '$modal', '$alert',
    function ($scope, $filter,textService, $modal, $alert) {

        $scope.data = data;

        var myAlert = $alert(
            {
                title: 'Sin publicaciones',
                content: 'No tiene ninguna publicación de tipo texto',
                placement: 'top',
                type: 'info',
                show: true,
                container:'#empty-table'
            });

        if ($scope.data.length == 0 ) {
            $scope.data = [];
            myAlert.$promise.then(function() {myAlert.show();});
        }

    }]);