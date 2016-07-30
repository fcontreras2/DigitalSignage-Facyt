indexNotification.controller('IndexNotificationController', ['$scope','$window','$timeout','IndexNotificationService',
    function ($scope, $window, $timeout,IndexNotificationService) {

        $scope.pagination = data.pagination;
        $scope.notifications = data.notifications;
        $scope.urlEdit = null;
        $scope.font_type = null;
        $scope.type_select = null;
        console.log($scope.notifications);
        $scope.generatePagination = function (page)
        {
            var data = angular.toJson({
                'page': page
            })

            IndexNotificationService.ajaxGetNotifications(data, $scope);
        };

        $scope.getUrlEdit = function (index) {
            var routing = 'ds_facyt_infrastructure_admin_edit_' + $scope.notifications[index].type;
            
            switch ($scope.notifications[index].type) {
                case 'text':
                    $scope.urlEdit = Routing.generate(routing,{'textId': $scope.notifications[index].publish_id });
                    break;
                case 'image':
                    $scope.urlEdit = Routing.generate(routing,{'imageId' : $scope.notifications[index].publish_id });
                    break;
                case 'video':
                    $scope.urlEdit = Routing.generate(routing,{'videoId' : $scope.notifications[index].publish_id });
                    break;
            }                        

            $scope.notifications[index].view = true;
            var data = angular.toJson({'id': $scope.notifications[index].id});
            var url = Routing.generate('ds_facyt_admin_change_view');
            $.ajax({
                method: 'POST',
                data: data,
                url: url,
                success: function(data) {
                    
                }
            });
        }

        $scope.$watch('type_select', function() {  
            $scope.font_type = IndexNotificationService.getFontType($scope.type_select);           
        });        
    }]);