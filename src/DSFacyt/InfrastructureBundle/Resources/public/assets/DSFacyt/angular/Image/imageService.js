image.service('imageService', function(){

    this.checkStatus = function(data) {
        $.each(data, function (index, value) {
            switch (value.status) {
                case 0:
                value.classStatus = 'fa fa-circle';
                break;
                case 1:
                value.classStatus = 'fa fa-circle-o';
                break;
                case 2:
                value.classStatus = 'fa fa-circle-thin';
                break;

            }
        });
    }

    this.ajaxGetPublish = function(data, $scope){
        var url = Routing.generate('ds_facyt_infrastructure_get_publish_async');
        $.ajax({
            method: 'POST',
            data: data,
            url: url,
            success: function(data) {
                $scope.pagination = data.pagination;
                $scope.publish = data.publish;                
                $scope.$apply();
            }
        });
    };

    this.setColorStatus = function (status_select) {

        var response = 0;
        switch (status_select) {
            case 0:
                response = 'status-new';
                break;
            case '1':
                response = 'status-change';
                break;
            case '2':
                response = 'status-accepted';
                break;
            case '3':
                response = 'status-active';                
                break;
            case '4':
                response = 'status-finish';
                break;
            case '5':
                response = 'status-canceled';
                break;
            default:
                response = 'status-new';
                break;
        }

        return response;
    }
});