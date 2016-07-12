index.service('indexService', function() {

	this.checkNotifications = function($scope) {
		var url = Routing.generate('ds_facyt_admin_check_notifications');
        $.ajax({
            method: 'POST',
            data: data,
            url: url,
            success: function(data) {
            	$scope.notifications = data;
                $scope.$apply();
            }
        });
	}

    this.ajaxGetPublish = function(data, $scope){
        var url = Routing.generate('ds_facyt_infrastructure_admin_homepage');
        $.ajax({
            method: 'POST',
            data: data,
            url: url,
            success: function(data) {
                $scope.data = data;
                $scope.$apply();
            }
        });
    };
});
