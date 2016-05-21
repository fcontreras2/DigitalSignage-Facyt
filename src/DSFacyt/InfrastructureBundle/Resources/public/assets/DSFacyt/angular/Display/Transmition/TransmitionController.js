Transmition.controller('TransmitionController', ['$scope','TransmitionService','$sce', function ($scope, TransmitionService,$sce) {    
	$scope.publish = data.publish;
    $scope.texts = $scope.publish.texts;
    $scope.images = $scope.publish.images;
    $scope.amountTexts = Math.round($scope.publish.texts.length / 3);
    $scope.quickNotes = data.quickNotes;
    $scope.amountQuickNotes = $scope.quickNotes.length;

    this.config = {
		sources: [
			{src: $sce.trustAsResourceUrl("http://digitalsignagefacyt.dev/uploads/videos/Chino_y_Nacho_-_Andas_En_Mi_Cabeza_ft_Daddy_Yankee(descargaryoutube.com).mp4"), type: "video/mp4"}		

		],
		tracks: [
			{
				src: "http://digitalsignagefacyt.dev/uploads/videos/Chino_y_Nacho_-_Andas_En_Mi_Cabeza_ft_Daddy_Yankee(descargaryoutube.com).mp4",
				kind: "subtitles",
				srclang: "en",
				label: "English",
				default: ""
			}
		],
		theme: "http://digitalsignagefacyt.dev/bundles/dsfacytinfrastructure/assets/vendor/css/videogular.css",
		plugins: {
			poster: "http://www.videogular.com/assets/images/videogular.png"
		}
	};
	$scope.showImages = true;
	$scope.showVideos = false;
}]);