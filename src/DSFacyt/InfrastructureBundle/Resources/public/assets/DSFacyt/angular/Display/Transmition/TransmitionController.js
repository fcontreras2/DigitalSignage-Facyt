Transmition.controller('TransmitionController', ['$scope','TransmitionService','$sce','$timeout','$interval', function ($scope, TransmitionService,$sce, $timeout,$interval) {
    $scope.publish = data.publish;
    $scope.slug = data.slug;
    $scope.texts = $scope.publish.texts;
    $scope.images = $scope.publish.images;
    $scope.videos = $scope.publish.videos;
    $scope.quickNotes = data.quickNotes;

    // Inicialización de variables
    $scope.currentVideo = 0;
    $scope.showImages = false;
    $scope.showVideos = true;
    var controller = this;
    controller.API = null;

    //Se inicializa los videos actualmente
    controller.videos = TransmitionService.initialVideos($scope.videos, $sce);
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
            $('#carousel-images').carousel({
                interval: 1000
            });
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
        if ($scope.showImages) {
            $timeout(function() {
                TransmitionService.changeMedia($scope);
                $timeout(controller.API.play.bind(controller.API), 100);
            }, ($scope.images.length)*500);
        }
    });

    $interval(function() {
        TransmitionService.checkPublish($scope);
        TransmitionService.checkChange($scope);
    }, 1000);
}]);