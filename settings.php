<?php

class WP_Domain_Search_Settings
{
  public $slug = 'wordpress-domain-search-settings';
  public $title = 'WP Domain Search';

  public function __construct()
  {
    add_action('admin_menu', array($this, 'create_page'));
  }

  public function create_page()
  {
    $page_title = $this->title;
    $menu_title = $this->title;
    $capability = 'manage_options';
    $slug = $this->slug;
    $callback = array($this, 'create_page_content');
    $position = 100;

    add_submenu_page('options-general.php', $page_title, $menu_title, $capability, $slug, $callback, $position);
    add_filter('plugin_action_links_wordpress-domain-search/wordpress-domain-search.php', array($this, 'create_settings_link'));
  }

  public function create_page_content()
  {
    if ($_POST && $_POST['updated'] === 'true') {
      $this->handle_form();
    }

    $wpdn_registrar = get_site_option('wpdn_registrar', 'nerdwarehouse');
    ?>
    <div class="wrap">
      <h1>WordPress Domain Search</h1>

      <form method="POST" id="wpdn-form">

        <input type="hidden" name="updated" value="true" />
        <input type="hidden" name="reset" id="reset" value="0" />
        <?php wp_nonce_field($this->slug . '_update', $this->slug . '_form'); ?>

        <table class="form-table" role="presentation">
          <tbody>
            <tr>
              <th scope="row"><label for="wpdn_registrar">Default Registrar</label></th>
              <td>
                <select name="wpdn_registrar" id="wpdn_registrar" class="postform">
                  <option class="level-0" <?php selected('nerdwarehouse', $wpdn_registrar); ?> value="nerdwarehouse">NerdWarehouse.com</option>
                  <option class="level-0" <?php selected('domain', $wpdn_registrar); ?> value="domain">Domain.com</option>
                  <option class="level-0" <?php selected('godaddy', $wpdn_registrar); ?> value="godaddy">GoDaddy.com</option>
                  <option class="level-0" <?php selected('namecheap', $wpdn_registrar); ?> value="namecheap">Namecheap.com</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>

        <p class="submit">
          <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
        </p>
      </form>
    </div>
    <?php
  }

  public function handle_form()
  {
    if (!isset($_POST[$this->slug . '_form']) || !wp_verify_nonce($_POST[$this->slug . '_form'], $this->slug . '_update')) {
      echo '<div class="notice notice-error is-dismissible"><p>Sorry, your nonce was not correct. Please try again.</p></div>';
      exit;
    } else {
      update_site_option('wpdn_registrar', sanitize_text_field($_POST['wpdn_registrar']));
      echo '<div class="notice notice-success is-dismissible"><p>Your changes were saved!</p></div>';
    }
  }

  public function create_settings_link($links) {
    $url = esc_url(add_query_arg(
      'page',
      'wordpress-domain-search-settings',
      get_admin_url() . 'options-general.php'
    ));

    $settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';

    array_push($links, $settings_link);

    return $links;
  }
}

new WP_Domain_Search_Settings();