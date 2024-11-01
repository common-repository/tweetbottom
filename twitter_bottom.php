<?php
/*
Plugin Name: TweetBottom
Version: 0.1
Plugin URI: http://www.imod.co.za/wordpress-plugins/
Description: Add your Twitter link to the bottom of all your posts. Visit <a href="options-general.php?page=TweetBottom/twitter_bottom.php">Options/Post Bottom</a> to setup your plugin once activated.
Author: Christopher Mills
Author URI: http://www.imod.co.za
*/

function imod_TweetBottom($info) {
    $text = get_option('twitter_name');
    $col1 = get_option('col1');
    $col2 = get_option('col2');

	if ( is_single() && $text != "")
		$info .= "<div style='background-color: #".$col1."; border:1px solid #".$col2."; padding:5px;'><img src='". get_option('home')."/wp-content/plugins/TweetBottom/twitter.png' border='0'>&nbsp;Follow me on Twitter by <a href='http://www.twitter.com/".get_option(twitter_name)."' target='_blank'>clicking here</a>.</div><br />";
	return $info;
}


if (get_option("credit") == "yes")
	add_action('wp_footer', 'imodlink');	
	
function imodlink() {
	echo "<p align='center' style='filter:alpha(opacity=70); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5;'>TweetBottom by <a href='http://www.imod.co.za' style='filter:alpha(opacity=70); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5;'>iMod</a></p>";
}	

function imod_set_TweetBottom_options(){
    add_option('twitter_name','','ChristopherM');
    add_option('col1','FFFFE0','Yellow');
    add_option('col2','E6DB55','Gold');
	add_option("credit", "yes", "Credit Link to iMod");

}

function imod_unset_TweetBottom_options(){
    delete_option('twitter_name');
    delete_option('col1');
    delete_option('col2');
	delete_option('credit');
}

register_activation_hook(__FILE__,'imod_set_TweetBottom_options');
register_deactivation_hook(__FILE__,'imod_unset_TweetBottom_options');

function imod_admin_TweetBottom_options(){
    ?>
    <div class="wrap"><h2>TweetBottom Settings</h2>
    <?php
    if ($_REQUEST['submit'])
    {
        imod_update_TweetBottom_options();
    }
    imod_print_TweetBottom_form();
    ?>
    </div>
    <?php
}

function imod_update_TweetBottom_options(){
    $ok = false;
    if ($_REQUEST['twitter_name'])
    {
        update_option('twitter_name',stripslashes($_REQUEST['twitter_name']));
        $ok = true;
    }

    if ($_REQUEST['col1'])
    {
        update_option('col1',$_REQUEST['col1']);
        $ok = true;
    }

    if ($_REQUEST['col2'])
    {
        update_option('col2',$_REQUEST['col2']);
        $ok = true;
    }

    if ($_REQUEST['credit'] == "yes")
    {  		
		$credit = "yes";
	}
	else
	{
		$credit = "no";
	}
	update_option('credit', $credit);   
    $ok = true;
    


    if ($ok) {
        ?>
        <div id="message" class="updated fade">
        <p>Options Saved!</p>
        </div>
        <?php
    }
    else
    {
        ?>
        <div id="message" class="error fade">
        <p>Failed to save Options</p>
        </div>
        <?php
    }
}

function imod_print_TweetBottom_form(){

    ?>
    
    <form method="post">
    <table>
    <tr>
    	<td>What is your Twitter username:</td>
    </tr>
    <tr>
    	<td>@<input name="twitter_name" type="text" value="<?php echo get_option('twitter_name'); ?>" /></td>
    </tr>
    <tr>
    	<td>Background Colour:</td>
    </tr>
    <tr>
    	<td>#<input name="col1" type="text" value="<?php echo get_option('col1'); ?>" /></td>
    </tr>
    <tr>
    	<td>Border Colour:</td>
    </tr>
    <tr>
    	<td>#<input name="col2" type="text" value="<?php echo get_option('col2'); ?>" /></td>
    </tr>
    <tr>
    	<td>
		<?php
			if(get_option("credit") == "yes"){
			echo '<input type="checkbox" name="credit" checked="yes" value="yes" />Include Credit Link to iMod in Footer';
			} else {
			echo '<input type="checkbox" name="credit" value="yes" />Include Credit Link to iMod in Footer';
			}
		?>
        </td>
    </tr>
    <tr>
    	<td><input name="submit" type="submit" value="Submit" /></td>
    </tr>
    </table>
    </form>

    <?php
}

function imod_modify_menu(){
    add_options_page(
                     'TweetBottom',
                     'TweetBottom',
                     'manage_options',
                     __FILE__,
                     'imod_admin_TweetBottom_options'
                     );
}

add_action('admin_menu','imod_modify_menu');
add_filter('the_content', 'imod_TweetBottom', 999);
?>
