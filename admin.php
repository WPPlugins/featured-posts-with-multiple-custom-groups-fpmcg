<?php
add_action( 'admin_menu', 'post_config_page' );

function post_config_page() {
	if ( function_exists('add_menu_page') ) {
    	add_menu_page( __('FPMCG'), __('FPMCG'), 'manage_options', 'wafysol-fpmcg-config', 'post_conf' , 'dashicons-admin-tools' , 79);
		add_submenu_page( 'wafysol-fpmcg-config', __('Config'), __('Config'), 'manage_options', 'wafysol-fpmcg-config', 'post_conf' );
		add_submenu_page( 'wafysol-fpmcg-config', __('Upgrade'), __('Upgrade'), 'manage_options', 'wafysol-fpmcg-upgrade', 'upgrade_func' );
		add_submenu_page( 'wafysol-fpmcg-config', __('Help'), __('Help'), 'manage_options', 'wafysol-fpmcg-help', 'help_func' );
	}
}

function post_plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/postconfig.php' ) ) {
		$links[] = '<a href="plugins.php?page=post-type-config">'.__('Settings').'</a>';
	}
	return $links;
}

add_filter( 'plugin_action_links', 'post_plugin_action_links', 10, 2 );

function upgrade_func() {
	echo '<div class="wrap">
		  	<h1>Upgrade</h1>';
	global $wpdb;
	$posts_table = $wpdb->prefix . "posts";
	$postmeta_table = $wpdb->prefix . "postmeta";
	if(isset($_POST['submit']) && $_POST['submit'] == 'Upgrade'){
		$updateData = array("post_type" => 'wafysol_fpmcg' );
		$whereData = array("post_type" => 'custom_post');
		$wpdb->update( $posts_table, $updateData, $whereData );
		
		$updateData = array("meta_key" => 'wafysol_fpmcg_pctfp' );
		$whereData = array("meta_key" => 'post_cat_type-for-page');
		$wpdb->update( $postmeta_table, $updateData, $whereData );
		echo '<p style="padding: .5em; background-color: #4AB915; color: #fff; font-weight: bold;">Upgrade Successfull!</p>';
	}
	$up = 0;
	$posts_query = "Select * From $posts_table Where post_type = 'custom_post' ";
	$pq = $wpdb->get_results($posts_query);
	if($wpdb->num_rows > 0){
		$up = 1;
	} else {
		$up = 0;
	}
	$postmeta_query = "Select * From $postmeta_table Where meta_key = 'post_cat_type-for-page' ";
	$pmq = $wpdb->get_results($postmeta_query);
	if($wpdb->num_rows > 0){
		$up = 1;
	}
	if($up == 0){
		echo '<p>No upgrades required.</p>';
	} else {
		echo '<p>If you have updated the plugin from version 1.x, please check if all data from previous version are showing correctly. If not please press upgrade button below.</p>
		      <p>If all data from previous version (1.x) are showing correctly <strong>please do not press upgrade button</strong>.</p>';
		echo '';
		echo '<p><form method="post" action="'.admin_url().'admin.php?page=wafysol-fpmcg-upgrade">';
		     submit_button('Upgrade'); 	
		echo '</p>';
	}
	echo '</div>';
}

function help_func() {
	echo '<div class="wrap">
		  	<h1>Help</h1>
			<div class="card help">
				<h2>Help</h2>
				<p>Under plugin menu, go to "FPMCG Config". </p>
				<p>You need to add the featured posts group names here first.</p>
				<p>After adding the names when you create a post, under the post content area you will see a section "Featured Posts Groups". Select the featured groups under which you want to include the particular post.</p>
				<p>For displaying the featured posts groups in front end visit the Widget section under Appearance menu.</p>
				<p>Drag the "Featured Posts Groups (FPMCG)" widget to the desired sidebar. The widget have loads of configurable sections. They are explained below.</p>
				
				<table border="1" cellpadding="10" cellspacing="0">
				<tr>
					<th>Configuration</th>
					<th>Explanation</th>
				</tr>
				<tr>
					<td>Widget Title</td>
					<td>
						The title / heading of the Featured Posts block.
					</td>
				</tr>
				<tr>
					<td>Featured posts groups to display</td>
					<td>
						Posts that are listed under the selected groups will be displayed.
					</td>
				</tr>
				<tr>
					<td>Number of posts to display</td>
					<td>
						Number of posts to display under the block.
					</td>
				</tr>
				<tr>
					<td>Display Post Title</td>
					<td>
						Display or hide the Post Title with this configuration.
					</td>
				</tr>
				<tr>
					<td>Display Post Image</td>
					<td>
						Display or hide the Post Image (Featured Image) with this configuration.
					</td>
				</tr>
				<tr>
					<td>Display Description</td>
					<td>
						Display or hide the Post Description with this configuration.
					</td>
				</tr>
				<tr>
					<td>Display Date</td>
					<td>
						Display or hide the Post Date with this configuration.
					</td>
				</tr>
				<tr>
					<td>Display Author</td>
					<td>
						Display or hide the Post Author with this configuration.
					</td>
				</tr>
				<tr>
					<td>Before Widget Block</td>
					<td>
						Add HTML tags to show before the widget block.
					</td>
				</tr>
				<tr>
					<td>After Widget Block</td>
					<td>
						Add HTML tags to show after the widget block.
					</td>
				</tr>
				<tr>
					<td>Before Widget Title</td>
					<td>
						Add HTML tags to show before the widget title.
					</td>
				</tr>
				<tr>
					<td>After Widget Title</td>
					<td>
						Add HTML tags to show after the widget title.
					</td>
				</tr>
				<tr>
					<td>Before Post Body</td>
					<td>
						Add HTML tags to show before each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>After Post Body</td>
					<td>
						Add HTML tags to show after each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>Before Image</td>
					<td>
						Add HTML tags to show before the image of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>After Image</td>
					<td>
						Add HTML tags to show after the image of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>Before Post Data</td>
					<td>
						Add HTML tags to show before the contents of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>After Post Data</td>
					<td>
						Add HTML tags to show after the contents of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>Before Date</td>
					<td>
						Add HTML tags to show before the date of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>After Date</td>
					<td>
						Add HTML tags to show after the date of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>Before Description</td>
					<td>
						Add HTML tags to show before the description of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>After Description</td>
					<td>
						Add HTML tags to show after the description of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>Before Author Name</td>
					<td>
						Add HTML tags to show before the author name of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>After Author Name</td>
					<td>
						Add HTML tags to show after the author name of each post section within the widget block.
					</td>
				</tr>
				<tr>
					<td>CSS for widget</td>
					<td>
						Add custom CSS for the particular widget. Try to give unique class names / ids so that they do\'nt clash with the rest of the CSS entries.
					</td>
				</tr>
			</table>			
			</div>
		  </div>';
}

function post_conf() {   
    global $wpdb, $user_ID;
    $table_name = $wpdb->prefix . "posts";
    if (!isset($_POST['submit']) && $_GET['action'] == 'delete' && isset($_GET['ID'])) {
        wp_delete_post( $_GET['ID'] );
        $msg = '<p style="padding: .5em; background-color: #4AB915; color: #fff; font-weight: bold;">Post deleted successfully!</p>';
        unset($_POST);
        unset($_GET);
    }
    if ( isset($_POST['submit']) ) {
        if (!isset($_POST['post_type'])) {
            $_POST['post_type'] = 'wafysol_fpmcg';
        }
        if (empty($_POST['post_title']) || ($_POST['post_title'] == '')) {
            $msg = '<p style="padding: .5em; background-color: #888; color: #fff; font-weight: bold;">Post type cannot be left blank</p>';
        } else {
            $chksql = "SELECT COUNT(*) FROM " . $table_name . "
                       WHERE post_title = '%s' 
                       AND post_type = 'wafysol_fpmcg'";
            if (isset($_GET['ID']) && $_GET['ID'] != '') {
                $chksql .= " AND ID != '%d'";
				$checkposttype = $wpdb->get_var( $wpdb->prepare( $chksql , $_POST['post_title'] , $_GET['ID'] ));
            } else {
            	$checkposttype = $wpdb->get_var( $wpdb->prepare( $chksql , $_POST['post_title']  ));
			}
             if ($checkposttype == 0){
                if (!isset($_POST['post_ID']) || $_POST['post_ID'] == '') {
                    $_POST['post_name'] = sanitize_title($_POST['post_title']);
                    $_POST['post_status'] = 'publish';
                    $_POST['post_author'] = $user_ID;
                    $_POST['post_date'] = current_time('mysql');
                    $_POST['post_date_gmt'] = '0000-00-00 00:00:00';
                    $_POST['post_modified']     = current_time( 'mysql' );
                    $_POST['post_modified_gmt'] = current_time( 'mysql', 1 );
                    $_POST['comment_status'] = 'closed';
                    $_POST['ping_status'] = 'closed';
                    $_POST['post_parent'] = 0;
                    $_POST['menu_order'] = 0;

                    $result = wp_write_post();
                    if ($result) {
                        unset($_POST);
                        unset($_GET);
                        $msg = '<p style="padding: .5em; background-color: #4AB915; color: #fff; font-weight: bold;">Post type added successfully!</p>';
                    }
                } else {
                    $_POST['post_name'] = sanitize_title($_POST['post_title']);
                    $_POST['post_modified']     = current_time( 'mysql' );
                    $_POST['post_modified_gmt'] = current_time( 'mysql', 1 );
                    $result = edit_post();
                    if ($result) {
                        unset($_POST);
                        unset($_GET);
                        $msg = '<p style="padding: .5em; background-color: #4AB915; color: #fff; font-weight: bold;">Post type updated successfully!</p>';
                        $_POST['post_title'] = '';
                    }
                }
            } else {
                $msg = '<p style="padding: .5em; background-color: #888; color: #fff; font-weight: bold;">Post type already exists.</p>';
            }
        }
        
        $messages = array(
			'post_success' => array('color' => '4AB915', 'text' => __('Post type added successfully!')),
			'post_empty' => array('color' => '888', 'text' => __('Post type cannot be left blank.')),
            'post_exist' => array('color' => '888', 'text' => __('Post type already exists.'))
		);
    } ?>
    <?php if ($msg != '') : ?>
        <div id="message" class="updated fade"><?php echo $msg;?></div>
    <?php endif; ?>
    <div class="wrap">
    	<h2><?php _e('Featured Posts with Multiple Custom Groups Configurations'); ?></h2>
		<?php
		if (isset($_GET['ID']) && $_GET['ID'] != '') { ?>
			<h4>Update Featured Posts Group</h4>
		<?php } else { ?>
			<h4>Add Featured Posts Group</h4>
		<?php } ?>
		<form action="" method="post" id="akismet-conf" style="width: 400px; ">
			<?php
			if (isset($_GET['ID']) && $_GET['ID'] != '') {
				$result = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE ID = '".$_GET['ID']."'");
				$post_title = $result->post_title;
				?>
				<input type="hidden" id ="post_ID" name="post_ID" value="<?php echo $_GET['ID'];?>" />
			<?php
			} else {
				$post_title = '';
			}
			?>
			<p><?php _e('Group Name : '); ?> <input id="post_title" name="post_title" type="text" size="15" style="font-family: 'Courier New', Courier, mono; font-size: 1.5em;" value="<?php echo $post_title;?>" /></p>
			<p class="submit"><?php if (isset($_GET['ID']) && $_GET['ID'] != '') { ?><input type="button" name="back" value="<?php _e('Back'); ?>" onclick="window.location.href='plugins.php?page=post-type-config'" />&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?><input type="submit" name="submit" value="<?php _e('Save'); ?>" /></p>
		</form>
    
    	<table style="border:1px solid black; border-spacing: 2px;" width="50%">
			<tr>
				<td width="20%" style="border: 1px inset gray;"><strong>#</strong></td> 
				<td style="border: 1px inset gray;"><strong>Group Name</strong></td>
				<td style="border: 1px inset gray;"><strong>Action</strong></td>
			</tr>
			<?php
    		$results = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE post_type = 'wafysol_fpmcg' ORDER BY post_title;");
    		if (count($results) > 0) {
        		$rowcnt = 1;
        		foreach ($results as $val) {
            		$query_arg = array('ID' => $val->ID); ?>  
            <tr>
                <td width="20%"  style="border: 1px inset gray;"><?php echo $rowcnt;?></td>
                <td style="border: 1px inset gray;"><?php echo $val->post_title;?></td>    
                <td style="border: 1px inset gray;"><a href="plugins.php?page=post-type-config&ID=<?php echo $val->ID;?>">Edit</a> / <a href="plugins.php?page=post-type-config&action=delete&ID=<?php echo $val->ID;?>" onclick="return confirm('Are you sure you want to delete this group?');">Delete</a></td>
            </tr>
					<?php
            		$rowcnt++;
        		}
    		} else { ?>
			<tr>
				<td style="border: 1px inset gray;" colspan="3">No Records Found.</td>
			</tr>
				<?php
    		} ?>
    	</table>
	</div>
<?php 
}

add_action( 'init', 'mytheme_init_custom_fields' );

function mytheme_init_custom_fields() {
    $meta_boxes = array();
    $opts = mytheme_get_post_category_type( true );
	    
    $meta_boxes[] = array(
		'id' => 'post-cat-type-for-page',
		'title' => 'Featured Posts Groups',
		'priority' => 'high',
		'pages' => array( 'post' ),
		'fields' => array(
			array(
			"id" => "wafysol_fpmcg_pctfp",
			"name" => "Include this post under - ",
			"hint" => "",
			'type' => 'select',
			'properties' => array('multiple' => 'multiple'),
			'options' => $opts,
			),
		)
    );
    
	$my_box = new RW_Meta_Box_Wafysol_fpmcg( $meta_boxes );
}

function mytheme_get_post_category_type( $arr = false ) {
	global $post;
	$args = array(
	    'post_type' => "wafysol_fpmcg",
	);

	$outs = array( );
	$f_query = new WP_Query( $args );

	if ( $arr ) {
		if ( $f_query->have_posts() ) {
			while ( $f_query->have_posts() ) {
				$f_query->the_post();
				$post_id = get_the_ID();
				$outs[ $post_id ] = get_the_title();
			}
		}
		return $outs;
	} else {
		return $f_query;
	}
}
?>