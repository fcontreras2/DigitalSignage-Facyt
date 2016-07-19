uploadvideo.controller('UploadVideoController',['$scope','UploadVideoService','$sce', function($scope,UploadVideoService,$sce){
    $scope.data = data;
    $scope.color_status = UploadVideoService.setColorStatus($scope.data.status);
    $scope.$watch('data.status', function() {$scope.color_status = UploadVideoService.setColorStatus($scope.data.status);});
    
    var controller = {};
    controller.API = null;
    
    var auxVideo = [{'video_url':$scope.data.video_url, 'mime_type':$scope.data.mime_type}];
    console.log(auxVideo);
    //Se inicializa los videos actualmente
    controller.videos = TransmitionService.initialVideos(auxVideo, $sce);
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

}]);