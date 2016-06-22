indexQuickNote.controller('IndexQuickNoteController', ['$scope', 'IndexQuickNoteService',
    function ($scope, IndexQuickNoteService){
        console.log(data);
    $scope.pagination = data.pagination;
    $scope.quick_notes = data.quick_notes;
}]);