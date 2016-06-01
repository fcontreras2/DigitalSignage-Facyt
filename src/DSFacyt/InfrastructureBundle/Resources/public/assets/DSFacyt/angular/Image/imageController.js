image.controller('ImageController', ['$scope','$filter', 'imageService', '$modal', '$alert','$timeout',
    function ($scope, $filter,imageService, $modal, $alert, $timeout) {

        $scope.publish = data.images;
        $scope.pagination = data.pagination;
        $scope.status = -1;
        $scope.indexEditText = null;
        $scope.filter = null;
        $scope.order = null;
        $scope.status = -1;
        $scope.alert_message = false;
        var initializing = false;
        
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
            if (!$scope.publish.length ) {
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
            var data = angular.toJson({"image_id": $scope.data[indexData].id}); 
            
            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {
                    $scope.publish.splice(indexData, 1);
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

        $scope.$watch('status_select', function() {
            if (initializing) {
                $scope.alert_message = 1;                
                $scope.color_status = imageService.setColorStatus($scope.status_select);
                var status = $scope.status_select >= 0 ? $scope.status_select : null;

                var data = angular.toJson({
                    'status': status,
                    'type': 'Image',
                    'page': 0,
                    'filter': $scope.filter,
                    'order' : $scope.order
                });

                imageService.ajaxGetPublish(data, $scope);
                $timeout(function() { $scope.alert_message = false;}, 1500);            
            }
        });


        $scope.getUrlEdit = function(image_id) {
          $scope.urlEdit = Routing.generate('ds_facyt_infrastructure_user_image_edit',{
              'imageId' : image_id
          });
        };

        $scope.setFiler = function(filter) 
        {
            $scope.alert_message = 1;
            if (filter == $scope.filter)
                $scope.order = imageService.setOrder($scope.order);
            else{
                $scope.filter = filter;
                $scope.order = 'DESC';
            }

            var data = angular.toJson({
                'status': $scope.status_select,
                'type': 'Image',
                'page': 0,
                'filter': $scope.filter,
                'order' : $scope.order
            });

            imageService.ajaxGetPublish(data, $scope);
            $timeout(function() { $scope.alert_message = false;}, 1500);
        }

        $scope.generatePagination = function (page)
        {
            $scope.alert_message = 1;

            var data = angular.toJson({
                'status': $scope.status_select,
                'type' : 'Image',
                'page': page,
                'filter': $scope.filter,
                'order' : $scope.order
            })

            imageService.ajaxGetPublish(data, $scope);
            
            $timeout( function(){
                $scope.alert_message = false;
            },1500);
        };

        $timeout(function() { initializing = true; $scope.$apply();});
    }]);