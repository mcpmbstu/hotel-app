jQuery(document).ready( function() {
    //jQuery('.postbox .handlediv').prepend('<a class="togbox">+</a> ');
    jQuery('.postbox .handlediv').click( function() {
        jQuery(jQuery(this).parent().get(0)).toggleClass('closed');
    });
	
 
	jQuery('#date_timepicker_start').datetimepicker({
		datepicker:false,
		format:'H:i',
		defaultTime:'00:00',
		step:60,
		onSelectTime:function(dp,$input){
			//alert($input.val())
			var s_temVal = $input.val(); 
			jQuery('#s_time').val(s_temVal);
			//ajaxTimeBox(temVal);
		  }
	}); 
	
	jQuery('#date_timepicker_end').datetimepicker({
		datepicker:false,
		format:'H:i',
		defaultTime:'23:00',
		step:60,
		onSelectTime:function(dp,$input){
			//alert($input.val())
			var e_temVal = $input.val(); 
			jQuery('#e_time').val(e_temVal);
			ajaxTimeBox(e_temVal);
		  }
	}); 
	
	/*jQuery('.closeBtm').click(function(){
		alert(jQuery(this).attr('rel'));	
	});*/
function ajaxTimeBox(currVal){ 
	// this is ajax script URL
	var scriptUrl = jQuery("#scriptUrl").val();
	var tmp1 = jQuery('#s_time').val();
	var tmp2 = jQuery('#e_time').val(); 
	//alert(tmp1+tmp2);
	jQuery.ajax({
			type: "POST",
			url: scriptUrl,
			data: {stime: tmp1, etime: tmp2},
			dataType:"html",
			success: function(data){
				//alert(data); 
				
				jQuery("#ajaxTime").hide(); //just in case
				jQuery("#ajaxTime").html(data);
				jQuery("#ajaxTime").fadeIn('slow');
		
					//jQuery(this).remove();
			}
		});
		return false;			
} 	
	
});

jQuery(function(){
	jQuery('#hero-demo').autoComplete({
		minChars: 1,
		source: function(term, suggest){
			term = term.toLowerCase();
			var choices = ['Friday', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
			var suggestions = [];
			for (i=0;i<choices.length;i++)
				if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
			suggest(suggestions);
		}
	});
});