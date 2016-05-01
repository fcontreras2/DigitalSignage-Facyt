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
        }

        return currentModal;        
    }
});