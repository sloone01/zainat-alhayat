/*
-------------------------------
    : Custom - Tour js :
-------------------------------
*/
"use strict";
$(document).ready(function() {
  	var tours = new ProductTour({
        overlay: !0,
        onStart: function() {

        },
        onChanged: function(tours) {

        },
        onClosed: function(tours) {

        }
    });
    tours.steps([{
        element: "#tour-form",
        title: "Registration Form",
        content: "Easily Customisable User Registration Forms with which you can create flawless user system.",
        image: "./assets/images/call-center.png",
        position: "bottom"
    }, {
        element: "#tour-card",
        title: "Image Card with Content",
        content: "This type of cards have multipurpose usage like Blog, Product Listing, Testimonials etc.",
        image: "./assets/images/call-center.png",
        position: "top"
    }, {
        element: "#tour-upload",
        title: "File Upload",
        content: "Easy to use Drag and Drop function which makes file uploading very easy.",
        image: "./assets/images/call-center.png",
        position: "top"
    }]), tours.startTour()
});
