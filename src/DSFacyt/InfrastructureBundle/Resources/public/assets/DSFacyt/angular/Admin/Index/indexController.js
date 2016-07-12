index.controller('IndexController', ['$scope','$filter', 'indexService', '$modal', '$alert', '$timeout','$interval',
    function ($scope, $filter,indexService, $modal, $alert, $timeout,$interval) {

        $scope.data = data;
        $scope.notifications = {};
        var initializing = false;
        $scope.alert_message = false;
        $scope.start_date = moment().format('DD/MM/YYYY');
        var start_date = moment($scope.start_date, 'DD/MM/YYYY');
        $scope.end_date = start_date.add(7, 'days').format('DD/MM/YYYY');

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
                $scope.alert_message = 1;
                indexService.ajaxGetPublish(data, $scope);
                $timeout(function() { $scope.alert_message = false;}, 1500);
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

        $interval(function() {
            indexService.checkNotifications($scope);        
          }, 1000);

        $timeout(function() { initializing = true; });
    }]);