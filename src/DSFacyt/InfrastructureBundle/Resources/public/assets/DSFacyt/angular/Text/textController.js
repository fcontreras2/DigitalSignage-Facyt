text.controller('TextController', ['$scope','$filter', 'textService', '$modal', '$alert',
    function ($scope, $filter,textService, $modal, $alert) {

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

        if (!$scope.data.length ) {
            $scope.data = [];
            alertEmptyData.$promise.then(function() {alertEmptyData.show();});
        }

        var modalNewText = $modal({scope: $scope, template: 'modal-editText.tpl', show: false});
        
        $scope.editText = function(indexPreview) {
            $scope.indexPreview = indexPreview;
            modalNewText.$promise.then(modalNewText.show);
        };

    }]);