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

    // Verificación de los ultimos estados de las publicaciones
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

    // Actualiza las actuales publicaciones
    this.checkChange = function(check_data, current_publications, types) {

        if (check_data) {
            var array_delete = [];
            if (check_data.length > 0) {
                $.each(check_data, function (key_parent, value_parent) {
                    var flag = false;
                    $.each(current_publications, function (key_child, value_child) {
                        if (value_child.id == value_parent.id) {
                             flag = true;
                            if (types != 'quick-notes') {
                                if (value_parent.status == 2) 
                                    current_publications[key_child] = value_parent;
                                else if (value_parent.status == 3)
                                    array_delete.push(key_child);
                            } else {                                
                                if (value_parent.status == 1) 
                                    current_publications[key_child] = value_parent;
                                else 
                                    array_delete.push(key_child);
                            }
                        }
                    });

                    // Agregando nueva publicación en la transmición
                    if (!flag && (value_parent.status == 2 || value_parent.status == 1))
                        current_publications.push(value_parent);                
                });

                // Si se debe eliminar las publicaciones
                if (array_delete.length > 0) {
                    $("#carousel-"+types).carousel('pause');
                    
                    $.each(array_delete, function(key, value) {
                        current_publications.splice(value,1);
                    });

                    $('#carousel-'+types).carousel({
                        pause: 'hover',
                        wrap: true,
                        keyboard: true
                    });
                }            
            }
        };
    }   
});