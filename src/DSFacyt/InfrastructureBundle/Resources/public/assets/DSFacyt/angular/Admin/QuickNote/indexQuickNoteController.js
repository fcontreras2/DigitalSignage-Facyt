indexQuickNote.controller('IndexQuickNoteController', ['$scope', 'IndexQuickNoteService',
    function ($scope, IndexQuickNoteService){
        console.log(data);
    $scope.pagination = data.pagination;
    $scope.quick_notes = data.quick_notes;

    $scope.generatePagination = function (page)
    {
        console.log(page);
        var data = angular.toJson({
            'page' : page            
        })

        var url = Routing.generate('ds_facyt_infrastructure_admin_quicknote_asinc_pagination');
        $.ajax({
            method: 'POST',
            data: data,
            url: url,
            success: function(data) {
                $scope.pagination = data.pagination;
                $scope.quick_notes = data.quick_notes;
                $scope.$apply();
            }
        });
    };
}]);