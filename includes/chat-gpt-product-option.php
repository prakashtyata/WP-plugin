<?php


add_action('woocommerce_product_options_general_product_data', 'swc_woocommerce_product_custom_fields');
// Save Fields
add_action('woocommerce_process_product_meta', 'swc_woocommerce_product_custom_fields_save');
function swc_woocommerce_product_custom_fields()
{
    global $woocommerce, $post;
    ?>
    <div class="product_custom_field">

    <?php
    //Custom Product Seo Title Text
    woocommerce_wp_text_input(
        array('id' => 'product_seo_title', 'placeholder' => 'Product Seo Title', 'label' => __('For Product Seo Title', 'woocommerce') )
    );

    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array( 'id' => 'product_seo_description', 'placeholder' => 'Product Seo Descirption', 'label' => __('For Product Seo Descirption', 'woocommerce') )
    );

    //Custom Product  Textarea
    woocommerce_wp_textarea_input(
        array( 'id' => 'product_faq_textarea', 'placeholder' => 'Product FAQ Json Data', 'label' => __('For FAQ Use', 'woocommerce') )
    );

    //Custom Product  Textarea
    woocommerce_wp_text_input(
        array( 'id' => 'product_faq_script_input', 'placeholder' => 'Product FAQ Script', 'label' => __('For FAQ Schema', 'woocommerce') )
    );
    //Custom Product checkbox 
    woocommerce_wp_checkbox( 
    array(  'id' => '_custom_product_openai_GPT_3',  'wrapper_class' => '',  'label' => __('Openai GPT-3', 'woocommerce' ),  'description'  => __( 'Uncheck if You want to Update Product Description, Seo TItle and Seo Descirption ', 'woocommerce' ) 
        )
    );
    ?>
    </div>
<?php
}
function swc_woocommerce_product_custom_fields_save($post_id)
{
    // Custom Product Textarea Field
    $woocommerce_custom_product_seo_title = $_POST['product_seo_title'];
    if (!empty($woocommerce_custom_product_seo_title))
    update_post_meta($post_id, 'product_seo_title', esc_html($woocommerce_custom_product_seo_title));

    // Custom Product Textarea Field
    $woocommerce_custom_product_seo_description = $_POST['product_seo_description'];
    if (!empty($woocommerce_custom_product_seo_description))
    update_post_meta($post_id, 'product_seo_description', esc_html($woocommerce_custom_product_seo_description));

    // Custom Product Textarea Field
    $woocommerce_custom_product_textarea = $_POST['product_faq_textarea'];
    if (!empty($woocommerce_custom_product_textarea))
    update_post_meta($post_id, 'product_faq_textarea', esc_html($woocommerce_custom_product_textarea));


    // Custom Product Textarea Field
    $woocommerce_custom_product_schema = $_POST['product_faq_script_input'];
    if (!empty($woocommerce_custom_product_schema))
    update_post_meta($post_id, 'product_faq_script_input', esc_html($woocommerce_custom_product_schema));

    // Custom Product checkbox
    $woocommerce_custom_product_checkbox = isset( $_POST['_custom_product_openai_GPT_3'] ) ? 'yes' : 'no';
    if (!empty($woocommerce_custom_product_checkbox))
    update_post_meta( $post_id, '_custom_product_openai_GPT_3', $woocommerce_custom_product_checkbox );  
}
