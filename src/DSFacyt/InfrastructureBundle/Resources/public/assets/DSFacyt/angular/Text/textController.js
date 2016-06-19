text.controller('TextController', ['$scope','$filter', 'textService', '$modal', '$alert', '$timeout',
    function ($scope, $filter,textService, $modal, $alert, $timeout) {

        $scope.publish = data.texts;
        $scope.pagination = data.pagination;
        $scope.selectedDate = {date: new Date("2012-09-01")};
        $scope.indexEditText = null;
        $scope.filter = null;
        $scope.order = null;
        $scope.status = -1;
        $scope.alert_message = false;
        var initializing = false;
        console.log($scope.publish);

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
            if (!$scope.publish.length ) {
                $scope.publish= [];            
                return true;
            }
            return false;
        }

        var myOtherModal = $modal({scope: $scope, template: 'modal-previewText.tpl', show: false});

        $scope.modalPreviewText = function(text_id) {
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
            var data = angular.toJson({"text_id": $scope.publish[indexData].id}); 
            
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
                }                
            });            
        }

        $scope.generatePagination = function(pagination) {
            $scope.urlPagination = Routing.generate('ds_facyt_infrastructure_user_text_homepage',{ page : pagination});
        };

        $scope.getUrlEdit = function(text_id) {
            $scope.urlEdit = Routing.generate('ds_facyt_infrastructure_user_text_edit',{
                'textId' : text_id
            });
        };

        $scope.$watch('status_select', function() {
            if (initializing) {
                $scope.alert_message = 1;                
                $scope.color_status = textService.setColorStatus($scope.status_select);
                var status = $scope.status_select >= 0 ? $scope.status_select : null;

                var data = angular.toJson({
                    'status': status,
                    'type': 'Text',
                    'page': 0,
                    'filter': $scope.filter,
                    'order' : $scope.order
                });

                textService.ajaxGetPublish(data, $scope);
                $timeout(function() { $scope.alert_message = false;}, 1500);            
            }
        });

        $scope.setFiler = function(filter) 
        {
            $scope.alert_message = 1;
            if (filter == $scope.filter)
                $scope.order = textService.setOrder($scope.order);
            else{
                $scope.filter = filter;
                $scope.order = 'DESC';
            }

            var data = angular.toJson({
                'status': $scope.status_select,
                'type': 'Text',
                'page': 1,
                'filter': $scope.filter,
                'order' : $scope.order
            });

            textService.ajaxGetPublish(data, $scope);
            $timeout(function() { $scope.alert_message = false;}, 1500);
        }

        $scope.generatePagination = function (page)
        {
            $scope.alert_message = 1;

            var data = angular.toJson({
                'status': $scope.status_select,
                'type' : 'Text',
                'page': page,
                'filter': $scope.filter,
                'order' : $scope.order
            })

            textService.ajaxGetPublish(data, $scope);

            console.log($scope.pagination);
            
            $timeout( function(){
                $scope.alert_message = false;
            },1500);
        };

        $timeout(function() { initializing = true; $scope.$apply();});

    }]);