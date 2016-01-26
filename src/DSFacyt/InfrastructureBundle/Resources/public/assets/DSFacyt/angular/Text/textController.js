text.controller('TextController', ['$scope','$filter', 'textService', '$modal', '$alert', '$timeout',
    function ($scope, $filter,textService, $modal, $alert, $timeout) {

        $scope.data = data.texts;
        $scope.pagination = data.pagination;
        $scope.btnAction = 'fa fa-trash';
        $scope.selectedDate = {date: new Date("2012-09-01")};
        $scope.indexEditText = null;
        textService.checkStatus($scope.data);
        var alertEmptyData = $alert(
            {
                title: 'Sin publicaciones',
                content: 'No tiene ninguna publicación de tipo texto',
                placement: 'top',
                type: 'info',
                show: false,
                container:'#box-alert'
            });

        if (checkEmptyData(alertEmptyData)) {
            alertEmptyData.$promise.then(function() {alertEmptyData.show();});
            
        }

        function checkEmptyData(alertEmptyData) {
            if (!$scope.data.length ) {
                $scope.data = [];            
                return true;
            }
            return false;
        }

        var myOtherModal = $modal({scope: $scope, template: 'modal-deleteText.tpl', show: false});

        $scope.modalDeleteText = function(text_id) {
            $scope.indexPreview = text_id;
            myOtherModal.$promise.then(myOtherModal.show);
        }

        var alertDeleteSuccess = $alert(
            {
                title: "Publicación Eliminada",
                content: 'Se ha eliminado correctamente el texto',
                placement: 'top',
                type: 'success',
                show: false,
                container:'#box-alert'                
            });

        
        $scope.deleteText = function(indexData) {
            var url = Routing.generate('ds_facyt_infrastructure_user_text_delete');
            var data = angular.toJson({"text_id": $scope.data[indexData].text_id}); 
            
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
                }                
            });            
        }

        $scope.generatePagination = function(pagination) {
            $scope.urlPagination = Routing.generate('ds_facyt_infrastructure_user_text_homepage',{ page : pagination});
        }

    }]);