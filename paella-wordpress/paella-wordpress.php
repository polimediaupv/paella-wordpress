<?php
/*
* Plugin Name: Paella wordpress
* Description: Add a wordpress shortcode to display paella player
* Version: 0.1
* Author: leosamu
* Author URI: http://upv.com
*/

/*
*OPTION
*/
add_option('server', 'http://paellaplayer.upv.es/demo/player/index.html?id=');
add_option('defaultVideo', 'belmar-multiresolution');
add_option('defaultWidth', '900');
add_option('defaultHeight', '500');

/*
*BACKEND CONFIGURATION
*/
add_action('admin_menu', 'paellawordpress_create_menu');

function paellawordpress_create_menu() {

	//create new top-level menu
	add_menu_page('Pella Settings', 'Paella Settings', 'administrator', __FILE__, 'paellawordpress_settings_page', plugins_url('/images/icon.png', __FILE__));

	//call register settings function
	add_action( 'admin_init', 'paellawordpress_settings' );
}

function paellawordpress_settings() {
	//register our settings
	register_setting( 'paellawordpress-settings-group', 'server' );
	register_setting( 'paellawordpress-settings-group', 'defaultVideo' );
	register_setting( 'paellawordpress-settings-group', 'defaultWidth' );
	register_setting( 'paellawordpress-settings-group', 'defaultHeight' );
}

function paellawordpress_settings_page() {
?>
<link rel="stylesheet" id="sublimevideo.css-css" href="<?php echo plugins_url('/assets/css/settings.css', __FILE__) ?>" type="text/css" media="all">
<div class="wrap">
<h2>Paella Plugin Configuration</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'paellawordpress-settings-group' ); ?>
    <?php do_settings_sections( 'paellawordpress-settings-group' ); ?>
    <div id="pp_settings">
        <fieldset>
        <h1>Info</h1>
            <p>The way the plugin works, it needs the paella base url to be equal to the url of a paella video in your server minus the id of the video, you can see an example below. <br>
            <img src="<?php echo plugins_url('/images/baseurl.png', __FILE__) ?>"/><br>
            the selected text corresponds to the paella base url.</p>
        </fieldset>

        <fieldset>
            <legend></legend>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Paella Base URL</th>
                    <td><input type="text" size="100" name="server" value="<?php echo esc_attr( get_option('server') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Default Video ID</th>
                    <td><input type="text" size="100" name="defaultVideo" value="<?php echo esc_attr( get_option('defaultVideo') ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Default Width</th>
                    <td><input type="text" size="100" name="defaultWidth" value="<?php echo esc_attr( get_option('defaultWidth') ); ?>" /></td>
                </tr>
            <tr valign="top">
                    <th scope="row">Default Height</th>
                    <td><input type="text" size="100" name="defaultHeight" value="<?php echo esc_attr( get_option('defaultHeight') ); ?>" /></td>
                </tr>
            </table>
        </fieldset>



    </div>
    <?php submit_button(); ?>

</form>
</div>
<?php }


/*
*FRONT END CONFIGURATION
*/ 
function paella_shortcode($atts){

extract( shortcode_atts(
		array(
			'id' => get_option('defaultID') ,
			'width' => get_option('defaultWidth'),
			'height' => get_option('defaultHeight'),
		), $atts )
	);
$paella_iframe = '<iframe
		src="' . get_option('server') . $id . '"
		width="' . $width . '"
		height="' . $height . '"
		frameborder="0"
		allowfullscreen="true"></iframe>';

return $paella_iframe;
}
add_shortcode('paella', 'paella_shortcode');
?>