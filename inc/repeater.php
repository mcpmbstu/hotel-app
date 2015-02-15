<style type="text/css">
#meta_inner{ position: relative; }
p.m-group-wrapper-odd, p.m-group-wrapper-even{ display: block; padding: 10px;	border: 1px solid #d9d9d9;	margin-bottom: -1px;	background: #e9e9eb;	margin-top: 0;	position: relative; }
p.m-group-wrapper-even{ background: none;	}
.add{ position: absolute; right: 0; top: -46px; border-radius: 50px; background: #CCC; padding: 5px 15px; }
.add:hover{	cursor: pointer; }
.remove_m{ position: absolute; right: 13px; top: 5px; }
.remove_m:hover{ cursor: pointer; }
.fa-red{ color: #F00; }
.m-hide{ display: none; }
.m-hide:before{ content: 'Remove'; }
.m-show{ display: block; }

.testDiv{
	display: none;
	position: absolute;
	left: 13px;
	top: 61px;
	z-index: 999;
	background: #fff; 
	width: 70%;	
	padding: 15px;
}
#addData{
	display: none;	
}
.container_16 a{ 
	display: block; 
}


/***** MODAL SOCIAL =========================== ***/
/* 

====== Zoom effect ======

*/
.white-popup {
  position: relative;
  background: #FFF url(<?php echo ROOTDIR_PLUGIN; ?>/assets/images/line.png) left 45px repeat-x;
  padding: 25px;
  width: auto;
  max-width: 600px;
  margin: 0 auto;
}
.mfp-zoom-in {
  /* start state */
  /* animate in */
  /* animate out */
}
.mfp-zoom-in .mfp-with-anim {
  opacity: 0;
  transition: all 0.1s ease-in-out;
  transform: scale(0.8);
}
.mfp-zoom-in.mfp-bg {
  opacity: 0;
  transition: all 0.2s ease-out;
}
.mfp-zoom-in.mfp-ready .mfp-with-anim {
  opacity: 1;
  transform: scale(1);
}
.mfp-zoom-in.mfp-ready.mfp-bg {
  opacity: 0.8;
}
.mfp-zoom-in.mfp-removing .mfp-with-anim {
  transform: scale(0.8);
  opacity: 0;
}
.mfp-zoom-in.mfp-removing.mfp-bg {
  opacity: 0;
}

h2.modal-title{
	margin:-10px 0 35px 0;
	padding: 0;	
}

</style>
<?php
$socialArray = array(
		'Facebook'	=>'facebook',
		'Twitter'	=>'twitter',
		'LinkedIn'	=>'linkedin',
		'GooglePlus'=>'google-plus',
		'Pinterest'	=>'pinterest-p',
		'Instagram'	=>'instagram',
		'Skype'		=>'skype',
		'Tumblr'	=>'tumblr',
		'Youtube'	=>'youtube',
		'Flickr'	=>'flickr',
		'Yelp'		=>'yelp',
		'Reddit Square'	=>'reddit-square',
		'WeChat'	=>'wechat',
		'Yahoo'		=>'yahoo',
		'WhatsApp'	=>'whatsapp');
$socialSize = 'fa-2x fa-fw';
$sCount =0;
$sState=0;
$startDiv = '<div class="container_16 clearfix">';
$endDiv = '</div>';
$innerDivStart = '<div class="grid_1">';
$innerDivEnd = '</div>';
//var_dump($socialArray);
?>
<div id="addData">
<?php
echo $startDiv;
foreach($socialArray as $x => $x_value):
	echo $innerDivStart.'<a href="#" rel="'.$x_value.'" title="'.$x.'"><i class="fa fa-'.$x_value.' '.$socialSize.'"></i></a>'.$innerDivEnd;
endforeach;
echo $endDiv;
//get the saved meta as an arry
$social_links = get_post_meta($post->ID,'social_link',true);
$c = 0;
?>	
</div><!--addData-->
<div class="section group custom-group"> 
	<div class="col span_12_of_12">
	<h2 style="padding-left: 0; margin-top: 10px;"><i class="fa fa-users fa-lg fa-fw"></i> <?php _e('Social Profile','m-hotel'); ?></h2>
    <div id="meta_inner">
    <?php
	if(!empty($social_links)):
    if ( count( $social_links ) > 0 ) {
        foreach( $social_links as $social_link ) {
			
				if ( isset( $social_link['profile_name'] ) || isset( $social_link['profile_link'] ) ) {
					if(($c%2)!=0){
					printf( '<p class="m-group-wrapper-even prof_name" title="'.$c.'" ><i class="fa fa-user fa-fw"></i><strong>Profile Title: </strong><input type="text" data-effect="mfp-zoom-in" name="social_link[%1$s][profile_name]" id="c'.$c.'" value="%2$s" /><i class="fa fa-link fa-fw"></i><strong>Profile Link/Name:</strong><input type="url" name="social_link[%1$s][profile_link]" id="c'.$c.'" value="%3$s" /><input type="hidden" name="social_link[%1$s][profile_icon]" id="c'.$c.'" value="%4$s" /><span class="remove_m">%5$s</span>', $c, $social_link['profile_name'], $social_link['profile_link'],$social_link['profile_icon'], __( '<span class="m-hide"></span> <i class="fa fa-trash-o fa-lg fa-red"></i>' ) );
					printf('</p>');
					}else{
					printf( '<p class="m-group-wrapper-odd prof_name" title="'.$c.'"><i class="fa fa-user fa-fw"></i><strong>Profile Title: </strong><input type="text" name="social_link[%1$s][profile_name]" id="c'.$c.'" data-effect="mfp-zoom-in" value="%2$s" /><i class="fa fa-link fa-fw"></i><strong>Profile Link/Name:</strong><input type="url" name="social_link[%1$s][profile_link]" id="c'.$c.'" value="%3$s" /><input type="hidden" name="social_link[%1$s][profile_icon]" id="c'.$c.'" value="%4$s" /><span class="remove_m">%5$s</span>', $c, $social_link['profile_name'], $social_link['profile_link'],$social_link['profile_icon'], __( '<span class="m-hide"></span> <i class="fa fa-trash-o fa-lg fa-red"></i>' ) );	
					printf('</p>');
					}
					$c = $c +1;
					
				} 
        }
    }
	endif; 
    ?>
    <span id="here"></span>
    <span class="add button-primary"><?php _e('<i class="fa fa-plus fal-lg"></i> add more'); ?></span>
    
    <!-- Popup itself -->
    <div id="test-popup" class="white-popup mfp-with-anim mfp-hide">
    	<h2 class="modal-title"><?php _e('Select Profile','m-hotel'); ?></h2>
      <div id="inlineContent"></div><!--inlineContent-->
      <div style="clear:both; height:0; overflow:hidden;"></div>
      <!-- <p><a class="popup-modal-dismiss button-primary" href="#">Save Data</a></p> -->
    </div>

    <script type="text/javascript">
    var $ =jQuery.noConflict();
        $(document).ready(function() {
			$(document.body).on('mouseover', '.remove_m i.fa-trash-o', function() { 
				jQuery(this).parent().find('.m-hide').fadeIn( "fast" );	
			});
			
			$(document.body).on('mouseout', '.remove_m i.fa-trash-o', function() { 
				jQuery(this).parent().find('.m-hide').fadeOut( "fast" );
			});
			
            var count = <?php echo $c; ?>;
			count = $("#meta_inner p").length;
            $(".add").click(function() {
			count = count+1;
			//alert(count);
            if(count%2!=0){
            $('#here').append('<p class="m-group-wrapper-odd prof_name"><i class="fa fa-user fa-fw"></i><strong><?php _e('Profile Title','m-hotel'); ?>:</strong><input type="text" name="social_link['+count+'][profile_name]" id="c'+count+'" data-effect="mfp-zoom-in" value="" /><i class="fa fa-link fa-fw"></i><strong><?php _e('Profile Link/Name','m-hotel'); ?>:</strong> <input type="url" name="social_link['+count+'][profile_link]" value="" /><input type="hidden" name="social_link['+count+'][profile_icon]" value="" /><span class="remove_m"><span class="m-hide"></span> <i class="fa fa-trash-o fa-lg fa-red"></i></span></p>' );
			}else{
			$('#here').append('<p class="m-group-wrapper-even prof_name"><i class="fa fa-user fa-fw"></i><strong><?php _e('Profile Title','m-hotel'); ?>:</strong><input type="text" name="social_link['+count+'][profile_name]" id="c'+count+'" data-effect="mfp-zoom-in" value="" /><i class="fa fa-link fa-fw"></i><strong><?php _e('Profile Link/Name','m-hotel'); ?>:</strong> <input type="url" name="social_link['+count+'][profile_link]" value="" /><input type="hidden" name="social_link['+count+'][profile_icon]" value="" /><span class="remove_m"><span class="m-hide"></span> <i class="fa fa-trash-o fa-lg fa-red"></i></span></p>' );
			}
            return false;
            });
            $(".remove_m").live('click', function() {
            $(this).parent().remove();
				count = count -1;
            });

			// Inline popups 
			// From an element with ID #popup
			var currSel;
			var currSelAttr;
			$(document).on('click','.prof_name input[type="text"]', function () { 
			  currSel = jQuery(this).attr('id');
			  currSelIco = jQuery(this).parent().find('input[type="hidden"]').addClass('icon-add');
			  currSelAttr = jQuery(this).attr('data-effect');	
			  //alert(currSel);
			  $.magnificPopup.open({
			  items: {
				  src: '#test-popup',
				  type: 'inline',
			  },
			  	closeOnBgClick: false,
				callbacks: {
				beforeOpen: function() {
				  // just a hack that adds mfp-anim class to markup 
				   this.st.mainClass = currSelAttr;
				},
				open: function(){
					var htmlString = $( '#addData' ).html();
					$( '#inlineContent' ).html( htmlString );					
					jQuery('#test-popup a').on('click','',function(e){						
						var currValRel = jQuery(this).attr('rel');
						var currVal = jQuery(this).attr('title');
						jQuery('#'+currSel).val(currVal);
						jQuery('#'+currSel).parent().find('.icon-add').val(currValRel);
						e.preventDefault();	
					}); 	
				}
			  }
			});
		});
			
	});
    </script>





 


    </div><!--meta_inner-->

    </div>  <!--span_12_of_12-->     
</div><!--section-->
