uploadImage.controller('UploadImageController', ['$scope','$modal','UploadImageService','Upload','$window','$timeout',
    function ($scope, $modal, UploadImageService,Upload,$window, $timeout) {

        $scope.data = data;
        $scope.data.publish_time = '7:00 AM'
        $scope.alert_message = null;
        $scope.config = data.config;
        console.log($scope.data);
        var cropImageModal = $modal({scope: $scope, template: 'modal-uploadImage.tpl', show: false});    
        $scope.color_status = UploadImageService.setColorStatus($scope.data.status);

        $scope.bounds = {};
        $scope.cropper = {};
        $scope.cropper.sourceImage = null;
        $scope.cropper.croppedImage   = null;
        $scope.bounds = {};
        $scope.bounds.left = 0;
        $scope.bounds.right = 0;
        $scope.bounds.top = 0;
        $scope.bounds.bottom = 0;
        $scope.editImage = false;

        if ($scope.data.pathImage) {
            $scope.cropper.croppedImage = '/uploads/images/' + $scope.data.pathImage;
            $scope.cropper.sourceImage = true;
        }
        
        $scope.showCropImageModal = function() {
            $scope.editImage = true;
            cropImageModal.$promise.then(cropImageModal.show);        
        };

        $scope.hideModal = function() {
            cropImageModal.$promise.then(cropImageModal.show);
        };

        $scope.setData = function($file){
            var url = Routing.generate('ds_facyt_infrastructure_admin_image_set');
            var data = angular.toJson($scope.data);
            var allData = null;
            if ($scope.editImage) 
                allData = {file: Upload.dataUrltoBlob($file), data: data}
            else 
                allData = {data: data}            

            Upload.upload({
                url: url,
                data: allData,
            }).progress(function (evt) {
                $timeout(function() { $scope.alert_message = 1;}, 1500);
            }).success(function (request) {
                $timeout(function() { $scope.alert_message = false;}, 1500);
                $window.location.href = Routing.generate('ds_facyt_infrastructure_get_publish_type_status',{'type':'image','status': $scope.data.status});
            }).error(function (data, status, headers, config) {
                console.log('error');
            });
        }

        $scope.deleteData = function() {
            var url = Routing.generate('ds_facyt_infrastructure_admin_publish_delete');
            var data  = angular.toJson({'type':'Image','publish_id':$scope.data.id});
            $.ajax({
                method: 'POST',
                data: data,
                url: url, 
                success: function(data) {
                    console.log('bien');
                },
                error: function(data){
                    console.log('mal');
                }
            });
        }

        $scope.$watch('data.status', function() {$scope.color_status = UploadImageService.setColorStatus($scope.data.status);});
    }]);