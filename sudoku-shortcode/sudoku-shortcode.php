<?php
/*
Plugin Name: Sudoku Shortcode
Plugin URI: http://www.le-sudoku.fr/site-perso/wordpress
Description: Include a Sudoku puzzle in your blogs with just one shortcode. 
Version: 1.0.0
Author: tibouille
Author URI: http://www.le-sudoku.fr/
*/

/**
 * Default Options
 */
function get_shc_options ($default = false){
	$shc_default = array(
							'size' => '9',
							'level' => '1',
							'width' => '450',
							'background' => 'FFFFFF',
							'language' => 'en',
							);
	if ($default) {
		update_option('shc_op', $shc_default);
		return $shc_default;
	}
	
	$options = get_option('shc_op');
	if (isset($options))
		return $options;
	update_option('shc_op', $shc_default);
	return $options;
}

/**
 * The Sortcode
 */
 
add_shortcode('sudoku-sc', 'shc_sc');

function shc_sc($atts) {
	global $post;
	$options = get_shc_options();	
	
	$size = $options['size'];
	$level = $options['level'];
	$width = $options['width'];
	$background = $options['background'];
	$language = $options['language'];

	extract(shortcode_atts(array(
    'size' => $size,
    'level' => $level,
		'width' => $width,
    'background' => $background,
		'language' => $language,
	), $atts));

	if($language == 'en')
		return '<script type="text/javascript">
var live_sudoku_size = '.$size.';
var live_sudoku_level = '.$level.';
var live_sudoku_width = '.$width.';
var live_sudoku_background = "'.$background.'";
</script>
<script type="text/javascript" src="http://www.live-sudoku.com/perso/sudoku.js">
</script>
<noscript>You must accept javascript to play <a href="http://www.live-sudoku.com" target="_blank">sudoku</a>.</noscript>';
	else
		return '<script type="text/javascript">
var le_sudoku_size = '.$size.';
var le_sudoku_level = '.$level.';
var le_sudoku_width = '.$width.';
var le_sudoku_background = "'.$background.'";
</script>
<script type="text/javascript" src="http://www.le-sudoku.fr/perso/sudoku.js">
</script>
<noscript>Vous devez activer javascript pour pouvoir jouer au <a href="http://www.le-sudoku.fr" target="_blank">sudoku</a>.</noscript>';
}

/**
 * Settings
 */  

add_action('admin_menu', 'shc_set');

function shc_set() {
	$plugin_page = add_options_page('Sudoku Shortcode', 'Sudoku Shortcode', 'administrator', 'sudoku-shortcode', 'shc_options_page');		
 }

function shc_options_page() {

	$options = get_shc_options();
	
    if(isset($_POST['Restore_Default']))	$options = get_shc_options(true);	?>

	<div class="wrap">   
	
	<h2><?php _e("Sudoku Shortcode Settings") ?></h2>
	
	<?php 

	if(isset($_POST['Submit'])){
	
     		$newoptions['size'] = isset($_POST['size'])?$_POST['size']:$options['size'];
     		$newoptions['level'] = isset($_POST['level'])?$_POST['level']:$options['level'];
     		$newoptions['width'] = isset($_POST['width'])?$_POST['width']:$options['width'];
     		$newoptions['background'] = isset($_POST['background'])?$_POST['background']:$options['background'];
			$newoptions['language'] = isset($_POST['language'])?$_POST['language']:$options['language'];
	
			if ( $options != $newoptions ) {
				$options = $newoptions;
				update_option('shc_op', $options);			
			}
	    
 	} 

	if(isset($_POST['Use_Default'])){
        update_option('shc_op', $options);
    }

	$size = $options['size'];
	$level = $options['level'];
	$width = $options['width'];
	$background = $options['background'];
	$language = $options['language'];
	
	?>
	
	<form method="POST" name="options" target="_self" enctype="multipart/form-data">
	
	<h3><?php _e("Sudoku Parameters") ?></h3>
	
	<p><?php _e("The shortcode attributes overwrite these options.") ?></p>
	
    <table width="80%%" border="0" cellspacing="10" cellpadding="0">
      <tr>
        <td colspan="2"><strong><?php _e("Dimensions") ?></strong></td>
      </tr>  
      <tr>
        <td width="60" align="right" height="40"><?php _e("Size") ?></td>
        <td>
        <select name="size" id="size">
        	<option value="6"<?php echo ($size == 6 ? " selected" : "") ?>><?php echo _e("6x6") ?></option>
        	<option value="9"<?php echo ($size == 9 ? " selected" : "") ?>><?php echo _e("9x9") ?></option>
        	<option value="10"<?php echo ($size == 10 ? " selected" : "") ?>><?php echo _e("10x10") ?></option>
        	<option value="12"<?php echo ($size == 12 ? " selected" : "") ?>><?php echo _e("12x12") ?></option>
        	<option value="16"<?php echo ($size == 16 ? " selected" : "") ?>><?php echo _e("16x16") ?></option>
        </select>
        </td>
      </tr>
      <tr>
        <td width="60" align="right" height="40"><?php _e("Difficulty") ?></td>
        <td>
        <select name="level" id="level">
        	<option value="0"<?php echo ($level == 0 ? " selected" : "") ?>><?php echo _e("Easy") ?></option>
        	<option value="1"<?php echo ($level == 1 ? " selected" : "") ?>><?php echo _e("Medium") ?></option>
        	<option value="2"<?php echo ($level == 2 ? " selected" : "") ?>><?php echo _e("Hard") ?></option>
        	<option value="3"<?php echo ($level == 3 ? " selected" : "") ?>><?php echo _e("Expert") ?></option>
        </select>
        </td>
      </tr>
      <tr>
        <td width="60" align="right" height="40"><?php _e("Width") ?></td>
        <td><input name="width" type="text" size="6" value="<?php echo $width ?>" /> px</td>
      </tr>
      <tr>
        <td width="60" align="right" height="40"><?php _e("Background") ?></td>
        <td>#<input name="background" type="text" size="6" value="<?php echo $background ?>" /></td>
      </tr>
      <tr>
        <td colspan="2"><strong><?php _e("Language") ?></strong></td>
      </tr>   
      <tr>
        <td align="right" valign="top"><?php _e("Select") ?>
        </td>
        <td>  
        <?php 
        $lang_array = array(
                            "en" => __("English"),
                            "fr" => __("French"),
                                                
        );
        ?> 
        <select name="language" id="language">
            <?php foreach($lang_array  as $lg => $lg_name){ ?>
                <option value="<?php echo $lg ?>" <?php echo ($lg == $language ? "selected" : "") ?> ><?php echo $lg_name ?></option>
            <?php } ?>
        </select>   
        </td>
      </tr>   
    </table>
    
    <p class="submit">
    <input type="submit" name="Submit" value="Update" class="button-primary" />
    </p>
    </form>
    </div>


<?php } 

