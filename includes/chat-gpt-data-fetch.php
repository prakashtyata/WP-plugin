<?php


add_action( 'added_post_meta', 'swc_mp_sync_on_product_save', 10, 4 );
add_action( 'updated_post_meta', 'swc_mp_sync_on_product_save', 10, 4 );
function swc_mp_sync_on_product_save( $meta_id, $post_id, $meta_key, $meta_value ) {
    if ( $meta_key == '_edit_lock' ) { // we've been editing the post
        if ( get_post_type( $post_id ) == 'product' ) { // we've been editing a product
            $product = wc_get_product( $post_id );
            $check = get_post_meta($post_id, '_custom_product_openai_GPT_3');
            if($check[0] == "no" || $check[0] == ""){

                $api_key = get_option('api');
                $model_id = get_option('model');
                $product_title = $product->get_title();



                // this is for seo title
                $seo_meta_title = 'write SEO title with no more than 60 characters in terms of length for the product: "'.$product_title.'" and without repeating the product name more than one time.'; 
                $response_meta_title = get_gpt3_response($seo_meta_title, $model_id, $api_key);
                $seo_meta_title_text = sanitize_text_field($response_meta_title['choices'][0]['text']);
                update_post_meta( $post_id, 'product_seo_title', $seo_meta_title_text );

                // this is for product seo description
                $seo_meta_description = 'write SEO meta description with no more than 160 characters in terms of length for the product: "'.$product_title.'" and without repeating the product name more than one time.';
                $response_meta_description = get_gpt3_response($seo_meta_description, $model_id, $api_key);
                $seo_meta_description_text = sanitize_text_field($response_meta_description['choices'][0]['text']);   
                update_post_meta( $post_id, 'product_seo_description', $seo_meta_description_text );
                
                // this is for seo Description
                $seo_product_description = 'write product description for the product: "'.$product_title.'" with no less than 600 words and without repeating the product name more than one time';
                $response_product_description = get_gpt3_response($seo_product_description, $model_id, $api_key);
                $product_description_text = $response_product_description['choices'][0]['text'];   
                $product->set_description($product_description_text);
                $product->save();

                // this is for seo product faq
                // $seo_product_faq = 'Give me the 3 FAQ along with its short answer and the answers word count should not be more than 50 words from above reply in JSON Array format';
                $seo_product_faq = 'Give me the 3 FAQ along with its short answer and the answers word count should not be more than 50 words for the product "'.$product_title.'" in JSON Array format';
                $response_product_faq = get_gpt3_response($seo_product_faq, $model_id, $api_key); 
                $seo_faq_text_array =  $response_product_faq['choices'][0]['text'];
                update_post_meta( $post_id, 'product_faq_textarea', $seo_faq_text_array );



                update_post_meta( $post_id, '_custom_product_openai_GPT_3', "yes" ); //to disable from auto update


            }
        }
    }
}




// Function that makes the request to the OpenAI API and returns the response
function get_gpt3_response($prompt, $model_id, $api_key)
{
     $response = wp_remote_post(
        'https://api.openai.com/v1/completions',
        array(
            'headers'     => array(
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer ' . $api_key,
            ),
            'body'        => json_encode(
                array(
                    'model'      => $model_id, // Most capable model of GPT3
                    'prompt'     => $prompt,
                    'max_tokens' => 4000, // This is length of generated prompt. A token is about 4 chars. I took 110 from Lex.page.
                    'user'       => strval( get_current_user_id() ), // This logs the user id on the OpenAI side so it's easier to detect abuse.
                )
            ),
            'method'      => 'POST',
            'timeout'     => 60,
            'data_format' => 'body',
        )
    );


    $response_data = json_decode($response['body'], true);

    return $response_data;

}
