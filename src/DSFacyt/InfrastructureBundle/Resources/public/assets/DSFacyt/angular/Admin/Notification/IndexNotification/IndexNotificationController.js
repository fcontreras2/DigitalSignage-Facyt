indexNotification.controller('IndexNotificationController', ['$scope','$window','$timeout','IndexNotificationService',
    function ($scope, $window, $timeout,IndexNotificationService) {

        $scope.pagination = data.pagination;
        $scope.notifications = data.notifications;
        $scope.generatePagination = function (page)
        {
            var data = angular.toJson({
                'page': page
            })

            IndexNotificationService.ajaxGetNotifications(data, $scope);
        };
    }]);