Transmition.service('TransmitionService', function(){   

    this.changeMedia = function(timeout, showImages, showVideos) {

        timeout(
            function() {
                showImages = false; 
                showVideos = true;
            }, 
            1000);                  
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