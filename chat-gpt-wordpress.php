<?php
/**
* Plugin Name: SEO Wizard with ChatGPT
* Plugin URI: https://rankmetop.net/
* Description: Integrate Chat GPT to WordPress for various purpose
* Version: 1.0.0
* Author: Rank Me Top
* Author URI: https://rankmetop.net/
* Text Domain: seo-wizard-chatgpt 
* 
* */


// Include chat-gpt-functions.php, use require_once to stop the script if chat-gpt-functions.php is not found
require_once plugin_dir_path(__FILE__) . 'includes/chat-gpt-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/chat-gpt-setting-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/chat-gpt-product-option.php';
require_once plugin_dir_path(__FILE__) . 'includes/chat-gpt-data-fetch.php';
require_once plugin_dir_path(__FILE__) . 'includes/chat-gpt-data-implement.php';




