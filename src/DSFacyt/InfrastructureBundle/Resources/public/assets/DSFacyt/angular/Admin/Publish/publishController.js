publish.controller('PublishController', ['$scope','$filter', 'publishService', '$modal', '$alert', '$timeout',
    function ($scope, $filter,publishService, $modal, $alert, $timeout)
    {
        $scope.pagination = data.data.pagination;
        $scope.publish = data.data.publish;
        $scope.status = data.status;
        $scope.type = data.type;
        $scope.status_select = 0;
        var initializing = false;
        var modalInfo = $modal({scope: $scope, template: 'modal-info.tpl', show: false });
        var currentModal = publishService.getCurrentModalPreview($modal, $scope);

        $scope.urlNewPublish = Routing.generate('ds_facyt_infrastructure_admin_new_'+data.type.toLowerCase());

        $scope.$watch('status_select', function() {
            if (initializing) {

                var start_date = null;
                var end_date = null;

                if ($scope.start_date)
                    start_date = moment($scope.start_date, 'DD/MM/YYYY').format('YYYY-MM-DD');

                if ($scope.end_date)
                    end_date = moment($scope.end_date, 'DD/MM/YYYY').format('YYYY-MM-DD');


                var data = angular.toJson({
                    'status': $scope.status_select,
                    'type': $scope.type,
                    'page': 0,
                    'start_date' : start_date,
                    'end_date' : end_date
                });

                publishService.ajaxGetPublish(data, $scope);
            }
        });

        $scope.$watch('start_date', function() {
            if (initializing) {

                var start_date = moment($scope.start_date, 'DD/MM/YYYY');
                if (!$scope.end_date)
                    $scope.end_date = start_date.add(7, 'days').format('DD/MM/YYYY');

                var end_date = moment($scope.end_date,'DD/MM/YYYY');

                if (start_date.isAfter(end_date))
                    $scope.end_date = start_date.add(1, 'days').format('DD/MM/YYYY');

                var data = angular.toJson({
                    'status': $scope.status_select,
                    'type' : $scope.type,
                    'page' : 0,
                    'start_date' : start_date.format('YYYY-MM-DD'),
                    'end_date': end_date.format('YYYY-MM-DD')
                })

                publishService.ajaxGetPublish(data, $scope);
            }
        });

        $scope.$watch('end_date', function(){
            if (initializing) {

                if (!$scope.start_date) {
                    $scope.start_date = moment($scope.end_date, 'DD/MM/YYYY').subtract(7,'days').format('DD/MM/YYYY');
                } else {
                    var start_date = moment($scope.start_date,'DD/MM/YYY/');
                    var end_date = moment($scope.end_date,'DD/MM/YYY/');

                    if (start_date.isAfter(end_date))
                        $scope.start_date = end_date.subtract(1,'days').format('DD/MM/YYYY');

                }
            }
        });

        $scope.generatePagination = function (page)
        {
            var start_date = null;
            var end_date = null;

            if ($scope.start_date != null)
                var start_date = moment($scope.start_date,'DD/MM/YYYY').format('YYYY-MM-DD');

            if ($scope.end_date != null)
                var end_date = moment($scope.start_date,'DD/MM/YYYY').format('YYYY-MM-DD');

            var data = angular.toJson({
                'status': $scope.status_select,
                'type' : $scope.type,
                'page' : page,
                'start_date' : start_date,
                'end_date': end_date,
                'page': page
            })

            publishService.ajaxGetPublish(data, $scope);
        };
        
        $scope.modalPreviewText = function(text_id) {
            $scope.indexPreview = text_id;
            currentModal.$promise.then(currentModal.show);
            $scope.urlEdit = Routing.generate('ds_facyt_infrastructure_admin_edit_text', { 'textId' : $scope.publish[text_id].id });            
        }

        $timeout(function() { initializing = true; });

        $scope.deletePublish = function(publishIndex) {
            
            var url = Routing.generate('ds_facyt_infrastructure_admin_publish_delete');
            var data = angular.toJson({
                "publish_id": $scope.publish[publishIndex].id,
                "type": $scope.type
            }); 
            
            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {
                    $scope.publish.splice(publishIndex, 1);
                    currentModal.$promise.then(currentModal.hide)                    
                }                
            });            
        }

        $scope.updateImportant = function(publishIndex) {

            var important = null;

            if ($scope.publish[publishIndex].important == true)
                important = false;
            else 
                important = true;

            var url = Routing.generate('ds_facyt_infrastructure_admin_update_important');
            var data = angular.toJson({
                "publish_id": $scope.publish[publishIndex].id,
                "type": $scope.type,
                "important": important
            }); 
            
            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {
                    $scope.publish[publishIndex].important = important;
                    currentModal.$promise.then(currentModal.hide);
                    /*$scope.requestMessage = 'Asignación correcta';
                    modalInfo.$promise.then(modalInfo.show);
                    $timeout( function(){
                        modalInfo.$promise.then(modalInfo.hide);                        
                    },2000);*/
                    $scope.$apply();
                }                
            });
        }       
}]);