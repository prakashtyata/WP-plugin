<?php

function swc_change_each_product_title( $title ) {
    if (is_product()){
        global $post;
        $seo_title = get_post_meta( $post->ID, 'product_seo_title', true );
        $title = $seo_title;
        return $title;
    }
    return $title;
}

add_filter( 'pre_get_document_title', 'swc_change_each_product_title', 9999 );



function swc_woocommerce_after_single_product_summary() {
        
    $devlink = get_post_meta( get_the_ID(), 'product_faq_textarea', true );
    $dev_faq = json_decode($devlink);

    if (!empty($devlink)) { ?>

        <div class="dev_rank-math-list">
            <h3>FAQs</h3>
            <div class="rank-math-list ">
                <?php
                    foreach($dev_faq as $arrays) { ?>
                        <div class="rank-math-list-item">
                            <?php 
                                if (!empty($arrays->question)){ ?>
                                    <h5 class="rank-math-question show"> <?php echo $arrays->question; ?></h5>
                                <?php }
                                else if (!empty($arrays->Question)){ ?>
                                    <h5 class="rank-math-question show"><?php echo $arrays->Question; ?></h5>
                                <?php }
                                else if(!empty($arrays->FAQ)){ ?>
                                    <h5 class="rank-math-question show"><?php echo $arrays->FAQ; ?></h5>
                                <?php } 
                                else{ ?>
                                    <h5 class="rank-math-question show"><?php echo $arrays->q; ?></h5>
                                <?php } ?>

                                <div class="rank-math-answer showing">
                                    <?php
                                    if (!empty($arrays->answer)){ ?>
                                        <p><?php echo $arrays->answer; ?></p> 
                                    <?php }
                                    else if (!empty($arrays->Answer)){ ?>
                                        <p><?php echo $arrays->Answer; ?></p> 
                                    <?php }
                                    else if(!empty($arrays->a)){ ?>
                                        <p><?php echo $arrays->a; ?></p> 
                                    <?php } 
                                    else{ ?>
                                        <p><?php echo $arrays->Answer; ?></p> 
                                    <?php } ?>
                                </div>
                        </div>
                    <?php }
                ?>

            </div>
        </div>
        <script>
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
        </script>
    <?php
    }

} 
  add_action( 'woocommerce_after_single_product_summary', 'swc_woocommerce_after_single_product_summary');


function swc_hook_javascript() {
    
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
        echo esc_js(temp_html);
    }
}
add_action('wp_head', 'swc_hook_javascript');





function swc_meta_description() {
    if (is_product()){
        global $post;
        $seo_title = get_post_meta( $post->ID, 'product_seo_description', true ); ?>
        <meta name="description" content="<?php echo $seo_title ?>" /> <br>
    <?php }

}
add_action( 'wp_head', 'swc_meta_description');