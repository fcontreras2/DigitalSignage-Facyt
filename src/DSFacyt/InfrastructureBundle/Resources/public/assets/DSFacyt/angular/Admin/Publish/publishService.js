publish.service('publishService', function(){
    this.ajaxGetPublish = function(data, $scope){
        var url = Routing.generate('ds_facyt_infrastructure_api_get_publish_type_status');
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

    this.getCurrentModalPreview = function($modal, $scope) {

        var currentModal = null;
        switch ($scope.type) {
            case 'Text':
                currentModal = $modal({scope: $scope, template: 'modal-previewText.tpl', show: false});
                break;
            case 'Image':
                currentModal = $modal({scope: $scope, template: 'modal-previewImage.tpl', show: false});
                break;
        }

        return currentModal;        
    }

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
                response = 'status-active';
                break;

            case '3':
                response = 'status-canceled';
                break;

            case '4':
                response = 'status-finish';
                break;
            default:
                response = null;
                break;
        }

        return response;
    }
});