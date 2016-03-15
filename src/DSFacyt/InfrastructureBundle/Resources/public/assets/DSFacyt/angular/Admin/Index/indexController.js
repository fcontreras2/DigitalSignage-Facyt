index.controller('IndexController', ['$scope','$filter', 'indexService', '$modal', '$alert',
    function ($scope, $filter,indexService, $modal, $alert) {

        $scope.data = data;

        var initializing = false;

        $scope.$watch('status_select', function() {
            if (initializing) {

                var start_date = null;
                var end_date = null;

                if ($scope.start_date)
                    start_date = moment($scope.start_date, 'DD/MM/YYYY').format('YYYY-MM-DD');

                if ($scope.end_date)
                    end_date = moment($scope.end_date, 'DD/MM/YYYY').format('YYYY-MM-DD');


                var data = angular.toJson({

                    'start_date' : start_date,
                    'end_date' : end_date
                });

                indexService.ajaxGetPublish(data, $scope);
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

        $timeout(function() { initializing = true; });
    }]);