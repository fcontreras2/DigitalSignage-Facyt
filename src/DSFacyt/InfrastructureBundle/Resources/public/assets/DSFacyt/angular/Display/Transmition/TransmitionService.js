Transmition.service('TransmitionService', function(){   

    this.changeMedia = function(timeout, showImages, showVideos, videos, images) {

        if (!videos.lenght) {
            showImages = true;
            showVideos = false;
        } else {
            timeout(
            function() {
                showImages = !showImages; 
                showVideos = !showVideos;
            }, 
            1000);                      
        }        
    };

    this.initialVideos = function(arrayVideos, $sce) {


        var response = [];
    
        $.each(arrayVideos, function(key, value) {
            response.push(
                [{src: $sce.trustAsResourceUrl('/uploads/videos/'+value.video_url), type: "video/mp4"}]
            );
        });        

        return response;
    };
    
});