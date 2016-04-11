user.service('userService', function(){

    // Asigna los valores originales a los input de editar los datos
    this.resetValues = function(originalData, editData) {
        editData.identity_card = originalData.identity_card;
        editData.name = originalData.name;
        editData.last_name = originalData.last_name;
        editData.school = originalData.school;
        editData.school_id = originalData.school_id;
        editData.phone = originalData.phone;
    }

    this.resetCropper = function (cropImageModal, $scope, $modal) {
    	$scope.cropper = {};
        $scope.cropper.sourceImage = null;
        $scope.cropper.croppedImage   = null;
        $scope.bounds = {};
        $scope.bounds.left = 0;
        $scope.bounds.right = 0;
        $scope.bounds.top = 0;
        $scope.bounds.bottom = 0;        
        cropImageModal.$promise.then(cropImageModal.show);        
    }
});