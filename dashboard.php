<?php

  class WP_Domain_Search_Dashboard {
    public $id;
    public $wp_domain_search;

    function __construct() {
      $this->id = 'wpdn_dashboard';
    }

    public function create() {
      $wpdn_registrar = get_site_option('wpdn_registrar', 'nerdwarehouse');

      include 'widget.css.php';

      echo '
        <style>
          #registrar_'. $this->id .' {
            border: 1px solid #CCC;
            height: 36px;
            margin-bottom: 10px;
          }
          #domain_'. $this->id .' {
            padding: 0 10px !important;
          }
        </style>

        <form class="wpdn_form"
              data-id="'. $this->id .'"
              data-registrar="'. $wpdn_registrar .'"
              id="form_'. $this->id .'">
          <div id="icon_'. $this->id .'">
            <span class="wpdn-icon-search"></span>
          </div>
          <input id="domain_'. $this->id .'"
                  name="domain_'. $this->id .'"
                  placeholder="'. esc_html__('Enter Domain', 'text_domain') .'"
                  type="text" />
          <button id="search_'. $this->id .'" type="submit">
            '. esc_html__('Search', 'text_domain') .'
          </button>
          <a id="buy_'. $this->id .'" href="" target="_blank" style="display:none;">
            '. esc_html__('Buy Now', 'text_domain') .'
          </a>
        </form>

        <div id="error_'. $this->id .'" style="display: none;"></div>
      ';

      if (current_user_can('manage_options')) {
        echo '
          <style>
            #settings_'. $this->id .' {
              display: inline-block;
              margin-top: 10px;
            }
          </style>
          <a id="settings_'. $this->id .'" href="options-general.php?page=wordpress-domain-search-settings">settings</a>
        ';
      }

      wp_enqueue_style(
        'wpdn-domain-search-icons',
        plugin_dir_url(__FILE__) . 'icomoon.css'
      );

      wp_enqueue_script(
        'jquery-validate',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js',
        array('jquery')
      );

      wp_enqueue_script(
        'wpdn-domain-search'. $this->id,
        plugin_dir_url(__FILE__) . 'widget.js',
        array('jquery', 'jquery-validate')
      );
    }
  }

  function wp_doimain_search_dashboard_widget()
  {
    wp_add_dashboard_widget(
      'wp_doimain_search_dashboard_widget',
      'Wordpress Domain Search',
      function() {
        $wpdn_dashboard = new WP_Domain_Search_Dashboard();
        $wpdn_dashboard->create();
      }
    );
  }
  add_action('wp_dashboard_setup', 'wp_doimain_search_dashboard_widget');