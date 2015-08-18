<?php
/*
Plugin Name: WP Remote Test
Plugin URI: http://www.meow.fr
Description: Remote connection tester.
Version: 2.5.2
Author: Jordy Meow
Author URI: http://www.meow.fr

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html

Originally developed for two of my websites:
- Totoro Times (http://www.totorotimes.com)
- Haikyo (http://www.haikyo.org)
*/

add_action( 'admin_menu', 'wprt_admin_menu' );

function wprt_admin_menu() {
	add_submenu_page( 'tools.php', 'Remote Test', 'Remote Test', 'manage_options', 'wp-remote-test', 'wprt_screen' );
}

function wprt_screen() {
  echo '<div class="wrap"><h2>WP Remote Test</h2>';
  $action = isset( $_POST[ 'action' ] ) ? $_POST[ 'action' ] : null;
  $url = isset( $_POST[ 'url' ] ) ? $_POST[ 'url' ] : null;
  $method = isset( $_POST[ 'method' ] ) ? $_POST[ 'method' ] : null;
  $useragent = isset( $_POST[ 'useragent' ] ) ? $_POST[ 'useragent' ] : null;
  if ( $action == 'xmlrpc' ) {
    echo "<h3>Results</h3>";
    require_once ABSPATH . WPINC . '/class-IXR.php';
    require_once ABSPATH . WPINC . '/class-wp-http-ixr-client.php';
    $client = new WP_HTTP_IXR_Client( $url );
    $client->useragent = $useragent;
    if ( !$client->query( $method ) ) {
      print_r ( $client->error );
    }
    else {
      print_r( $client->getResponse() );
    }
  }

  ?>
  <h3>XML/RPC (WP_HTTP_IXR_Client)</h3>
  <form id="posts-filter" action="" method="POST">
    <p>
      <label>URL</label><br />
      <input type="text" name="url" style="width: 360px;" value="http://apps.meow.fr/xmlrpc.php"><br />
    </p>
    <p>
      <label>Method</label><br />
      <input type="text" name="method" style="width: 360px;" value="meow_sales.auth"><br />
    </p>
    <p>
      <label>User Agent</label><br />
      <input type="text" name="useragent" style="width: 360px;" value="MeowApps"><br />
    </p>
    <input type="hidden" name="action" value="xmlrpc">
    <input type="submit" class="button" value="Query">
  </form>
  <?php

  echo '</div>';
}
