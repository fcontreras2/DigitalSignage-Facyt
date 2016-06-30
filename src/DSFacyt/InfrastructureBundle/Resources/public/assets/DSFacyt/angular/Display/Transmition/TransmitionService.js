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
        var response = null;
        $.ajax({
            method: 'POST',
            data: data,
            url: url,
            success: function(data) {
                $scope.check_data = data;
                $scope.$apply();
            }
        });

    };

    this.checkChange = function($scope) {

        if ($scope.check_data ) {
            console.log($scope.check_data);
            $.each($scope.check_data.publish.texts, function (key_parent, value_parent) {
                $.each($scope.texts, function (key_child, value_child) {
                    if (value_child.id = value_parent.id) {
                        if (value_parent.status == 2)
                            $scope.texts[key_child] = $scope.check_data.texts[key_parent];
                        else if (value_parent.status == 3) {
                            $scope.texts.splice(key_child, 1);
                            $("#carousel-texts").carousel("pause").removeData();
                            $('#carousel-texts').carousel({
                                interval: 10000
                            });
                        }

                        return false;
                    }
                });
            });
        };
    }
});