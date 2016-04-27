publish.controller('PublishController', ['$scope','$filter', 'publishService', '$modal', '$alert', '$timeout',
    function ($scope, $filter,publishService, $modal, $alert, $timeout)
    {
        $scope.pagination = data.data.pagination;
        $scope.publish = data.data.publish;
        console.log($scope.publish);
        $scope.status = data.status;
        $scope.type = data.type;
        $scope.status_select = 0;
        var initializing = false;

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

        var modalText = $modal({scope: $scope, template: 'modal-previewText.tpl', show: false});
        
        $scope.modalPreviewText = function(text_id) {
            $scope.indexPreview = text_id;
            modalText.$promise.then(modalText.show);
            $scope.urlEdit = Routing.generate('ds_facyt_infrastructure_admin_edit_text', { 'textId' : $scope.publish[text_id].id });            
        }

        $timeout(function() { initializing = true; });
    }


]);