Transmition.controller('TransmitionController', ['$scope','TransmitionService','$sce','$timeout','$interval', function ($scope, TransmitionService,$sce, $timeout,$interval) {

    $scope.slug = data.slug;
    $scope.texts = data.publish.texts;
    $scope.images = data.publish.images;
    $scope.videos = data.publish.videos;
    $scope.quickNotes = data.quickNotes;

    // Inicialización de variables
    $scope.currentVideo = 0;
    if (!$scope.videos.length) {
        $scope.showImages = false;
        $scope.showVideos = false;
    } else {
        $scope.showImages = false;
        $scope.showVideos = true;
    }
    var controller = this;
    controller.API = null;
    $scope.check_data = null;
    $scope.showVideos = true;

    //Se inicializa los videos actualmente
    controller.videos = [[{src: $sce.trustAsResourceUrl('/uploads/videos/21335506/titulo_del_video_1758966916.mp4'), type: "video/mp4"}]];
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

        // Si termina el ultimo video
        if ($scope.currentVideo > controller.videos.length - 1) {
            controller.currentVideo = 0;
            TransmitionService.changeMedia($scope);
        } else {
            // Se para el video actual
            controller.API.stop();
            $scope.currentVideo++;
            if ($scope.currentVideo > $scope.videos.length - 1)
                $scope.currentVideo = 0;

            controller.config.sources = controller.videos[$scope.currentVideo];

            // Se reproduce 2 videos a la vez
            if ($scope.currentVideo % 2 != 0)
                $timeout(controller.API.play.bind(controller.API), 100);
            else                 
                TransmitionService.changeMedia($scope);            
        }
    };

    // Cuando cambia la transmisición de videos
    $scope.$watch('showImages', function() {
        if ($scope.showImages && $scope.videos.length > 0) {
            $timeout(function() {
                TransmitionService.changeMedia($scope);
                $timeout(controller.API.play.bind(controller.API), 100);
            }, ($scope.images.length * 500));
        }
    });

    $interval(function() {
        TransmitionService.checkPublish($scope);
        TransmitionService.checkChange($scope.check_data['publish']['texts'], $scope.texts, 'texts');
        TransmitionService.checkChange($scope.check_data['publish']['images'], $scope.images, 'images');
        TransmitionService.checkChange($scope.check_data['publish']['videos'], $scope.videos, 'videos');
        TransmitionService.checkChange($scope.check_data['quick_notes'], $scope.quickNotes, 'quick-notes');
        
    }, 5000);

    $scope.current_date = TransmitionService.getCurrentDate();
    $interval(function(){        
        $scope.current_date = TransmitionService.getCurrentDate();
    }, 10000);
    
}]);