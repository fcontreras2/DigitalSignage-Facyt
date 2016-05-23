Transmition.controller('TransmitionController', ['$scope','TransmitionService','$sce','$timeout', function ($scope, TransmitionService,$sce, $timeout) {    
    $scope.publish = data.publish;
    $scope.texts = $scope.publish.texts;
    $scope.images = $scope.publish.images;
    $scope.amountTexts = Math.round($scope.publish.texts.length / 3);
    $scope.quickNotes = data.quickNotes;
    $scope.amountQuickNotes = $scope.quickNotes.length;
    var controller = this;
    controller.state = null;
    controller.currentVideo = 0;
    controller.API = null;

    controller.videos = [        
        [{src: $sce.trustAsResourceUrl("http://digitalsignagefacyt.dev/uploads/videos/Como-funciona-el-Internet.mp4"), type: "video/mp4"}],
        [{src: $sce.trustAsResourceUrl("http://digitalsignagefacyt.dev/uploads/videos/Chino_y_Nacho_-_Andas_En_Mi_Cabeza_ft_Daddy_Yankee(descargaryoutube.com).mp4"), type: "video/mp4"}]
    ];

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

    $scope.showImages = true;
    $scope.showVideos = false;
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

        } else {
            controller.setVideo(controller.currentVideo);
        }
    };

    controller.setVideo = function(index) {
        controller.API.stop();
        controller.currentVideo = index;
        controller.config.sources = controller.videos[index];
        $timeout(controller.API.play.bind(controller.API), 100);
    };


    $timeout(function() {$scope.showVideos = true; $scope.showImages = false}, 100);

}]);