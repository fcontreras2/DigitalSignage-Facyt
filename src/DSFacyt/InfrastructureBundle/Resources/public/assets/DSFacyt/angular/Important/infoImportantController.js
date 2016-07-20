infoimportant.controller('infoImportantController',['$scope','InfoImportantService','$sce', function($scope,InfoImportantService,$sce){
    $scope.data = data;
    
    
    var controller = this;
    controller.API = null;
    
    controller.videos = [];
    console.log($scope.data);
    //Se inicializa los videos actualmente
    controller.videos.push([{src: $sce.trustAsResourceUrl('/uploads/videos/'+$scope.data.video_url), type: $scope.data.mime_type}]);    
    console.log(controller);

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

}]);