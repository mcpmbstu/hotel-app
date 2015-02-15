jQuery(document).ready(function(){
	/*jQuery('.pagination a').live('click', function(e){
	  e.preventDefault();
	  jQuery('#ajaxGrid').find('option:first').attr('selected', 'selected');
	  jQuery('.pagination').find('a').removeClass('current');
	  jQuery(this).addClass('current');
	  var link = jQuery(this).attr('href');
	  jQuery('#ajaxContent').html('<div id="loading"><i class="fa fa-cog fa-spin fa-4x"></i></div>');
	  jQuery('#ajaxContent').load(link+' #ajaxContent');
		
		

	});*/
	
 jQuery(window).load(function(){ 
			jQuery('ul.gridView').AwesomeGrid({
				rowSpacing  : 20,
				colSpacing  : 20,
				initSpacing : 0, 
				responsive  : true,              // itching for responsiveness?
				fadeIn      : true,              // allow fadeIn effect for an element?
				hiddenClass : false,             // ignore an element having this class or false for none
				item        : 'li',              // item selector to stack on the grid
				onReady     : function(item){ },
				columns     : {
					'defaults' : 4,
					'1100' : 3,
					'860' : 2,
					'580' : 1
				},
				context     : 'window'           // resizing context, 'window' by default.
			});
		});

});


		



