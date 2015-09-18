text.controller('TextController', ['$scope','$filter', 'textService', '$modal', '$alert',
    function ($scope, $filter,textService, $modal, $alert) {

        $scope.data = data;

        $scope.selectedDate = {date: new Date("2012-09-01")};

        var alertEmptyData = $alert(
            {
                title: 'Sin publicaciones',
                content: 'No tiene ninguna publicación de tipo texto',
                placement: 'top',
                type: 'info',
                show: false,
                container:'#empty-table'
            });

        if (!$scope.data.length ) {
            $scope.data = [];
            alertEmptyData.$promise.then(function() {alertEmptyData.show();});
        }

        //Declaración del modal de editar el texto
        //var modalNewText = $modal({scope: $scope, template: 'modal-editText.tpl', show: false});

        // La función muestra el modal de un editar un texto
        $scope.editText = function(indexText) {
            /app_dev.php/panel/text/edit
            $scope.indexEditText = $scope.data[indexText].text_id;
        };

        $scope.sendEditText = function(indexPreview) {

            if ($scope.data[indexPreview] == lastModalText)
                console.log('variable1');
            else
                console.log('variable2', lastModalText);

            console.log('variable1', $scope.data[indexPreview]);
            console.log('variable2', lastModalText);
            //var url = Routing.generate('save_temp_room');

        };

    }]);