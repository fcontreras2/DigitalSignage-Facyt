uploadvideo.controller('UploadVideoController',['$scope','UploadVideoService','$sce', function($scope,UploadVideoService,$sce){
    $scope.data = data;
    $scope.color_status = UploadVideoService.setColorStatus($scope.data.status);
    $scope.$watch('data.status', function() {$scope.color_status = UploadVideoService.setColorStatus($scope.data.status);});
    
    var controller = this;
    controller.API = null;
    
    controller.videos = [];
    //Se inicializa los videos actualmente
    controller.videos.push([{src: $sce.trustAsResourceUrl('/uploads/videos/'+$scope.data.video_url), type: $scope.data.mime_type}]);    

    // Configuraciones iniciales
    controller.config = {
        preload: "none",
        autoHide: false,
        autoHideTime: 3000,
        autoPlay: true,
        sources: controller.videos[0],
        theme: {
            url: "http://digitalsignagefacyt.dev/bundles/dsfacytinfrastructure/assets/vendor/css/videogular.css",
        },
        plugins: {
            poster: "/images/video.png"
        }
    }

    // Iniciar automaticamente la reproducción de videos
    controller.onPlayerReady = function(API) {
        controller.API = API;        
    };

    // Cuando termina un video
    controller.onCompleteVideo = function() {

        // Se para el video actual
        controller.API.stop();           
    };

     $scope.deleteData = function() {
            var url = Routing.generate('ds_facyt_infrastructure_admin_publish_delete');
            var data  = angular.toJson({'type':'Video','publish_id':$scope.data.id});
            $.ajax({
                method: 'POST',
                data: data,
                url: url, 
                success: function(data) {
                    console.log('bien');
                },
                error: function(data){
                    console.log('mal');
                }
            });
        }

}]);