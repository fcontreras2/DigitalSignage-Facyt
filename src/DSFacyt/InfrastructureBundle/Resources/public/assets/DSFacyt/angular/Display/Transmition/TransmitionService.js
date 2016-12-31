Transmition.service('TransmitionService', function(){   

    //Obtener el Día y Mes Actual
    this.getCurrentDate = function() {
        var today = new Date();
        var day_number = today.getDate();
        var day_weekend = today.getDay()-1;
        console.log(day_weekend);
        var month = today.getMonth(); //January is 0!        
        var response = '';
        switch (day_weekend) {
            case 0:
                response = 'Domingo';
                break;
            case 1:
                response = 'Lunes';
                break;

            case 2:
                response = 'Miércoles';
                break;

            case 3:
                response = 'Jueves';
                break;

            case 4:
                response = 'Viernes';
                break;

            case 5:
                response = 'Sábado';
                break;
        }

        switch (month) {
            case 0:
                response = response + ', Enero';
                break;
            case 1:
                response = response + ', Febrero';
                break;
            case 2:
                response = response + ', Marzo';
                break;
            case 3:
                response = response + ', Abril';
                break;
            case 4:
                response = response + ', Mayo';
                break;
            case 5:
                response = response + ', Junio';
                break;
            case 6:
                response = response + ', Julio';
                break;
            case 7:
                response = response + ', Agosto';
                break;
            case 8:
                response = response + ', Septiembre';
                break;
            case 9:
                response = response + ', Octubre';
                break;
            case 10:
                response = response + ', Noviembre';
                break;
            case 11:
                response = response + ', Diciembre';
                break;
        }

        return response + ' ' + day_number;
    }

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
                [{src: $sce.trustAsResourceUrl('/uploads/videos/'+value.video_url), type: value.mime_type,id:value.id}]
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
    this.checkChange = function(check_data, current_publications, types, current_value) {

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
                                else if (value_parent.status == 3 && key_child != current_value) {
                                    array_delete.push(key_child);
                                }
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
                    }).carousel(0);
                }            
            }
        };
    }   

    this.checkVideos = function(check_data, current_publications, types, current_value,$sce,videos) {
        if (check_data) {
            var array_delete = [];
            var deleteIndex = null;
            var flag = false;
            if (check_data.length > 0) {
                $.each(check_data, function (key_parent, value_parent) {
                    flag = false;
                    $.each(videos, function (key_child, value_child) {
                        if (value_child.id == value_parent.id) {
                            flag = true;
                            if (value_parent.status == 3) {
                                deleteIndex = key_child;
                            }
                        }
                    });
                // Agregando nueva publicación en la transmición
                if (!flag && (value_parent.status == 2 || value_parent.status == 1)){
                    videos.push(value_parent);
                    current_publications.push(
                        [{src: $sce.trustAsResourceUrl('/uploads/videos/'+value_parent.video_url), type: value_parent.mime_type,id:value_parent.id}]
                        );                
                } else if (flag && value_parent.status == 3 && current_value != deleteIndex) {
                    videos.splice(deleteIndex,1);
                    current_publications.splice(deleteIndex,1);
                }

                });
            }
        }
    } 
});