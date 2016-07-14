uploadImage.controller('UploadImageController', ['$scope','$modal','UploadImageService','Upload','$window','$timeout',
    function ($scope, $modal, UploadImageService,Upload,$window, $timeout) {
        
        $scope.data = data;
        $scope.data.publish_time = '7:00 AM'
        $scope.config = data.config;
        $scope.alert_message = null;
        var cropImageModal = $modal({scope: $scope, template: 'modal-uploadImage.tpl', show: false});    
        
        $scope.bounds = {};
        $scope.cropper = {};
        $scope.cropper.sourceImage = null;
        $scope.cropper.croppedImage   = null;
        $scope.bounds = {};
        $scope.bounds.left = 0;
        $scope.bounds.right = 0;
        $scope.bounds.top = 0;
        $scope.bounds.bottom = 0;

        if ($scope.data.pathImage) {
            $scope.cropper.croppedImage = '/uploads/images/' + $scope.data.pathImage;
            $scope.cropper.sourceImage = true;
        }
        
        $scope.showCropImageModal = function() {
            cropImageModal.$promise.then(cropImageModal.show);        
        };

        $scope.hideModal = function() {
            cropImageModal.$promise.then(cropImageModal.show);
        };

        $scope.setData = function($file){
            var url = Routing.generate('ds_facyt_infrastructure_user_image_set');            
            var data = angular.toJson($scope.data);
            
            Upload.upload({
                url: url,
                data: {file: Upload.dataUrltoBlob($file), data: data}
            }).progress(function (evt) {
                $timeout(function() { $scope.alert_message = 1;}, 1500);
            }).success(function (request) {
                $timeout(function() { $scope.alert_message = false;}, 1500);
                $window.location.href = Routing.generate('ds_facyt_infrastructure_user_image_homepage');
            }).error(function (data, status, headers, config) {
                console.log('error');
            });
        }
    }]);