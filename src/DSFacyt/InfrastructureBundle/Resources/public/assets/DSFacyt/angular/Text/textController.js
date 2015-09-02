text.controller('TextController', ['$scope','$filter', 'textService', '$modal' ,
    function ($scope, $filter,textService, $modal) {

        $scope.data = $data;

        if ($scope.data.length == 0 ) {
            var $scope.data = [
                {
                    'start_date' : '-',
                    'end_date' : '-'
                }
            ];
        }

    }]);