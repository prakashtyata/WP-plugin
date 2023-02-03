<?php

function change_each_product_title( $title ) {
    if (is_product()){
        global $post;
        $seo_title = get_post_meta( $post->ID, 'product_seo_title', true );
        $title = $seo_title;
        return $title;
    }
    return $title;
}

add_filter( 'pre_get_document_title', 'change_each_product_title', 9999 );



function pra_woocommerce_after_single_product_summary() {
        
    $devlink = get_post_meta( get_the_ID(), 'product_faq_textarea', true );
    $dev_faq = json_decode($devlink);

    if (!empty($devlink)) {
        $html = '<div class="dev_rank-math-list ">';
        $html .= '<h3>FAQs</h3>';
        $html .= '<div class="rank-math-list ">';
        foreach($dev_faq as $arrays) {
            $html .='<div class="rank-math-list-item">';
                if (!empty($arrays->question)){ $html .='<h5 class="rank-math-question show">'.$arrays->question.'</h5>'; }
                else{ $html .='<h5 class="rank-math-question show">'.$arrays->Question.'</h5>'; }

            $html .='<div class="rank-math-answer showing">';
                if (!empty($arrays->answer)){ $html .='<p>'.$arrays->answer.'</p>'; }
                else{ $html .='<p>'.$arrays->Answer.'</p>'; }

            $html .='</div>';
            $html .='</div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        echo $html; 

        echo '<script>
                jQuery(document).ready(function(){
                  jQuery(".rank-math-list-item .rank-math-question").click(function(){
                    jQuery(this).parents(".rank-math-list-item").siblings().find(".rank-math-answer").hide(600);
                      jQuery(this).parents(".rank-math-list-item").siblings().find(".rank-math-question").removeClass("open");
                    if(jQuery(this).next().is(":visible")){
                      jQuery(this).next().hide(600);
                      jQuery(this).removeClass("open");
                    }
                    else{
                      jQuery(this).addClass("open");
                      jQuery(this).next().show(600);
                    }
                  });
                });         
                </script>';
    }

} 
  add_action( 'woocommerce_after_single_product_summary', 'pra_woocommerce_after_single_product_summary');


function hook_javascript() {
    
    $devlink = get_post_meta( get_the_ID(), 'product_faq_textarea', true );
    $dev_faq = json_decode($devlink);

    if (!empty($dev_faq)) {
        $counter = 0;
        $temp_html ='';
        $temp_html .='<script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "FAQPage",
              "mainEntity": ['; 

             foreach($dev_faq as $arrays) { 

                if (!empty($arrays->question)){
                    $temp_html .= '{
                        "@type": "Question",
                        "name": "'.$arrays->question.'",
                        "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "'.$arrays->answer.'"
                        }
                    }';
                    if($counter < 2){
                        $temp_html .= ',';
                    }
                }
                else{
                    $temp_html .= '{
                        "@type": "Question",
                        "name": "'.$arrays->Question.'",
                        "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "'.$arrays->Answer.'"
                        }
                    }';
                    if($counter < 2){
                        $temp_html .= ',';
                    }
                }
                $counter++;
            }   

        $temp_html .=' ]
            }
            </script>'; 

        echo $temp_html;
    }
}
add_action('wp_head', 'hook_javascript');





function dev_meta_description() {
    if (is_product()){
        global $post;
        $seo_title = get_post_meta( $post->ID, 'product_seo_description', true );
        echo '<meta name="description" content="' . $seo_title . '" />' . "\n";
    }

}
add_action( 'wp_head', 'dev_meta_description');