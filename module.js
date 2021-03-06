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

M.mod_widget.create_camera = function(camera_num) {

navigator.getUserMedia = navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia;

if (navigator.getUserMedia) {
   navigator.getUserMedia({ audio: false, video: { width: 900, height: 900 } },
      function(stream) {
      	var videoId = camera_num;
         var video = document.getElementById(videoId);
         video.src = window.URL.createObjectURL(stream);
         video.onloadedmetadata = function(e) {
           video.play();
         };
      },
      function(err) {
         console.log("The following error occurred: " + err.name);
      }
   );
} else {
   console.log("getUserMedia not supported");
};
}