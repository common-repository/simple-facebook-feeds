<div class="sff_plugin_body">

    <img src="<?php echo SFF_OLUGIN_URI . "admin/assets/images/cover-heading.png" ?>" alt="simple-facebook-feeds" class="sff_heading_cover">

    <?php
        if ( isset( $_GET['settings-updated'] ) ) {
    ?>
            <div id="sff-setting-message">
                <?php _e("Settings Saved Successfully","simple-facebook-feeds") ?>
            </div>
    <?php
        }
    ?>
        
    <div id="sff_form_body">
        <form method="post" action="options.php">
        <?php
            settings_fields('sff_facebook_feed_settings');

            $facebook_feed_options = get_option('sff_facebook_feed_options');
        ?>
            <!-- = Facebook Settings = -->
            <div id="sff_form_form">
                <h2>
                    <i class="fa fa-facebook-square" aria-hidden="true"></i>
                    <?php echo get_admin_page_title(); ?>
                </h2>

                <table class="settings-table" border="0" width="100%" cellspacing="6">
                    <tbody>

                        <tr valign="top">
                            <th scope="row"><?php _e("Your Page ID", "simple-facebook-feeds"); ?></th>
                            <td>
                                <input type="text" name="sff_facebook_feed_options[sff_page_id]" id="sff_page_id" value="<?php echo esc_html($facebook_feed_options['sff_page_id']); ?>">

                                <span class="sff_api_note">
                                    <strong><?php _e("Note: ","simple-facebook-feeds"); ?> </strong> <?php _e("Please add your Page Id here.","simple-facebook-feeds"); ?>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th valign="top" scope="row"><?php _e("Access Token","simple-facebook-feeds"); ?></th>
                            <td>
                                <input type="text" name="sff_facebook_feed_options[sff_api_token]" id="sff_api_token" value="<?php echo esc_html($facebook_feed_options['sff_api_token']); ?>">

                                <span class="sff_api_note">
                                    <strong><?php _e("Note: ","simple-facebook-feeds"); ?> </strong> <?php _e("Please add your Access Token here.","simple-facebook-feeds"); ?>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th valign="top" scope="row"><?php _e("Show Posts by","simple-facebook-feeds"); ?></th>
                            <td>
                                <select name="sff_facebook_feed_options[sff_show_post_by]" id="sff_show_post_by">
                                    <option value="sff_me" <?php echo (($facebook_feed_options['sff_show_post_by'] == 'sff_me') ? 'selected' : '') ?>>
                                        <?php _e("Only the page owner", "simple-facebook-feeds") ?>
                                    </option>
                                    <option value="sff_me_others" <?php echo (($facebook_feed_options['sff_show_post_by'] == 'sff_me_others') ? 'selected' : '') ?>>
                                        <?php _e("Page owner & Other people", "simple-facebook-feeds") ?>
                                    </option>
                                    <option value="sff_only_others" <?php echo (($facebook_feed_options['sff_show_post_by'] == 'sff_only_others') ? 'selected' : '') ?>>
                                        <?php _e("Other people", "simple-facebook-feeds") ?>
                                    </option>
                                </select>

                                <span class="sff_api_note">
                                    <strong><?php _e("Note: ","simple-facebook-feeds"); ?> </strong> <?php _e("Select option from where you want to show posts.","simple-facebook-feeds"); ?>
                                </span>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <!-- = General Layout = -->
            <div id="sff_form_form">
                <h2>
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <?php _e("General Layout", "simple-facebook-feeds"); ?>
                </h2>

                <table class="settings-table" border="0" width="100%" cellspacing="6">
                    <tbody>

                        <tr valign="top">
                            <th width="20%"><?php _e("Container Width", "simple-facebook-feeds"); ?></th>
                            <td width="80%">
                                <input type="text" name="sff_facebook_feed_options[sff_container_width]" id="sff_container_width" value="<?php echo esc_html($facebook_feed_options['sff_container_width']); ?>" class="sff_small_input">

                                <span class="sff_api_note">
                                    <strong><?php _e("Eg. ","simple-facebook-feeds"); ?> </strong> <?php _e("500px, 50%, 10em. Default is 100%.","simple-facebook-feeds"); ?>
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th><?php _e("Container Height", "simple-facebook-feeds"); ?></th>
                            <td>
                                <input type="text" name="sff_facebook_feed_options[sff_container_height]" id="sff_container_height" value="<?php echo esc_html($facebook_feed_options['sff_container_height']); ?>" class="sff_small_input">

                                <span class="sff_api_note">
                                    <strong><?php _e("Eg. ","simple-facebook-feeds"); ?> </strong> <?php _e("500px, 50em. Leave empty to set no maximum height. If the feed exceeds this height then a scroll bar will be used.","simple-facebook-feeds"); ?>
                                </span>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <!-- = Hide Show = -->
            <div id="sff_form_form">
                <h2>
                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                    <?php _e("Hide / Show", "simple-facebook-feeds"); ?>
                </h2>

                <table class="settings-table" border="0" width="100%" cellspacing="6">
                    <tbody>

                        <tr valign="top">
                            <th width="20%"><?php _e("Include the following in posts", "simple-facebook-feeds"); ?></th>
                            <td width="80%">
                            
                            <table class="settings-table" border="0" width="100%" cellspacing="6">
                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="sff_facebook_feed_options[sff_display_name_avatar]" <?php echo ($facebook_feed_options['sff_display_name_avatar'] == 'on' ? 'checked' : '') ?>>
                                            &nbsp;
                                            Author name and avatar
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="sff_facebook_feed_options[sff_display_date]" <?php echo ($facebook_feed_options['sff_display_date'] == 'on' ? 'checked' : '') ?>>
                                            &nbsp;
                                            Post Date
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="sff_facebook_feed_options[sff_display_links]" <?php echo ($facebook_feed_options['sff_display_links'] == 'on' ? 'checked' : '') ?>>
                                            &nbsp;
                                            Links, Videos, Photos
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="sff_facebook_feed_options[sff_display_msg]" <?php echo ($facebook_feed_options['sff_display_msg'] == 'on' ? 'checked' : '') ?>>
                                            &nbsp;
                                            Post Message
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="sff_facebook_feed_options[sff_display_view]" <?php echo ($facebook_feed_options['sff_display_view'] == 'on' ? 'checked' : '') ?>>
                                            &nbsp;
                                            View on Facebook
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="sff_facebook_feed_options[sff_display_cover]" <?php echo ($facebook_feed_options['sff_display_cover'] == 'on' ? 'checked' : '') ?>>
                                            &nbsp;
                                            Page Cover Photo
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>
                                            <input type="checkbox" name="sff_facebook_feed_options[sff_display_like]" <?php echo ($facebook_feed_options['sff_display_like'] == 'on' ? 'checked' : '') ?>>
                                            &nbsp;
                                            Like us Button
                                        </label>
                                    </td>
                                </tr>

                            </table>

                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <input type="submit" value="<?php _e('Save Settings','simple-facebook-feeds'); ?>" id="save_settings">
        </form>
    </div>

    <div class="sff_notifications">
        <h2>
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <?php _e("Information","simple-facebook-feeds"); ?>
        </h2>

        <ul>
            <li class="sff_ino_Q">
                <?php _e("How to create a Facebook API?","simple-facebook-feeds"); ?>
            </li>
            <li class="sff_ino_A">
                <a href="https://developers.facebook.com/docs/pages/getting-started" target="_blank">
                    <?php _e("Click here","simple-facebook-feeds"); ?>
                </a>
            </li>
            <li class="sff_ino_Q">
                <?php _e("How to get API Access Token?","simple-facebook-feeds"); ?>
            </li>
            <li class="sff_ino_A">
                <a href="https://developers.facebook.com/tools/explorer/" target="_blank">
                    <?php _e("Click here","simple-facebook-feeds"); ?>
                </a>
            </li>
            <li class="sff_ino_Q">
                <?php _e("How to get life time API Access Token?"); ?>
            </li>
            <li class="sff_ino_A">
                <a href="https://developers.facebook.com/tools/debug/" target="_blank">
                    <?php _e("Click here","simple-facebook-feeds"); ?>
                </a>
            </li>
            <li class="sff_ino_Q">
                <?php _e("How to get Your Page ID?","simple-facebook-feeds"); ?>
            </li>
            <li class="sff_ino_A">
                <a href="http://findmyfbid.com/" target="_blank">
                    <?php _e("Click here","simple-facebook-feeds"); ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="sff_how_use">
        
        <h3>
            <i class="fa fa-question-circle" aria-hidden="true"></i>
            <?php _e("How to use","simple-facebook-feeds") ?>
        </h3>

        <ul>
            <li>
                <strong><?php _e('Simple Usage: ', 'simple-facebook-feeds'); ?> </strong><?php _e('You can display feeds from your page you like with a simple short code', 'simple-facebook-feeds'); ?>
                <code>[simple-facebook-feed]</code>
            </li>
            <li>
                <strong><?php _e('Limit Feeds: ', 'simple-facebook-feeds'); ?> </strong><?php _e('You can use ', 'simple-facebook-feeds'); ?>
                <code>[simple-facebook-feed limit=10]</code> <?php _e('to display specific amount of feeds.', 'simple-facebook-feeds'); ?>
            </li>
            <li>
                <strong><?php _e('Widget: ', 'simple-facebook-feeds'); ?> </strong><?php _e('You can use Widget', 'simple-facebook-feeds'); ?>
                <code>Simple Facebook Widget</code> <?php _e('to display feeds in sidebar.', 'simple-facebook-feeds'); ?>
            </li>
            <li>
                <strong><?php _e('Snippet: ', 'simple-facebook-feeds'); ?> </strong><?php _e('You can also snippet', 'simple-facebook-feeds'); ?>
                <code>simple_facebook_feed($limit)</code> <?php _e('for showing feeds. Also use numeric value in braces for limitise the feeds e.g.', 'simple-facebook-feeds'); ?>
                <code>simple_facebook_feed(6)</code>
            </li>
        </ul>

    </div>

</div>