indexNotification.service('IndexNotificationService', function() {
    
    this.ajaxGetNotifications = function(data,$scope) {
        
        var url = Routing.generate('ds_facyt_admin_asinc_get_notifications');
        $.ajax({
            method: 'POST',
            data: data,
            url: url,
            success: function(data) {
                $scope.pagination = data.pagination;
                $scope.notifiactions = data.notifications;
                $scope.$apply();
            }
        });
    }
});
