user.controller('UserController', ['$scope','Upload','$filter', 'userService','$modal',
    function ($scope, Upload, $filter,userService, $modal) {

        $scope.data = data;
        $scope.profile_data_text = true;
        $scope.editData = {};
        $scope.change_password = false;
        $scope.icon_loading = false;

        
        var cropImageModal = $modal({scope: $scope, template: 'modal-uploadImage.tpl', show: false});
        userService.resetValues($scope.data, $scope.editData);

        $scope.cropper = {};
        $scope.cropper.sourceImage = null;
        $scope.cropper.croppedImage   = null;
        $scope.bounds = {};
        $scope.bounds.left = 0;
        $scope.bounds.right = 0;
        $scope.bounds.top = 0;
        $scope.bounds.bottom = 0; 

        if ($scope.data.profile_image) {
            $scope.cropper.croppedImage = '/uploads/images/' + $scope.data.profile_image;
            $scope.cropper.sourceImage = true;
        }
        

        $scope.editProfile = function() {
            $scope.profile_data_text = false;
        }

        $scope.cancelEditProfile = function () {
            userService.resetValues($scope.data, $scope.editData);
            $scope.profile_data_text = true;
        }

        $scope.cancelChangePassword = function () {
            $scope.change_password = false;
        }

        $scope.sendEditData = function() {
            var url = Routing.generate('ds_facyt_infrastructure_user_edit_profile');
            var data = angular.toJson($scope.editData);

            $.ajax({
                method: 'POST',
                data: data,
                url: url,
                success: function(data) {

                    userService.resetValues($scope.editData,$scope.data);
                    $scope.profile_data_text = true;
                }
            });
        };

        

        $scope.showCropImageModal = function() {
            userService.resetCropper(cropImageModal, $scope, $modal);
        };

        $scope.hideModal = function() {
            userService.resetCropper(cropImageModal, $scope, $modal);
        };

        $scope.uploadFile = function($file) {
            $scope.icon_loading = true;
            cropImageModal.$promise.then(cropImageModal.hide);
            
            Upload.upload({
                url: Routing.generate('ds_facyt_infrastructure_user_upload_image'),
                data: {file: Upload.dataUrltoBlob($file)}
            }).then(function (resp) {
                
            }, function (resp) {

            }, function (evt) {

            });           

        }
    }]);

/**/