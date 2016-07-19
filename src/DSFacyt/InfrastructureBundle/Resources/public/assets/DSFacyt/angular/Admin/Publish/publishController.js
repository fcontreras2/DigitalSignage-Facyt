publish.controller('PublishController', ['$scope','$filter', 'publishService', '$modal', '$alert', '$timeout','$interval',
    function ($scope, $filter,publishService, $modal, $alert, $timeout, $interval)
    {
        var initializing = false;
        console.log(data);
        $scope.notifications = {};
        $scope.pagination = data.data.pagination;
        $scope.publish = data.data.publish;
        $scope.status = data.status;
        $scope.type = data.type;
        $scope.status_select = data.status;
        $scope.alert_message = false;
        $scope.urlEdit = null;
        var initializing = false;
        var modalInfo = $modal({scope: $scope, template: 'modal-info.tpl', show: false });
        var currentModal = publishService.getCurrentModalPreview($modal, $scope);
        $scope.color_status = publishService.setColorStatus($scope.status_select);
        $scope.urlNewPublish = Routing.generate('ds_facyt_infrastructure_admin_new_'+data.type.toLowerCase());

        $scope.$watch('status_select', function() {            
            if (initializing) {
                $scope.alert_message = 1;
                var start_date = null;
                var end_date = null;

                if ($scope.start_date)
                    start_date = moment($scope.start_date, 'DD/MM/YYYY').format('YYYY-MM-DD');

                if ($scope.end_date)
                    end_date = moment($scope.end_date, 'DD/MM/YYYY').format('YYYY-MM-DD');

                $scope.color_status = publishService.setColorStatus($scope.status_select);

                var data = angular.toJson({
                    'status': $scope.status_select,
                    'type': $scope.type,
                    'page': 1,
                    'start_date' : start_date,
                    'end_date' : end_date
                });

                publishService.ajaxGetPublish(data, $scope);
                $timeout(function() { $scope.alert_message = false;}, 1500);
                
            }
        });

        $scope.$watch('start_date', function() {
            if (initializing) {
                $scope.alert_message = true;
                var start_date = moment($scope.start_date, 'DD/MM/YYYY');
                if (!$scope.end_date)
                    $scope.end_date = start_date.add(7, 'days').format('DD/MM/YYYY');

                var end_date = moment($scope.end_date,'DD/MM/YYYY');

                if (start_date.isAfter(end_date))
                    $scope.end_date = start_date.add(1, 'days').format('DD/MM/YYYY');

                var data = angular.toJson({
                    'status': $scope.status_select,
                    'type' : $scope.type,
                    'page' : 1,
                    'start_date' : start_date.format('YYYY-MM-DD'),
                    'end_date': end_date.format('YYYY-MM-DD')
                })

                publishService.ajaxGetPublish(data, $scope);
                $timeout(function() { $scope.alert_message = false;}, 1500);
            }
        });

        $scope.$watch('end_date', function(){
            if (initializing) {
                $scope.alert_message = true;

                if (!$scope.start_date) {
                    $scope.start_date = moment($scope.end_date, 'DD/MM/YYYY').subtract(7,'days').format('DD/MM/YYYY');
                } else {
                    var start_date = moment($scope.start_date,'DD/MM/YYY/');
                    var end_date = moment($scope.end_date,'DD/MM/YYY/');

                    if (start_date.isAfter(end_date))
                        $scope.start_date = end_date.subtract(1,'days').format('DD/MM/YYYY');

                }
                $timeout(function() { $scope.alert_message = false;}, 1500);
            }
        });

        $scope.generatePagination = function (page)
        {
            var start_date = null;
            var end_date = null;

            $scope.alert_message = 1;

            if ($scope.start_date != null)
                var start_date = moment($scope.start_date,'DD/MM/YYYY').format('YYYY-MM-DD');

            if ($scope.end_date != null)
                var end_date = moment($scope.start_date,'DD/MM/YYYY').format('YYYY-MM-DD');

            var data = angular.toJson({
                'status': $scope.status_select,
                'type' : $scope.type,
                'page' : page,
                'start_date' : start_date,
                'end_date': end_date                
            })

            publishService.ajaxGetPublish(data, $scope);

            $timeout( function(){
                $scope.alert_message = false;
            },1500);
        };
        
        $scope.generateUrlEdit = function(publish_id) {
            var publish_type = data.type.toLowerCase();
            var auxUrl = 'ds_facyt_infrastructure_admin_edit_'+publish_type;
            
            switch (publish_type) {
                case 'text':
                    $scope.urlEdit = Routing.generate( auxUrl, {'textId' : $scope.publish[publish_id].id });
                    break;
                case 'image':
                    $scope.urlEdit = Routing.generate( auxUrl, {'imageId' : $scope.publish[publish_id].id });
                    break;
                case 'video':
                    $scope.urlEdit = Routing.generate( auxUrl, {'videoId' : $scope.publish[publish_id].id});
                    break;
            }           
        }        

        $scope.deletePublish = function(publishIndex) {
            
            var url = Routing.generate('ds_facyt_infrastructure_admin_publish_delete');
            var data = angular.toJson({
                "publish_id": $scope.publish[publishIndex].id,
                "type": $scope.type
            }); 

            $scope.alert_message = 4;
            
            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {
                    $scope.publish.splice(publishIndex, 1);
                    currentModal.$promise.then(currentModal.hide)                    
                      $timeout( function(){
                        $scope.alert_message = false;
                    },3000);
                    
                }                
            });            
        }

        $scope.updateImportant = function(publishIndex) {

            var important = null;
            
            if ($scope.publish[publishIndex].important == true) {
                important = false;
                $scope.alert_message = 3;                
            } else {
                important = true;
                $scope.alert_message = 2;                
            }

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
                    
                    $timeout( function(){
                        $scope.alert_message = false;
                    },3000);
                    
                    $scope.$apply();
                }                
            });
        }

        $interval(function() {
            publishService.checkNotifications($scope);
        }, 1000);

        $timeout(function() { initializing = true; $scope.$apply();});

}]);