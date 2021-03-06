<?php
move_me_around_scripts();

function move_me_around_scripts() {
     wp_enqueue_script('dashboard');
}

?>
<div class="wrap">
<h1>Google Authorship And Analytics Settings</h1>
<?php 

function zeo_ischecked($chkname,$value)
    {
                  
                if(get_option($chkname) == $value)
                {
                    return true;
                } 
        	return false;
	}



?>
<?php if ( $_POST['update_authorshipoptions'] == 'true' ) {  
	
	/*NONCE Verification*/
	
	if ( ! isset( $_POST['seo_authorship_nonce_field'] ) 
	    || ! wp_verify_nonce( $_POST['seo_authorship_nonce_field'], 'seo_authorship' ) 
	) {
	   print 'Sorry, your nonce did not verify.';
	   exit;
	} else {
		authorshipoptions_update(); 
	}

}  

function authorshipoptions_update(){
	
	// Only allowed user can edit

	global $current_user;

	if ( !current_user_can( 'edit_user', $current_user->ID ) )
		return false;

	// Validate POST Values

	if(!$_POST['zeoauthor'] ) {$_POST['zeoauthor'] = '';}
	if(!$_POST['zeopreferredname'] ) {$_POST['zeopreferredname'] = '';}

	// Sanitise POST values

	update_usermeta( $current_user->ID, 'zeoauthor', sanitize_text_field($_POST['zeoauthor'] ));
	update_usermeta( $current_user->ID, 'zeopreferredname', sanitize_text_field($_POST['zeopreferredname'] ));
	
	echo '<div class="updated">
		<p>
			<strong>Options saved</strong>
		</p>
	</div>'; 
	
}
?>
  <?php if ( $_POST['update_analyticsoptions'] == 'true' ) {   
	
	/*NONCE Verification*/
	
	if ( ! isset( $_POST['seo_analytics_nonce_field'] ) 
	    || ! wp_verify_nonce( $_POST['seo_analytics_nonce_field'], 'seo_analytics' ) 
	) {
	   print 'Sorry, your nonce did not verify.';
	   exit;
	} else {
		analyticsoptions_update(); 
	}
}  

function analyticsoptions_update(){
	
	// Only allowed user can edit

	global $current_user;

	if ( !current_user_can( 'edit_user', $current_user->ID ) )
		return false;

	$mervin_breadcrumbs = array();
	
	// Validating and Santising POST Values

	if(isset($_POST['verification-google'])){
		$mervin_verification['verification-google']=stripslashes(sanitize_text_field($_POST['verification-google']));
	}
	if(isset($_POST['verification-bing'])){
		$mervin_verification['verification-bing']=stripslashes(sanitize_text_field($_POST['verification-bing']));
	}
	if(isset($_POST['verification-alexa'])){
		$mervin_verification['verification-alexa']=stripslashes(sanitize_text_field($_POST['verification-alexa']));
	}
	
	if(!$_POST['zeo_analytics_id'] ) {$_POST['zeo_analytics_id'] = '';}
	
	update_option('mervin_verification', $mervin_verification);
	
	update_option('zeo_analytics_id', sanitize_text_field($_POST['zeo_analytics_id'])); 
	
	echo '<div class="updated">
		<p>
			<strong>Options saved</strong>
		</p>
	</div>'; 
	
}
?> 
<?php
$options = get_mervin_options();
?>
<div class="postbox-container" style="width:70%;">
				<div class="metabox-holder">	
					<div class="meta-box-sortables ui-sortable">                   



<form method="POST" action="">  
        <input type="hidden" name="update_authorshipoptions" value="true" />
        <div class="postbox" id="support">
        <h3>Google Authorship Settings</h3>
<table cellpadding="6">
        
		

<?php
global $current_user;
	get_currentuserinfo();
    ?>
    


		<tr>
			<th align="left" style="font-weight:normal"><label for="mpgpauthor">Google Plus Profile URL (Required)</label></th>

			<td>
				<input size="54" type="text" name="zeoauthor" id="mpgpauthor" value="<?php echo esc_attr( get_the_author_meta( 'zeoauthor', $current_user->ID ) ); ?>" class="regular-text" />
                <!--<br />
				<span class="description">Please enter your Google Plus Profile URL. (with "https://plus.google.com/1234567890987654321")</span>
                -->
			</td>
		</tr>
		<tr>

			<th align="left" style="font-weight:normal"><label for="preferredname">Preferred Name</label></th>
			<td>
				<input size="54" type="text" name="zeopreferredname" id="preferredname" value="<?php echo esc_attr( get_the_author_meta( 'zeopreferredname', $current_user->ID ) ); ?>" class="regular-text" />
                <!--
                <br />
				<span class="description">Enter Your Preferred Name</span>
                -->
			</td>
		</tr>

	</table>
    </div>
     <p><input type="submit" name="search" value="Update Options" class="button" /></p>  
<?php wp_nonce_field( 'seo_authorship', 'seo_authorship_nonce_field' ); ?>
</form>
<br />

        <form method="POST" action="">  
        <input type="hidden" name="update_analyticsoptions" value="true" />
        <div class="postbox" id="support2">
        <h3 class="hndle">Google Analytics Settings</h3>
        <table cellpadding="6">
        
        <tr>
        <td>Please Enter your Analytics Tracking ID</td>
        <td><input size="51" type="text" value="<?php echo esc_attr(get_option('zeo_analytics_id')); ?>" name="zeo_analytics_id"  /></td>
        </tr>
        
        
        </table>
        </div>
            
        <div class="postbox" id="support">
        
         <h3 class="hndle"><span>Webmaster Tools Verifications</span></h3>
        <div class="container">
<table cellpadding="6">
		<tr>
			<th align="right" width="210px" style="font-weight:normal"><label for="mervingoogle">Google Webmaster Tools</label></th>

			<td>
				<input size="54" type="text" name="verification-google" id="mervingoogle" class="regular-text" <?php if(isset($options['verification-google'])){ ?>
                value="<?php echo esc_html($options['verification-google'])?>"
				<?php 	}?> />                
			</td>
		</tr>
		<tr>
			<th align="right" style="font-weight:normal"><label for="mervinbing">Bing Webmaster Tools</label></th>

			<td>
				<input size="54" type="text" name="verification-bing" id="mervinbing" class="regular-text" <?php if(isset($options['verification-bing'])){ ?>
                value="<?php echo esc_html($options['verification-bing'])?>"
				<?php 	}?> />                
			</td>
		</tr>
		<tr>
			<th align="right" style="font-weight:normal"><label for="mervinalexa">Alexa Verification ID</label></th>

			<td>
				<input size="54" type="text" name="verification-alexa" id="mervinalexa" class="regular-text" <?php if(isset($options['verification-alexa'])){ ?>
                value="<?php echo esc_html($options['verification-alexa'])?>"
				<?php 	}?> />                
			</td>
		</tr>

	</table>
    </div>  </div>
    
    
    <p><input type="submit" name="search" value="Update Options" class="button" /></p>  
        <?php wp_nonce_field( 'seo_analytics', 'seo_analytics_nonce_field' ); ?>
        </form> 


		</div>  



</div>

</div>