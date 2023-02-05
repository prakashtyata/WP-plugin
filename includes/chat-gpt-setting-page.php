<?php

function chat_gpt_setting() { ?>
  <div class="wrap">
    <h1>Theme Panel</h1>
    <form method="post" action="options.php">
      <?php
        settings_fields("section");
        do_settings_sections("theme-options");      
        submit_button();
        ?>
    </form>
  </div>
}

<?php

function display_api_element(){
  echo esc_html('<input type="text" name="api" id="api" placeholder="sk-05s1HVUzmbUDigR6ZXP0T3BlbkFJ7fqkFSRKbHnRdMm*****" value="'.get_option('api'). '" />'); 
}

function display_model_element(){
  echo esc_html('<input type="text" name="model" id="model" placeholder="text-davinci-003" value="'. get_option('model'). '" />');
}

function display_max_tokens_element(){
  echo esc_html('<input type="text" name="max_tokens" id="max_tokens" value="'. get_option('max_tokens').'" />');
}

function display_theme_panel_fields()
{
  add_settings_section("section", "API Settings", null, "theme-options");

  add_settings_field("api", "Chat GPT API", "display_api_element", "theme-options", "section");
  register_setting("section", "api");
  
  add_settings_field("model", "Chat GPT Model", "display_model_element", "theme-options", "section");
  register_setting("section", "model");

  add_settings_field("max_tokens", "Chat GPT Max Tokens", "display_max_tokens_element", "theme-options", "section");
  register_setting("section", "max_tokens");
}

add_action("admin_init", "display_theme_panel_fields");
