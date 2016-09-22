Transmition.controller('TransmitionController', ['$scope','TransmitionService','$sce','$timeout','$interval', function ($scope, TransmitionService,$sce, $timeout,$interval) {

    $scope.slug = data.slug;
    $scope.texts = data.publish.texts;
    $scope.images = data.publish.images;
    $scope.videos = data.publish.videos;
    $scope.quickNotes = data.quickNotes;

    // Inicialización de variables
    $scope.currentVideo = 0;
    if (!$scope.videos.length) {
        $scope.showImages = true;
        $scope.showVideos = false;
    } else {
        $scope.showImages = false;
        $scope.showVideos = true;
    }
    
    var controller = this;
    controller.state = null;
    controller.API = null;
    controller.currentVideo = 0;

    $scope.check_data = null;
    
    // Iniciar automaticamente la reproducción de videos
    controller.onPlayerReady = function(API) {
        controller.API = API;                
    };

    // Cuando termina un video
    controller.onCompleteVideo = function() {
        
        controller.isCompleted = true;
        controller.currentVideo++;

        if (controller.currentVideo >= controller.videos.length) controller.currentVideo = 0;

        controller.API.stop();
        // Se para el video actual
        controller.config.sources = controller.videos[controller.currentVideo];

        // Se reproduce 2 videos a la vez
        if (controller.currentVideo % 2 != 0 && controller.currentVideo != 0){
            $timeout(controller.API.play.bind(controller.API), 100);
        }
        else {                 
            TransmitionService.changeMedia($scope);            
        }
    };

    //Se inicializa los videos actualmente
    controller.videos = TransmitionService.initialVideos($scope.videos, $sce);
    // Configuraciones iniciales
    controller.config = {
        preload: "none",
        autoHide: true,
        autoHideTime: 100,
        autoPlay: true,
        sources: controller.videos[0],
        theme: {
            url: "http://digitalsignagefacyt.dev/bundles/dsfacytinfrastructure/assets/vendor/css/videogular.css",
        },
        plugins: {
            poster: "http://www.videogular.com/assets/images/videogular.png"
        }
    }

    // Cuando cambia la transmisición de videos
    $scope.$watch('showImages', function() {
        if ($scope.showImages && controller.videos.length > 0) {
            $timeout(function() {                
                TransmitionService.changeMedia($scope);                
            }, ($scope.images.length * 1000));
        }
    });

    $scope.$watch('showVideos',function() {
        if ($scope.showVideos) 
            controller.API.play();
        else
            controller.API.stop();

    });

/*    $interval(function() {
        TransmitionService.checkPublish($scope);
        TransmitionService.checkChange($scope.check_data['publish']['texts'], $scope.texts, 'texts');
        TransmitionService.checkChange($scope.check_data['publish']['images'], $scope.images, 'images');
        TransmitionService.checkChange($scope.check_data['publish']['videos'], $scope.videos, 'videos');
        TransmitionService.checkChange($scope.check_data['quick_notes'], $scope.quickNotes, 'quick-notes');        
    }, 5000);*/

    $scope.current_date = TransmitionService.getCurrentDate();
    $interval(function(){        
        $scope.current_date = TransmitionService.getCurrentDate();
    }, 10000);

    $timeout(function(){
        controller.API.play();
    },1000);
}]);