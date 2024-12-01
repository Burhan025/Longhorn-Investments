jQuery( document ).ready(function() {

  // Fancybox for youtube
  jQuery(".fancybox-youtube").fancybox({
    maxWidth    : 800,
    maxHeight   : 600,
    fitToView   : true,
    width       : '70%',
    height      : '70%',
    autoSize    : true,
    closeClick  : true,
    openEffect  : 'none',
    closeEffect : 'none',
    padding     : 5,
    helpers     : {
        overlay : {
            css : {
                'background' : 'rgba(0, 0, 0, 0.35)'
            }
        }
    }
  });

  // Default Fancybox
  jQuery(".fancybox").fancybox({
    maxWidth    : 800,
    maxHeight   : 600,
    fitToView   : true,
    width       : '70%',
    height      : '70%',
    autoSize    : true,
    closeClick  : true,
    openEffect  : 'none',
    closeEffect : 'none',
    padding     : 5,
    helpers     : {
        overlay : {
            css : {
                'background' : 'rgba(0, 0, 0, 0.35)'
            }
        }
    }
  });

});


// Shrink Header
jQuery(window).scroll(function () {
  if (jQuery(document).scrollTop() > 1 ) {
    jQuery('.site-header').addClass('shrink');
  } else {
    jQuery('.site-header').removeClass('shrink');
}
    

// Shows all <scripts> in the console for WP Rocket Debugging
/*
jQuery("script[src]").each(function( i, src ) {
   console.log( src );
});
*/ 


});

   
// Counter

	var flag = true;
	
  jQuery(document).ready(function(jQuery){	
    
    jQuery('#animation').onScreen({
      tolerance: 200,
      toggleClass: false,
      doIn: function() {
        jQuery(this).addClass('onScreen');
		
		if(flag){ //if this is true it will run the animaton
		jQuery('#animation .count span').counterUp({
			delay: 6, // the delay time in ms
			time: 1000 // the speed time in ms
		});
			flag=false; //we make it false here so it doesn't run the animation twice. 
			
		}
		
      }
	  
    });
    
    jQuery('i.scrollHint').click(function(e){
      e.preventDefault();
      jQuery('html,body').animate({
        scrollTop: jQuery('#animation').offset().top
      },1200);
    });
    
    //vAlignDesc();
    
  });
  
  //$(window).resize(function(){
   // vAlignDesc()
  //});
  jQuery(document).ready(function(jQuery){	
	jQuery(window).scroll(function(){
	  var pos = jQuery(window).scrollTop();
	  jQuery('section.desc i.scrollHint').css('opacity',1 - (pos/200))
	});
  });
  
  jQuery(document).ready(function(jQuery){	
	  if ( jQuery( "#term-project .projects" ).length ) {
			  jQuery(".random-projects").css("display", "none");
	  }
  });