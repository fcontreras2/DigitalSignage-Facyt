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

    this.getFontType = function (type)
    {
        var response = false;

        switch (type) {
            case 'text':
                response = 'fa-pencil';
                break;
            case 'image':
                response = 'fa-picture-o';
                break;
            case 'video':
                response = 'fa-play-circle-o';
                break;
        }

        return response;
    }
});
