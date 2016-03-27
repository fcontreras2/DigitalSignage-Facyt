image.controller('ImageController', ['$scope','$filter', 'imageService', '$modal', '$alert',
    function ($scope, $filter,imageService, $modal, $alert) {

        $scope.data = data.images;
        $scope.pagination = data.pagination;
        imageService.checkStatus($scope.data);

        var alertEmptyData = $alert(
        {
            title: 'Sin publicaciones',
            content: 'No tiene ninguna publicación de tipo texto',
            placement: 'top',
            type: 'info',
            show: false,
            container:'#box-alert'
        });

        var errorDelete = $alert(
        {
            title: 'Error al eliminar',
            content: 'No se pudo eliminar la imagen',
            placement: 'top',
            type: 'danger',
            show: false,
            container:'#box-alert-danger'
        });

        checkEmptyData(alertEmptyData);        

        function checkEmptyData(alertEmptyData) {
            if (!$scope.data.length ) {
                $scope.data = [];
                alertEmptyData.$promise.then(function() {alertEmptyData.show();});
            }
        }

        var myOtherModal = $modal({scope: $scope, template: 'modal-previewImage.tpl', show: false});

        $scope.modalDeleteImage = function(image_id) {
            $scope.indexPreview = image_id;
            errorDelete.$promise.then(function() {errorDelete.hide();});
            myOtherModal.$promise.then(myOtherModal.show);
        }

        var alertDeleteError = $alert(
            {
                title: "Publicación Eliminada",
                content: 'Se ha eliminado correctamente la imagen',
                placement: 'top',
                type: 'success',
                show: false,
                container:'#box-alert'                
            });

        $scope.deleteImage = function(indexData) {
            var url = Routing.generate('ds_facyt_infrastructure_user_image_delete');
            var data = angular.toJson({"image_id": $scope.data[indexData].image_id}); 
            
            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {
                    $scope.data.splice(indexData, 1);
                    myOtherModal.$promise.then(myOtherModal.hide);
                    if (checkEmptyData())
                        alertEmptyData.$promise.then(function() {alertEmptyData.show();});
                    else
                        alertDeleteSuccess.$promise.then(function() {alertDeleteSuccess.show();});
                },
                error: function() {
                    errorDelete.$promise.then(function() {errorDelete.show();});
                }
            });            
        }

        $scope.getUrlEdit = function(image_id) {
          $scope.urlEdit = Routing.generate('ds_facyt_infrastructure_user_image_edit',{
              'imageId' : image_id
          });
        };
    }]);