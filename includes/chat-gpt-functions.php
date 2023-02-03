<?php
/*
 * Add my new menu to the Admin Control Panel
 */


// Hook the 'admin_menu' action hook, run the function named 'chatgpt_seo_wizard_menu()'
function chatgpt_seo_wizard_menu() {
add_menu_page(
	'Chat GPT', // Title of the page
	'Chat GPT', // Text to show on the menu link
	'manage_options', // Capability requirement to see the link
	'chat-gpt', // The 'slug' - file to display when clicking the link
	'chat_gpt_setting', // function that show content in plugin plage chat_gpt_setting()
'dashicons-schedule',
3
);

}
add_action( 'admin_menu', 'chatgpt_seo_wizard_menu' );


