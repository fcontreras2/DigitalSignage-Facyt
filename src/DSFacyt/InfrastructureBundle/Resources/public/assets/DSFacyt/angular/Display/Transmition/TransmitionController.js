Transmition.controller('TransmitionController', ['$scope','TransmitionService','$sce','$timeout','$interval', function ($scope, TransmitionService,$sce, $timeout,$interval) {
    $scope.publish = data.publish;
    $scope.texts = $scope.publish.texts;
    $scope.images = $scope.publish.images;
    $scope.videos = $scope.publish.videos;
    $scope.quickNotes = data.quickNotes;
    $scope.currentVideo = 0;

    var controller = this;
    controller.state = null;
    controller.currentVideo = 0;
    controller.API = null;

    controller.videos = TransmitionService.initialVideos($scope.videos, $sce);

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

    $scope.showImages = false;
    $scope.showVideos = true;
    controller.onPlayerReady = function(API) {
        controller.API = API;        
    };

    controller.onCompleteVideo = function() {
        controller.isCompleted = true;

        controller.currentVideo++;

        if (controller.currentVideo >= controller.videos.length) {
            controller.currentVideo = 0;
            $scope.showVideos = false;
            $scope.showImages = true;

            $('#carousel-images').carousel({
                interval: 1000
            });            
        
            TransmitionService.changeMedia($timeout, $scope.showImages, $scope.showVideos, $scope.videos, $scope.images);

        } else {
            controller.setVideo(controller.currentVideo);
        }
    };

    controller.setVideo = function() {
        controller.API.stop();
        controller.currentVideo = $scope.currentVideo;
        controller.config.sources = controller.videos[$scope.currentVideo];
        $scope.currentVideo++;

        if ($scope.currentVideo % 2 != 0)
            $timeout(controller.API.play.bind(controller.API), 100);
        else {
            $scope.showImages = true;
            $scope.showVideos = false;
        }

        if ($scope.currentVideo > $scope.videos.length - 1)
            $scope.currentVideo = 0;
    };

    TransmitionService.changeMedia($timeout, $scope.showImages, $scope.showVideos, $scope.videos, $scope.images);

    $scope.$watch('showImages', function() {
        if ($scope.showImages) {
            $timeout(function() {
                $scope.showVideos = true;
                $scope.showImages = false;
                $timeout(controller.API.play.bind(controller.API), 100);
            }, ($scope.images.length*2)*1000);
        }
    });
}]);