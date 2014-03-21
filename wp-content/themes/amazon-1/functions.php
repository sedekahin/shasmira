<?php
define( 'FASTESTWP_BASE_DIR', TEMPLATEPATH . '/' );
define( 'FASTESTWP_BASE_URL', get_template_directory_uri() . '/' );
include( FASTESTWP_BASE_DIR . 'functions/fastestwp.php' );
include( FASTESTWP_BASE_DIR . 'functions/aws.php' );
include( FASTESTWP_BASE_DIR . 'functions/api.php' );
include( FASTESTWP_BASE_DIR . 'functions/amazon.php' );
include( FASTESTWP_BASE_DIR . 'functions/html.php' );
remove_action('wp_head', 'wp_generator');
?>
<?php
function _remove_script_version( $src ){
    $parts = explode( '?', $src );
    return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
function roots_head_cleanup() {
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

  global $wp_widget_factory;
  remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

  add_filter('use_default_gallery_style', '__return_null');
}
add_action('init', 'roots_head_cleanup');
?>
<?php
/**
 * Root relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in config.php:
 * current_theme_supports('root-relative-urls');
 *
 * @author Scott Walkinshaw <scott.walkinshaw@gmail.com>
 */
function roots_root_relative_url($input) {
  $output = preg_replace_callback(
    '!(https?://[^/|"]+)([^"]+)?!',
    create_function(
      '$matches',
      // If full URL is home_url("/"), return a slash for relative root
      'if (isset($matches[0]) && $matches[0] === home_url("/")) { return "/";' .
      // If domain is equal to home_url("/"), then make URL relative
      '} elseif (isset($matches[0]) && strpos($matches[0], home_url("/")) !== false) { return $matches[2];' .
      // If domain is not equal to home_url("/"), do not make external link relative
      '} else { return $matches[0]; };'
    ),
    $input
  );

  return $output;
}

/**
 * Terrible workaround to remove the duplicate subfolder in the src of <script> and <link> tags
 * Example: /subfolder/subfolder/css/style.css
 */
function roots_fix_duplicate_subfolder_urls($input) {
  $output = roots_root_relative_url($input);
  preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);

  if (isset($matches[1]) && isset($matches[2])) {
    if ($matches[1][0] === $matches[2][0]) {
      $output = substr($output, strlen($matches[1][0]) + 1);
    }
  }

  return $output;
}

if (!is_admin() && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
  add_filter('bloginfo_url', 'roots_root_relative_url');
  add_filter('theme_root_uri', 'roots_root_relative_url');
  add_filter('stylesheet_directory_uri', 'roots_root_relative_url');
  add_filter('template_directory_uri', 'roots_root_relative_url');
  add_filter('script_loader_src', 'roots_fix_duplicate_subfolder_urls');
  add_filter('style_loader_src', 'roots_fix_duplicate_subfolder_urls');
  add_filter('plugins_url', 'roots_root_relative_url');
  add_filter('the_permalink', 'roots_root_relative_url');
  add_filter('wp_list_pages', 'roots_root_relative_url');
  add_filter('wp_list_categories', 'roots_root_relative_url');
  add_filter('wp_nav_menu', 'roots_root_relative_url');
  add_filter('the_content_more_link', 'roots_root_relative_url');
  add_filter('the_tags', 'roots_root_relative_url');
  add_filter('get_pagenum_link', 'roots_root_relative_url');
  add_filter('get_comment_link', 'roots_root_relative_url');
  add_filter('month_link', 'roots_root_relative_url');
  add_filter('day_link', 'roots_root_relative_url');
  add_filter('year_link', 'roots_root_relative_url');
  add_filter('tag_link', 'roots_root_relative_url');
  add_filter('the_author_posts_link', 'roots_root_relative_url');
}
/**
* URL rewriting and addition of HTML5 Boilerplate's .htaccess
*
* Rewrites currently do not happen for child themes (or network installs)
* @todo https://github.com/retlehs/roots/issues/461
*
* Rewrite:
* /wp-content/themes/themename/css/ to /css/
* /wp-content/themes/themename/js/ to /js/
* /wp-content/themes/themename/img/ to /img/
* /wp-content/plugins/ to /plugins/
*
* If you aren't using Apache, alternate configuration settings can be found in the docs.
*
* @link https://github.com/retlehs/roots/blob/master/doc/rewrites.md
*/

if (stristr($_SERVER['SERVER_SOFTWARE'], 'apache') || stristr($_SERVER['SERVER_SOFTWARE'], 'litespeed') !== false) {

  // Show an admin notice if .htaccess isn't writable
  function roots_htaccess_writable() {
    if (!is_writable(get_home_path() . '.htaccess')) {
      if (current_user_can('administrator')) {
        add_action('admin_notices', create_function('', "echo '<div class=\"error\"><p>" . sprintf(__('Please make sure your <a href="%s">.htaccess</a> file is writable ', 'roots'), admin_url('options-permalink.php')) . "</p></div>';"));
      }
    }
  }

  add_action('admin_init', 'roots_htaccess_writable');

  function roots_add_rewrites($content) {
    global $wp_rewrite;
    $roots_new_non_wp_rules = array(
      'assets/css/(.*)' => THEME_PATH . '/assets/css/$1',
      'assets/js/(.*)' => THEME_PATH . '/assets/js/$1',
      'assets/img/(.*)' => THEME_PATH . '/assets/img/$1',
      'plugins/(.*)' => RELATIVE_PLUGIN_PATH . '/$1'
    );
    $wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $roots_new_non_wp_rules);
    return $content;
  }

  function roots_clean_urls($content) {
    if (strpos($content, FULL_RELATIVE_PLUGIN_PATH) === 0) {
      return str_replace(FULL_RELATIVE_PLUGIN_PATH, WP_BASE . '/plugins', $content);
    } else {
      return str_replace('/' . THEME_PATH, '', $content);
    }
  }

  if (!is_multisite() && !is_child_theme() && get_option('permalink_structure')) {
    if (current_theme_supports('rewrite-urls')) {
      add_action('generate_rewrite_rules', 'roots_add_rewrites');
    }

    if (current_theme_supports('h5bp-htaccess')) {
      add_action('generate_rewrite_rules', 'roots_add_h5bp_htaccess');
    }

    if (!is_admin() && current_theme_supports('rewrite-urls')) {
      $tags = array(
        'plugins_url',
        'bloginfo',
        'stylesheet_directory_uri',
        'template_directory_uri',
        'script_loader_src',
        'style_loader_src'
      );

      add_filters($tags, 'roots_clean_urls');
    }
  }

  // Add the contents of h5bp-htaccess into the .htaccess file
  function roots_add_h5bp_htaccess($content) {
    global $wp_rewrite;
    $home_path = function_exists('get_home_path') ? get_home_path() : ABSPATH;
    $htaccess_file = $home_path . '.htaccess';
    $mod_rewrite_enabled = function_exists('got_mod_rewrite') ? got_mod_rewrite() : false;

    if ((!file_exists($htaccess_file) && is_writable($home_path) && $wp_rewrite->using_mod_rewrite_permalinks()) || is_writable($htaccess_file)) {
      if ($mod_rewrite_enabled) {
        $h5bp_rules = extract_from_markers($htaccess_file, 'HTML5 Boilerplate');
        if ($h5bp_rules === array()) {
          $filename = dirname(__FILE__) . '/h5bp-htaccess';
          return insert_with_markers($htaccess_file, 'HTML5 Boilerplate', extract_from_markers($filename, 'HTML5 Boilerplate'));
        }
      }
    }

    return $content;
  }

}
?>