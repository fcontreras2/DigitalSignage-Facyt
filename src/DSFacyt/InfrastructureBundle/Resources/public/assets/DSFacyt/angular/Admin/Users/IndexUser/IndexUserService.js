indexUser.service('IndexUserService', function() {
	this.ajaxGetUsers = function(data,$scope) {
		var url = Routing.generate('ds_facyt_infrastructure_api_get_users_filter');
        $.ajax({
            method: 'POST',
            data: data,
            url: url,
            success: function(data) {
                $scope.pagination = data.pagination;
                $scope.users = data.users;
                $scope.$apply();
            }
        });
	}
});
