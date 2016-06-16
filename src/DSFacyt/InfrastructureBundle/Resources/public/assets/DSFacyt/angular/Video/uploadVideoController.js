uploadvideo.controller('UploadVideoController', ['$scope','UploadVideoService','Upload','$window','$timeout',
    function ($scope, UploadVideoService,Upload,$window, $timeout) {
        
        $scope.data = data;
        $scope.data.publish_time = '7:00 AM'

        if ($scope.data.pathVideo) {
            $scope.cropper.croppedVideo = '/uploads/videos/' + $scope.data.pathVideo;
            $scope.cropper.sourceVideo = true;
        }

        $scope.setData = function($file){
            var url = Routing.generate('ds_facyt_infrastructure_user_video_set');            
            var data = angular.toJson($scope.data);
            console.log($file);
            
            Upload.upload({
                url: url,
                data: {file: $file, data: data}
            }).progress(function (evt) {
                $timeout(function() { $scope.alert_message = 1;}, 1500);
            }).success(function (request) {
                $timeout(function() { $scope.alert_message = false;}, 1500);
                //$window.location.href = Routing.generate('ds_facyt_infrastructure_user_video_homepage');
            }).error(function (data, status, headers, config) {
                console.log('error');
            });
        }
    }]);
