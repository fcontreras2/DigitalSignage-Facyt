uploadImage.controller('UploadImageController', ['$scope','$modal','UploadImageService',
    function ($scope, $modal, UploadImageService) {
        
        var cropImageModal = $modal({scope: $scope, template: 'modal-uploadImage.tpl', show: false});

        $scope.pathImage = data.pathImage;
        $scope.cropper = {};
        $scope.cropper.sourceImage = null;
        $scope.cropper.croppedImage   = null;
        $scope.bounds = {};
        $scope.bounds.left = 0;
        $scope.bounds.right = 0;
        $scope.bounds.top = 0;
        $scope.bounds.bottom = 0; 

        if ($scope.pathImage) {
            $scope.cropper.croppedImage = '/uploads/images/' + $scope.pathImage;
            $scope.cropper.sourceImage = true;
        }

        
        $scope.showCropImageModal = function() {
            UploadImageService.resetCropper(cropImageModal, $scope, $modal);
        };

        $scope.hideModal = function() {
            UploadImageService.resetCropper(cropImageModal, $scope, $modal);
        };

        $scope.uploadFile = function($file) {
            cropImageModal.$promise.then(cropImageModal.hide);
        }
    }]);