uploadImage.controller('UploadImageController', ['$scope','$modal','UploadImageService',
    function ($scope, $modal, UploadImageService) {
        
        $scope.data = data;
        var cropImageModal = $modal({scope: $scope, template: 'modal-uploadImage.tpl', show: false});

        $scope.pathImage = data.pathImage;
        
        $scope.bounds = {};
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
            cropImageModal.$promise.then(cropImageModal.show);        
        };

        $scope.hideModal = function() {
            cropImageModal.$promise.then(cropImageModal.show);
        };

        $scope.uploadFile = function() {
            document.getElementById("hidden_aux").filename = $scope.cropper.croppedImage;
        }

        $scope.$watch('cropper.croppedImage', function(){
            console.log("cambi{o", $scope.cropper);
        });

        $scope.setData = function(){
            
        }
    }]);