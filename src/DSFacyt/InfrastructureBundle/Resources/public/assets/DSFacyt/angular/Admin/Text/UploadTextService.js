uploadText.service('UploadTextService', function(){
    this.setColorStatus = function (status_select) {

        var response = 0;
        switch (status_select) {
            case 0:
                response = 'status-new';
                break;

            case '1':
                response = 'status-active';
                break;

            case '2':
                response = 'status-canceled';
                break;

            case '3':
                response = 'status-finish';
                break;
            default:
                response = null;
                break;
        }

        return response;
    }
});