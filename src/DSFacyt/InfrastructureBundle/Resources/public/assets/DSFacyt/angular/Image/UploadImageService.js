uploadImage.service('UploadImageService', function(){   

    this.resetCropper = function (cropImageModal, $scope, $modal) {
    	/*$scope.cropper = {};
        $scope.cropper.sourceImage = null;
        $scope.cropper.croppedImage   = null;
        $scope.bounds = {};
        $scope.bounds.left = 0;
        $scope.bounds.right = 0;
        $scope.bounds.top = 0;
        $scope.bounds.bottom = 0;        
        */cropImageModal.$promise.then(cropImageModal.show);        
    }
});