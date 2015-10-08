text.controller('TextController', ['$scope','$filter', 'textService', '$modal', '$alert',
    function ($scope, $filter,textService, $modal, $alert) {

        $scope.data = data;

        $scope.selectedDate = {date: new Date("2012-09-01")};
        $scope.indexEditText = null;

        var alertEmptyData = $alert(
            {
                title: 'Sin publicaciones',
                content: 'No tiene ninguna publicación de tipo texto',
                placement: 'top',
                type: 'info',
                show: false,
                container:'#empty-table'
            });

        checkEmptyData(alertEmptyData);        


        function checkEmptyData(alertEmptyData) {
            if (!$scope.data.length ) {
                $scope.data = [];
                alertEmptyData.$promise.then(function() {alertEmptyData.show();});
            }
        }

        var myOtherModal = $modal({scope: $scope, template: 'modal-deleteText.tpl', show: false});

        $scope.modalDeleteText = function(text_id) {
            $scope.indexPreview = text_id;
            myOtherModal.$promise.then(myOtherModal.show);
        }


        $scope.deleteText = function(indexData) {
            var url = Routing.generate('ds_facyt_infrastructure_user_text_delete');
            var data = angular.toJson({"text_id": $scope.data[indexData].text_id}); 
            $.ajax({
                method: 'POST',
                data: data,                
                url: url,
                success: function(data) {
                    $scope.data.splice(indexData, 1);                    
                    myOtherModal.$promise.then(myOtherModal.hide);
                    checkEmptyData();
                }
            });
        }

    }]);