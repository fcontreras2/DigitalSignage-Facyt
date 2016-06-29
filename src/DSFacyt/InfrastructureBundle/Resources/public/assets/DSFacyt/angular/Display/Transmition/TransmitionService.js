Transmition.service('TransmitionService', function(){   

    // Cambia las transmisiones entre imagenes y videos
    this.changeMedia = function($scope) {
        $scope.showImages = !$scope.showImages;
        $scope.showVideos = !$scope.showVideos;
    };

    // Inicializamos los videos a transmitir
    this.initialVideos = function(arrayVideos, $sce) {
        var response = [];
        $.each(arrayVideos, function(key, value) {
            response.push(
                [{src: $sce.trustAsResourceUrl('/uploads/videos/'+value.video_url), type: "video/mp4"}]
            );
        });
        return response;
    };

    this.checkPublish = function($scope) {
        var url = Routing.generate('ds_facyt_display_check_publish');
        var data = angular.toJson({"slug": $scope.slug});
        $.ajax({
            method: 'POST',
            data: data,
            url: url,
            success: function(data) {
                if (checkChange($scope, data))
                    $scope.$apply();
            }
        });
    }

    this.checkChange = function($scope, data) {

    }
});