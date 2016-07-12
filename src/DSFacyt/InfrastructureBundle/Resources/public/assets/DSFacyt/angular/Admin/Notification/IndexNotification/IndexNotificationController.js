indexNotification.controller('IndexNotificationController', ['$scope','$window','$timeout','IndexNotificationService',
    function ($scope, $window, $timeout,IndexNotificationService) {

        $scope.pagination = data.pagination;
        $scope.notifications = data.notifications;
        console.log($scope.notifications);

        $scope.generatePagination = function (page)
        {
            var data = angular.toJson({
                'page': page
            })

            IndexNotificationService.ajaxGetUsers(data, $scope);
        };
    }]);