// JavaScript Document
jQuery(document).ready(function() {
	jQuery('.zoom-gallery').magnificPopup({
	  delegate: 'a',
	  type: 'image',
	  closeOnContentClick: false,
	  closeBtnInside: false,
	  mainClass: 'mfp-with-zoom mfp-img-mobile',
	  image: {
		verticalFit: true,
		titleSrc: function(item) {
		  return item.el.attr('title');
		}
	  },
	  gallery: {
		enabled: true
	  },
	  zoom: {
		enabled: true,
		duration: 300, // don't foget to change the duration also in CSS
		opener: function(element) {
		  return element.find('img');
		}
	  }
	  
	});
	

/*	jQuery("body #mGrid").gridalicious({selector: '.item', gutter: 15, width: 280, animate: true, animationOptions: {
    	queue: true,
    	speed: 200,
    	duration: 300,
    	effect: 'fadeInOnAppear',
  	}});*/
});






