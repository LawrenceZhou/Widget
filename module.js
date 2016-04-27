/**
 * @namespace
 */
M.mod_widget = M.widget || {};

/**
 * This function is initialized from PHP
 *
 * @param {Object} Y YUI instance
 */
M.mod_widget.init = function(Y) {
    alert('Hello world');
}

M.mod_widget.create_camera = function() {


navigator.getUserMedia = navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia;

 var video = document.getElementById("video1"),
                videoObj = { "video": true },
                errBack = function(error) {
                    console.log("Video capture error: ", error.code);
                };

            // Put video listeners into place
            if(navigator.getUserMedia) { // Standard
                navigator.getUserMedia(videoObj, function(stream) {
                    video.src = stream;
                    video.play();
                }, errBack);
            } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
                navigator.webkitGetUserMedia(videoObj, function(stream){
                    video.src = window.webkitURL.createObjectURL(stream);
                    video.play();
                }, errBack);
            }

            // Trigger photo take
            document.getElementById("snap").addEventListener("click", function() {
                context.drawImage(video, 0, 0, 487, 365);
            });
}