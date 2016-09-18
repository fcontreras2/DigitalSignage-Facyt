indexNotification.controller('IndexNotificationController', ['$scope','$window','$timeout','IndexNotificationService','$interval',
    function ($scope, $window, $timeout,IndexNotificationService,$interval) {

        $scope.pagination = data.pagination;
        $scope.notifications_ = data.notifications;
        $scope.urlEdit = null;
        $scope.font_type = null;
        $scope.type_select = null;
        
        $scope.generatePagination = function (page)
        {
            var data = angular.toJson({
                'page': page
            })

            IndexNotificationService.ajaxGetNotifications(data, $scope);
        };

        $scope.getUrlEdit = function (index) {
            var routing = 'ds_facyt_infrastructure_admin_edit_' + $scope.notifications_[index].type;
            
            switch ($scope.notifications_[index].type) {
                case 'text':
                    $scope.urlEdit = Routing.generate(routing,{'textId': $scope.notifications_[index].publish_id });
                    break;
                case 'image':
                    $scope.urlEdit = Routing.generate(routing,{'imageId' : $scope.notifications_[index].publish_id });
                    break;
                case 'video':
                    $scope.urlEdit = Routing.generate(routing,{'videoId' : $scope.notifications_[index].publish_id });
                    break;
            }                        

            $scope.notifications_[index].view = true;
            var data = angular.toJson({'id': $scope.notifications_[index].id});
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
        $interval(function() {
            IndexNotificationService.checkNotifications($scope);
        }, 1000);        
    }]);