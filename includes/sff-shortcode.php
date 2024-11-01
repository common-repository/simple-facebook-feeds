<?php

/**
 * Register Shortcode
 *
 * Register a shortcode 'simple-facebook-feed' for plugin
 * 'add_shortcode' adds a hook for a shortcode tag.
 *
 * @since 1.0
 *
 * @param '$tag' => (string) (required) Shortcode tag to be searched in post content Default: None 
 * @param  '$func' => (callable) (required) Hook to run when shortcode is found Default: None 
**/
function sff_shortcode_function( $atts, $content = NULL ) {

	/**
	 * Shortcode Attributes
	 *
	 * Set and Get shortcode Attributes
	 *
	 * @since 1.0
	 *
	 * @param 'extract()' => The extract() function imports variables into the local symbol table from an array.
	 * This function uses array keys as variable names and values as variable values. For each element it will create a variable in the current symbol table.
	 * This function returns the number of variables extracted on success.
	 * 
	 * @param  'shortcode_atts' => Combines user shortcode attributes with known attributes and fills in defaults when needed. The result will contain every key from the known attributes,
	 * merged with values from shortcode attributes.
	**/
	extract( shortcode_atts( array(
	        'limit'  => '1'
	    ), $atts ) );

	/**
	 * Plugin Settings
	 *
	 * Get All plugin settings
	 *
	 * @since 1.0
	**/
	$facebook_feed_options = get_option('sff_facebook_feed_options');

	$sff_page_id = $facebook_feed_options['sff_page_id'];
	$sff_api_token = $facebook_feed_options['sff_api_token'];
	$sff_show_post_by = $facebook_feed_options['sff_show_post_by'];
	$sff_container_width = $facebook_feed_options['sff_container_width'];
	$sff_container_height = $facebook_feed_options['sff_container_height'];
	$sff_display_name_avatar = $facebook_feed_options['sff_display_name_avatar'];
	$sff_display_date = $facebook_feed_options['sff_display_date'];
	$sff_display_links = $facebook_feed_options['sff_display_links'];
	$sff_display_msg = $facebook_feed_options['sff_display_msg'];
	$sff_display_view = $facebook_feed_options['sff_display_view'];
	$sff_display_cover = $facebook_feed_options['sff_display_cover'];
	$sff_display_like = $facebook_feed_options['sff_display_like'];

	/*===
		Check the page id and access token
	===*/
	if(!empty($sff_page_id) && !empty($sff_api_token)) {
		ob_start();

		/*===
			Get show posts options
		===*/
		$sff_show_posts = '';
		if($sff_show_post_by == 'sff_me') {
			$sff_show_posts = 'posts';
		} elseif(($sff_show_post_by == 'sff_me_others') || ($sff_show_post_by == 'sff_only_others')) {
			$sff_show_posts = 'feed';
		}

		/*===
			Open Graph Query
		===*/
		$sff_graph_link = "https://graph.facebook.com/$sff_page_id/$sff_show_posts?fields=id,from,message,message_tags,story,story_tags,link,source,name,caption,description,type,status_type,object_id,created_time&limit=$limit&access_token=$sff_api_token";
        $data = file_get_contents($sff_graph_link);
        $result = json_decode($data);

		/*===
			Get Page name, id and cover
		===*/
		$sff_page_name = "https://graph.facebook.com/$sff_page_id?fields=id,name,cover,likes&access_token=$sff_api_token";
        $sff_page_data = file_get_contents($sff_page_name);
        $sff_page_result = json_decode($sff_page_data);

	    // echo "<pre>";
	    // 	print_r($sff_page_result);
	    // echo "</pre>";

	    // exit;

     //    $cff_style_settings = get_option('cff_style_settings');
	    // echo "<pre>";
	    // 	print_r($cff_style_settings);
	    // echo "</pre>";
	    
	    /*===
			Main container
		===*/
	    echo "<div class='sff_facebook_feed'>";

	    	/*===
				Page Cover Photo
			===*/
	    	if($sff_display_cover == 'on') {
		        $sff_page_cover = $sff_page_result->cover->source;
		        echo '<img src="' . $sff_page_cover . '" alt="' . $sff_page_result->name . '" title="' . $sff_page_result->name . '" class="sff_page_cover">';

		        echo $sff_page_result->likes;
		    }

		    /*===
				Page Name
			===*/
			if($sff_display_like == 'on') {
			    $sff_page_link =  $sff_page_result->id;
			    $sff_page_name =  $sff_page_result->name;

				echo "<a class='sff_social_media' href='https://www.facebook.com/$sff_page_link' target='_blank'>
						<i class='fa fa-facebook-square' aria-hidden='true'></i>
					  	<h6>" . $sff_page_name . " / Facebook" . "</h6>
					  </a>";
			}

    		echo "<ul>";
    			/*===
					First Loop for posts & feeds
				===*/
			    foreach($result as $feed_data_value) {
			    	// echo "<pre>";
			    	// 	print_r($feed_data_value);
			    	// echo "</pre>";

			    	/*===
						Second Loop for posts & feeds
					===*/
			    	foreach($feed_data_value as $key => $view) {

			    		/*===
							Disply Block "only_others"
						===*/
						$sff_display_posts = '';
		    			if(($view->from->id == $sff_page_id) && ($sff_show_post_by == 'sff_only_others')) {
		    				$sff_display_posts = "style='display: none;'";
		    			} else {
		    				$sff_display_posts = "style='display: block;'";
		    			}

		    			/*===
							Posts & Feed Container
						===*/
		    			if($view->message || $view->story) {
				    		echo "<li " . $sff_display_posts . ">";

								$sff_split_id = explode('_', $view->id);
								$sff_post_ID = $sff_split_id[1];

								/*===
									User Avatar & Name
								===*/
								if($sff_display_name_avatar == 'on'){
									$sff_from_ID = $view->from->id;
									$sff_from_name = $view->from->name;

					    			
					    			echo '<img src="https://graph.facebook.com/' . $sff_from_ID . '/picture?type=square" class="sffdp_pic">';

					    			echo "<h2>" . $sff_from_name . "</h2>";
									
								}
								?>

								<div class='sff_inner_wrapper' <?php if($sff_display_name_avatar != 'on') { ?> style="width:100%;" <?php } ?> >
								<?php
								/*===
									Posts Date & Time
								===*/
								if($sff_display_date == 'on') {
				    				$created_time = $view->created_time;

					    			$sff_strToTime = strtotime($created_time);

									$sff_month_post = date('M', $sff_strToTime);
									$sff_year_post = date('Y', $sff_strToTime);
									$sff_date_post = date('d', $sff_strToTime);

									echo "<span class='sff_feed_date'>" . $sff_month_post . " " . $sff_date_post . ", " . $sff_year_post . "</span>";
								}

								/*===
									Posts Type
								===*/
				    			if($view->type == 'status') {
									//>> Status

				    				if(($view->message_tags) && ($sff_display_links == 'on')) {
				    					// Mentioned Names
				    					echo '<div class="sff_mention_people">';

				    					$sff_tag_name = array();
				    					$sff_link = array();
						    			foreach($view->message_tags as $key_tag_value) {
						    				$sff_tag_name[] = $key_tag_value->name;
						    				$sff_link[] = "<a href='https://www.facebook.com/" . $key_tag_value->id . "' target='_blank'>" . $key_tag_value->name . "</a>&nbsp";
						    			}

					    				$sff_replace = str_replace($sff_tag_name, $sff_link, $view->message);
					    				echo "<p class='sff_feed_msg'>" . $sff_replace . "</p>";

						    			echo '</div>';
						    		} elseif((!$view->message_tags) && ($sff_display_msg == 'on')) {
						    			// Message
						    			echo "<p class='sff_feed_msg'>" . $view->message . "</p>";
						    		}
				    			} elseif($view->type == 'photo') {
					    			//>> Photo

				    				// Mentioned Names
			    					if(($view->message_tags) && ($sff_display_links == 'on')) {
			    						echo '<div class="sff_mention_people">';

			    						$sff_tag_name = array();
				    					$sff_link = array();
			    						foreach($view->message_tags as $key_tag_value) {
						    				$sff_tag_name[] = $key_tag_value->name;
						    				$sff_link[] = "<a href='https://www.facebook.com/" . $key_tag_value->id . "' target='_blank'>" . $key_tag_value->name . "</a>&nbsp";
						    			}

					    				$sff_replace = str_replace($sff_tag_name, $sff_link, $view->message);
					    				echo "<p class='sff_feed_msg'>" . $sff_replace . "</p>";

						    			echo "</div>";
			    					} elseif((!$view->message_tags) && ($sff_display_msg == 'on')) {
						    			// Message & Stroy
						    			if((!$view->story) && ($view->message)){
					    					echo "<p class='sff_feed_msg'>" . $view->message . "</p>";
					    				} elseif(($view->story) && ($view->message)){
					    					echo "<p class='sff_feed_msg'>" . $view->message . "</p>";
					    				} elseif(($view->story) && (!$view->message)){
					    					echo "<p class='sff_feed_msg'>" . $view->story . "</p>";
					    				}
						    		}
			    					
				    				// Photo Linked
				    				if($sff_display_links == 'on') {
				    					echo '<i class="fa fa-picture-o" aria-hidden="true"></i><a href="' . $view->link . '" target="_blank" class="sff_photo_link">View Photo</a>';
				    				}
				    			} elseif($view->type == 'link') {
				    				//>> Link
				    				if($sff_display_links == 'on') {
					    				echo "<blockqoute>";
					    					echo "<a href='" . $view->link . "'>" . $view->name . "</a>";
					    					echo "<cite>" . $view->caption . "</cite>";
					    					echo "<p>" . $view->description . "</p>";
					    				echo "</blockqoute>";
					    			}
				    			}

				    			/*===
									View thsi post on facebook
								===*/
				    			if($sff_display_view == 'on') {
				    				echo '<span class="sff_view_page_wrap"><i class="fa fa-eye" aria-hidden="true"></i><a href="https://www.facebook.com/' . $sff_page_id . '/posts/' . $sff_post_ID . '" target="_blank" class="sff_view_page"> View on Facebook </a><span>';
				    			}

				    			echo "</div>";

				    		echo "</li>";
			    		}
			    		/*===
							Posts & Feed Container
						===*/
			    	}
			    	/*===
						Second Loop for posts & feeds
					===*/
			    }
			    /*===
					First Loop for posts & feeds
				===*/
			echo "</ul>";

			/*===
				Page like button
			===*/
			
		echo "</div>";
		/*===
			Main container
		===*/

		return ob_get_clean();
	}
}
add_shortcode('simple-facebook-feed', 'sff_shortcode_function');
