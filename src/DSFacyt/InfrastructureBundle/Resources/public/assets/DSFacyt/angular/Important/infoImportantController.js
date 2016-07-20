infoimportant.controller('infoImportantController',['$scope','InfoImportantService','$sce', function($scope,InfoImportantService,$sce){
    $scope.data = data;
    
    
    var controller = this;
    controller.API = null;
    
    controller.videos = [];
    //Se inicializa los videos actualmente
    controller.videos.push([{src: $sce.trustAsResourceUrl('/uploads/videos/21335506/titulo_del_video_1758966916.mp4'), type: "video/mp4"}]);    

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
            poster: "http://www.videogular.com/assets/images/videogular.png"
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