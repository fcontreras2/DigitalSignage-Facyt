index.service('indexService', function() {

	this.checkNotifications = function($scope) {
		var url = Routing.generate('ds_facyt_admin_check_notifications');
        $.ajax({
            method: 'POST',
            data: data,
            url: url,
            success: function(data) {
            	console.log(data);
                $scope.notifications = data;
                $scope.$apply();
            }
        });
	}
});
