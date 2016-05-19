Transmition.controller('TransmitionController', ['$scope','TransmitionService', function ($scope, TransmitionService) {
    $scope.publish = data.publish;
    $scope.texts = $scope.publish.texts;
    $scope.amountTexts = Math.round($scope.publish.texts.length / 3);
    $scope.quickNotes = data.quickNotes;
    $scope.amountQuickNotes = $scope.quickNotes.length;
    console.log($scope.publish);
    
}]);