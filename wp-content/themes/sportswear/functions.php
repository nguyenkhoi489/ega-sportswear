<?php
// Add custom Theme Functions here
add_filter('use_block_editor_for_post', '__return_false');


add_action('init', 'hide_notice');
function hide_notice()
{
    remove_action('admin_notices', 'flatsome_maintenance_admin_notice');
}


function load_script()
{
    if (is_singular('product') && get_option('config_setting_shop_coupon_enable_product_detail') == 'on') {
        wp_enqueue_style(
            'cart-coupons',
            get_stylesheet_directory_uri() .
                '/assets/css/cart-coupon.css'
        );
    }
    if (is_singular('product')) {
        if (!wp_script_is('fancybox')) {
            wp_enqueue_script('fancybox', get_stylesheet_directory_uri() . '/assets/js/jquery.fancybox.min.js', array('jquery'), time(), true);
            wp_enqueue_script('fancybox_custom', get_stylesheet_directory_uri() . '/assets/js/fancybox_custom.js', array('jquery'), time(), true);
        }
        if (!wp_style_is('fancybox')) {
            wp_enqueue_style(
                'fancybox',
                get_stylesheet_directory_uri() .
                    '/assets/css/jquery.fancybox.min.css'
            );
        }
    }
    wp_enqueue_style(
        'font-fa',
        get_stylesheet_directory_uri() .
            '/FontAwesome/css/all.css'
    );
    wp_enqueue_style(
        'sweetalert',
        get_stylesheet_directory_uri() .
            '/assets/css/sweetalert.css'
    );
    wp_enqueue_script(
        'app',
        get_stylesheet_directory_uri() . '/assets/js/app.js',
        array('jquery'),
        time(),
        true
    );
    wp_enqueue_script(
        'account',
        get_stylesheet_directory_uri() . '/assets/js/account.js',
        array('jquery'),
        time(),
        true
    );
    wp_enqueue_script(
        'sweetalert',
        get_stylesheet_directory_uri() . '/assets/js/sweetalert.min.js',
        array('jquery'),
        time(),
        true
    );
    wp_enqueue_script(
        'withlist',
        get_stylesheet_directory_uri() . '/assets/js/withlist.js',
        array('jquery'),
        time(),
        true
    );
}
add_action('wp_enqueue_scripts', 'load_script');

function add_script_admins()
{
    if (!wp_script_is('media_custom')) {
        wp_enqueue_script('media_custom', get_stylesheet_directory_uri() . '/assets/js/wp_media.js', array(), '1.0', true);
    }
    if (!wp_style_is('core')) {
        wp_enqueue_style(
            'core',
            get_stylesheet_directory_uri() .
                '/assets/css/core.css'
        );
    }
    if (isset($_GET['page']) && $_GET['page'] == 'flash-sales-setting') {
        if (!wp_style_is('jquery-ui')) {
            wp_enqueue_style(
                'jquery-ui',
                get_stylesheet_directory_uri() .
                    '/assets/css/jquery-ui.css'
            );
            if (!wp_script_is('jquery-ui')) {
                wp_enqueue_script('jquery-ui', get_stylesheet_directory_uri() . '/assets/js/jquery-ui.js', array(), '1.0', true);
            }
        }
    }
    if (isset($_GET['page']) && $_GET['page'] == 'shop-setting') {

        if (!wp_script_is('shop_setting')) {
            wp_enqueue_script('shop_setting', get_stylesheet_directory_uri() . '/assets/js/shop_setting.js', array(), '1.0', true);
        }
    }
}
add_action('admin_enqueue_scripts', 'add_script_admins');


if (!function_exists('pre')) {
    function pre($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die;
    }
}


function add_customize_meta_boxs()
{
    add_meta_box(
        'product_video_feature',
        'Product Video',
        'callback_func_video_feature_product_meta_box',
        'product',
        'side'
    );
    add_meta_box(
        'product_flash_sale',
        'Product Flash Sale',
        'callback_func_video_flash_sale_product_meta_box',
        'product',
        'side'
    );
    add_meta_box(
        'product_descriptions_sale_off',
        'PROMOTIONS - OFFERS',
        'callback_func_promotions_sale_product_meta_box',
        'product',
    );
    add_meta_box(
        'product_detail_title_coupon',
        'Detail Title',
        'callback_func_product_detail_title_coupon',
        'shop_coupon',
    );
    add_meta_box(
        'product_detail_meta_description_coupon',
        'Short Descriptions',
        'callback_func_product_detail_meta_description_coupon',
        'shop_coupon',
    );
}
add_action('add_meta_boxes', 'add_customize_meta_boxs');

function callback_func_video_feature_product_meta_box($product)
{
    wp_enqueue_media();
    $video = get_post_meta($product->ID, 'video_feature', true);
    $video_type = get_post_meta($product->ID, 'video_type', true);
    $video_thumbnail = get_post_meta($product->ID, 'video_thumbnail', true);
    $video_thumbnail = $video_thumbnail ? wp_get_attachment_url($video_thumbnail) : "";
    // pre($video_type);

?>
    <div class="box-data">
        <div class="box-container">
            <div class="box-input <?= $video ? "" : "d-none" ?>">
                <label for="">Video</label>
                <input type="text" value="<?= $video ?>" class="" name="video_feature">
            </div>
            <div class="box-input__video-Thumbnail <?= $video ? "" : "d-none" ?>">
                <input type="text" value="<?= $video_thumbnail ?>" class="d-none" name="video_thumbnail">
                <?php
                if ($video_thumbnail) {
                ?>
                    <div class="element_item">
                        <img src="<?= $video_thumbnail ?>" style="max-width: 100%" />
                        <span class="btn-remove__item">x</span>
                    </div>
                <?php
                }
                ?>
                <button class="button btn-add__videoThumbnail">Select Video Thumbnail</button>
            </div>
        </div>
        <div class="box-select">
            <select name="video_type" class="select_featured">
                <option value="">Choose Type</option>
                <option value="url" <?= $video_type == 'url' ? "selected" : "" ?>>Video Link</option>
                <option value="upload" <?= $video_type == 'url' ? "upload" : "" ?>>Upload</option>
            </select>
        </div>
    </div>
<?php
}

function callback_func_video_flash_sale_product_meta_box($product)
{
    $isFlashSale = get_post_meta($product->ID, 'isFlashSale', true);

?>
    <div class="box-data">
        <div class="box-container">
            <label for="inputFlashSale">Bật Flash SALE</label>
            <div class="mt-10">
                <input type="checkbox" <?= $isFlashSale ? 'checked' : '' ?> name="isFlashSale" id="inputFlashSale"> Flash Sale
            </div>
        </div>
    </div>
    <?php
}
function callback_func_promotions_sale_product_meta_box($product)
{
    $content = wpautop(get_post_meta($product->ID, 'promotions_offer', true));

    $custom_editor_id = "promotions_offer";
    $custom_editor_name = "promotions_offer";
    $args = array(
        'media_buttons' => false,
        'textarea_name' => $custom_editor_name,
        'textarea_rows' => 10,
    );

    wp_editor($content, $custom_editor_id, $args);
}
function callback_func_product_detail_title_coupon($data)
{
    $meta_title = get_post_meta($data->ID, 'meta_title', true);
    echo '<input type="text" name="meta_title" style="width: 100%" value="' . $meta_title . '" id="" spellcheck="true" autocomplete="off">';
}
function callback_func_product_detail_meta_description_coupon($data)
{
    $short_description = get_post_meta($data->ID, 'short_description', true);
    echo '<input type="text" name="short_description" style="width: 100%" value="' . $short_description . '" id="" spellcheck="true" autocomplete="off">';
}
function save_data_meta_box($product_id = 0)
{
    $video = isset($_POST['video_feature']) ? esc_html($_POST['video_feature']) : 0;
    $video_type = isset($_POST['video_type']) ? esc_html($_POST['video_type']) : '';
    $video_thumbnail = isset($_POST['video_thumbnail']) ? esc_html($_POST['video_thumbnail']) : '';
    $isFlashSale = isset($_POST['isFlashSale']) ? esc_html($_POST['isFlashSale']) : '';
    $promotions_offer = isset($_POST['promotions_offer']) ? wp_kses_post($_POST['promotions_offer']) : '';


    update_post_meta($product_id, 'video_feature', $video);
    update_post_meta($product_id, 'video_type', $video_type);
    update_post_meta($product_id, 'video_thumbnail', $video_thumbnail);
    update_post_meta($product_id, 'isFlashSale', $isFlashSale);
    update_post_meta($product_id, 'promotions_offer', $promotions_offer);
}

add_action('save_post_product', 'save_data_meta_box');

function save_post_coupon_code($product_id)
{
    $meta_title = isset($_POST['meta_title']) ? esc_html($_POST['meta_title']) : '';
    $short_description = isset($_POST['short_description']) ? esc_html($_POST['short_description']) : '';
    update_post_meta($product_id, 'meta_title', $meta_title);
    update_post_meta($product_id, 'short_description', $short_description);
}
add_action('save_post_shop_coupon', 'save_post_coupon_code');

// 



/* ADD Ux Builder Product Category */
function nkd_custom_ux_builder_product_cat()
{
    add_ux_builder_shortcode('nkd_ux_product_cat', array(
        'name'      => __('Custom Product Cat', 'nkd-ux-product-cat'),
        'category'  => __('Nguyên Khôi Dev'),
        'thumbnail' => getThumbnailUXCustomer('nkd_ux_product_cat'),
        'template'  => '',
        'options' => array(
            'cat' => array(
                'type' => 'select',
                'heading' => 'Category',
                'param_name' => 'cat',
                'full_width' => true,
                'default' => '',
                'config' => array(
                    'multiple' => true,
                    'placeholder' => 'Select...',
                    'termSelect' => array(
                        'post_type' => 'product',
                        'taxonomies' => 'product_cat'
                    ),
                )
            ),
        ),
    ));
}
add_action('ux_builder_setup', 'nkd_custom_ux_builder_product_cat');


function nkd_ux_product_cat_func($atts)
{
    extract(shortcode_atts(array(
        'cat' => ''
    ), $atts));
    ob_start();
    $cat = array_map(fn ($value) => (int) trim($value), explode(",", $cat));

    if (count($cat)) {
        echo '<div class="owl-carousel block-product">';
        foreach ($cat as $_catID) {
            $term = get_term($_catID, 'product_cat');
            $thumbnail_id = get_term_meta($_catID, 'thumbnail_id', true);
            $image_url    = wp_get_attachment_url($thumbnail_id);
            $term_link = get_term_link($_catID, 'product_cat');
    ?>
            <div class="ss_item">
                <a href="<?= $term_link ?>">
                    <div class="ss_img">
                        <picture>
                            <img class="img-fluid m-auto object-contain mh-100 w-auto" src="<?= $image_url ?>" alt="season_coll_1_img.png">
                        </picture>
                    </div>
                    <div class="ss_info">
                        <div class="ss_name"><?= $term->name ?></div>
                        <span class="ss_number"><?= $term->count ?> sản phẩm</span>
                    </div>
                </a>
            </div>
        <?php
        }
        echo '</div>';
        if (!wp_style_is('carousel')) {
            wp_enqueue_style(
                'carousel',
                get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css'

            );
        }
        if (!wp_style_is('carousel-theme')) {
            wp_enqueue_style(
                'carousel-theme',
                get_stylesheet_directory_uri() . '/assets/css/owl.theme.default.min.css'

            );
        }
        if (!wp_script_is('carousel')) {
            wp_enqueue_script(
                'carousel',
                get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js',
                array('jquery'),
                '1.0',
                true
            );
        }
        if (!wp_script_is('carousel-custome')) {
            wp_enqueue_script(
                'carousel-custome',
                get_stylesheet_directory_uri() . '/assets/js/carousel_custom.js',
                array('jquery'),
                '1.0',
                true
            );
        }
    }

    return ob_get_clean();
}
add_shortcode('nkd_ux_product_cat', 'nkd_ux_product_cat_func');


function nkd_ux_builder_coupon_code_shrt()
{
    add_ux_builder_shortcode('nkd_ux_builder_coupon_code', array(
        'name' => 'Customize List Coupon Code',
        'category' => 'Nguyên Khôi Dev',
        'thumbnail' => getThumbnailUXCustomer('nkd_ux_builder_coupon_code'),
        'options' => array(
            'limit' => array(
                'type' => 'scrubfield',
                'heading' => 'Limit Coupon Show',
                'default' => 4,
                'step' => '1',
                'unit' => '',
                'min'   =>  0,
            ),
            'hide' => array(
                'type' => 'select',
                'heading' => 'Hide Expired Coupon Codes',
                'default' => 'false',
                'options' => array(
                    'false' => 'False',
                    'true' => 'True'
                )
            )
        )
    ));
}

add_action('ux_builder_setup', 'nkd_ux_builder_coupon_code_shrt');

function nkd_ux_builder_coupon_code_func($atts)
{
    extract(shortcode_atts(array(
        'limit' => 4,
        'hide' => false
    ), $atts));

    $coupon_key = require_once __DIR__ . '/config/counpons.php';

    $coupon_codes = get_posts(array(
        'posts_per_page'   => $limit,
        'orderby'          => 'name',
        'order'            => 'asc',
        'post_type'        => 'shop_coupon',
        'post_status'      => 'publish',
    ));
    ob_start();
    $coupon_codes = array_map(function ($code) {
        return new WC_Coupon($code->ID);
    }, $coupon_codes);

    if (count($coupon_codes)) {
        echo '<div class="owl-carousel coupon-block">';
        foreach ($coupon_codes as $code) {
            $exprity_time = strtotime($code->get_date_expires());
            // if ($exprity_time < time() && ! $hide) continue;
            // echo $code->get_date_expires();
            $type = $code->get_discount_type();
            $meta_title = get_post_meta($code->get_id(), 'meta_title', true);
            $short_description = get_post_meta($code->get_id(), 'short_description', true);
        ?>
            <div class="coupon-item-wrap">
                <div class="coupon_item coupon--new-style ">
                    <div class="coupon_icon pos-relative embed-responsive embed-responsive-1by1">
                        <a href="/collections/all" title="/collections/all">
                            <img class="img-fluid" src="<?= $coupon_key[$type] ?>" alt="coupon_1_img.png" width="79" height="70">
                        </a>
                    </div>
                    <div class="coupon_body">
                        <div class="coupon_head coupon--has-info">
                            <h3 class="coupon_title"><?= $meta_title ?></h3>
                            <div class="coupon_desc"><?= $short_description ?></div>
                        </div>
                        <div class="box-coupon_default">
                            <div class="coupon-code-body">
                                <div class="coupon-code-row">
                                    <span>Mã:</span> <?= strtoupper($code->get_code()) ?>
                                </div>
                                <div class="coupon-code-row">
                                    <span>HSD: <?= $code->get_date_expires()->date('d/m/Y') ?></span>
                                </div>
                            </div>
                            <?php
                            if ($exprity_time < time()) {
                                echo '<img src="' . $coupon_key['expiry'] . '" alt="outdated">';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
        echo '</div>';
        if (!wp_style_is('carousel')) {
            wp_enqueue_style(
                'carousel',
                get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css',
                array(),
                '1.0',
                'all'
            );
        }
        if (!wp_style_is('carousel-theme')) {
            wp_enqueue_style(
                'carousel-theme',
                get_stylesheet_directory_uri() . '/assets/css/owl.theme.default.min.css',
                array(),
                '1.0',
                'all'
            );
        }
        if (!wp_script_is('carousel')) {
            wp_enqueue_script(
                'carousel',
                get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js',
                array('jquery'),
                '1.0',
                true
            );
        }
        if (!wp_script_is('carousel-custome')) {
            wp_enqueue_script(
                'carousel-custome',
                get_stylesheet_directory_uri() . '/assets/js/carousel_custom.js',
                array('jquery'),
                '1.0',
                true
            );
        }
        return ob_get_clean();
    }
}
add_shortcode('nkd_ux_builder_coupon_code', 'nkd_ux_builder_coupon_code_func');
function nkd_ux_builder_product_cat_title_with_link()
{
    add_ux_builder_shortcode('nkd_ux_builder_product_cat_title_with_link', array(
        'name' => 'Customize Title',
        'category' => 'Nguyên Khôi Dev',
        'thumbnail' => getThumbnailUXCustomer('nkd_ux_builder_product_cat_title_with_link'),
        'options' => array(
            'sub_title' => array(
                'type' => 'textfield',
                'heading' => 'Sub Title',
                'default' => '',
                'auto_focus' => false
            ),
            'title' => array(
                'type' => 'textfield',
                'heading' => 'Title',
                'default' => 'Change this to anything',
                'auto_focus' => false
            ),
            'style' => array(
                'type' => 'select',
                'heading' => 'Tag Name',
                'default' => 'h2',
                'options' => array(
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6'
                )
            ),
            'link_text' => array(
                'type' => 'textfield',
                'heading' => 'Link Label',
                'default' => '',
                'auto_focus' => false
            ),
            'link_style' => array(
                'type' => 'select',
                'heading' => 'Link Style',
                'default' => 'this',
                'options' => array(
                    'this' => 'In Windows',
                    'new' => 'New Windows'
                )
            ),
            'link_type' => array(
                'type' => 'select',
                'heading' => 'Link TYPE',
                'default' => 'cat',
                'options' => array(
                    'cat' => 'Product Category',
                    'post' => 'Post Category'
                )
            ),
            'cat' => array(
                'type' => 'select',
                'heading' => 'Product Cat Link',
                'param_name' => 'cat',
                'full_width' => true,
                'conditions' => 'link_type == "cat"',
                'default' => '',
                'config' => array(
                    'multiple' => false,
                    'placeholder' => 'Select...',
                    'termSelect' => array(
                        'post_type' => 'product',
                        'taxonomies' => 'product_cat'
                    ),
                )
            ),
            'cat_post' => array(
                'type' => 'select',
                'heading' => 'Post Category Link',
                'param_name' => 'cat_post',
                'full_width' => true,
                'conditions' => 'link_type == "post"',
                'default' => '',
                'config' => array(
                    'multiple' => false,
                    'placeholder' => 'Select...',
                    'termSelect' => array(
                        'post_type' => 'post',
                        'taxonomies' => 'category'
                    ),
                )
            ),
        )
    ));
}

add_action('ux_builder_setup', 'nkd_ux_builder_product_cat_title_with_link');

function nkd_ux_builder_product_cat_title_with_link_func($atts)
{
    extract(shortcode_atts(array(
        'sub_title' => '',
        'title' => 'Change this to anything',
        'style' => 'h2',
        'link_text' => '',
        'link_style' => 'this',
        'link_type' => 'cat',
        'cat_post' => '',
        'cat' => ''
    ), $atts));
    ob_start();
    $term_type = $link_type == "cat" ? "product_cat" : "category";
    $cat_id = $link_type == "cat" ? $cat : $cat_post;
    ?>
    <div class="title_module_main heading-bar d-flex align-items-center flex-wrap justify-content-between">
        <?php
        if ($cat_id) {
            $term = get_term($cat_id, $term_type);
            $link = get_term_link($term->term_id, $term_type);
            echo '<' . $style . ' class="heading-bar__title">';
            echo '<a href="' . $link . '">';
            if ($sub_title) {
                echo '<span>' . $sub_title . '</span>';
            }
            echo $title . '</a>';
            echo '</' . $style . '>';
            if ($link_text) {

                echo '<a href="' . $link . '" ' . ($link_style == "new" ? 'target="_blank"' : '') . ' class="see-all">' . $link_text . '</a>';
            }
        } else {
            echo '<' . $style . ' class="heading-bar__title">';
            if ($sub_title) {
                echo '<span>' . $sub_title . '</span>';
            }
            echo $title;
            echo '</' . $style . '>';
        }
        ?>

    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('nkd_ux_builder_product_cat_title_with_link', 'nkd_ux_builder_product_cat_title_with_link_func');

function nkd_ux_builder_product_item_with_cat()
{
    add_ux_builder_shortcode('nkd_ux_builder_product_item_with_cat', array(
        'name' => 'Customize Product Item With Cat',
        'category' => 'Nguyên Khôi Dev',
        'thumbnail' => getThumbnailUXCustomer('nkd_ux_builder_product_item_with_cat'),
        'options' => array(
            'cat' => array(
                'type' => 'select',
                'heading' => 'Product Cat Link',
                'param_name' => 'cat',
                'full_width' => true,
                'default' => '',
                'config' => array(
                    'multiple' => true,
                    'placeholder' => 'Select...',
                    'termSelect' => array(
                        'post_type' => 'product',
                        'taxonomies' => 'product_cat'
                    ),
                )
            ),
            'limit' => array(
                'type' => 'scrubfield',
                'heading' => 'Numbers Product',
                'default' => 4,
                'step' => '1',
                'unit' => '',
                'max' => 4,
                'min'   =>  0
            )
        )
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_product_item_with_cat');

function nkd_ux_builder_product_item_with_cat_func($atts)
{

    extract(shortcode_atts(array(
        'cat' => '',
        'limit' => 4,
        'ids' => ''
    ), $atts));
    ob_start();
    if ($cat || $ids) {
        $cat = array_map(fn ($value) => (int) trim($value), explode(",", $cat));
        $products = wc_get_products(
            array(
                'limit' => $limit,
                'product_category_id' => $cat,
                'return' => 'ids',
            )
        );
        if ($ids) {
            $products = explode(",", $ids);
        }
        if (count($products)) {
            echo '<div class="row">';
            foreach ($products as $item) {
                $product = wc_get_product($item);
                if ($product) {
                    $cat = $product->get_category_ids();
                    $term = get_term($cat[0], 'product_cat');
    ?>
                    <div class="col large-3 small-12 medium-6 pb-0">
                        <div class="item_product_main">
                            <div class="product-col">
                                <div class="product-thumbnail pos-relative">
                                    <a class="image_thumb pos-relative embed-responsive embed-responsive-3by4" href="<?= get_permalink($item) ?>" title="Áo bra tập gym yoga">
                                        <img class="img-fetured" width="480" height="480" style="--image-scale: 1;" src="<?= wp_get_attachment_url($product->get_image_id()) ?>" alt="<?= get_the_title($item) ?>">
                                    </a>
                                    <div class="action-bar">
                                        <a href="<?= get_permalink($item) ?>" class="action-child btn-circle btn-views btn_view btn right-to m-0">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span class="action-name">Tùy chọn</span>
                                        </a>
                                        <a href="<?= get_permalink($item) ?>" data-handle="ao-bra-tap-gym-yoga" class="action-child xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                            <i class="fas fa-eye"></i>
                                            <span class="action-name">Xem nhanh</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="product-info has-wishlist">
                                    <span class="product-vendor"><?= $term->name ?></span>
                                    <span class="js-wishlist btn-wishlist" data-id="<?= $item ?>" data-title="<?= get_the_title($item) ?>">
                                        <i class="fas fa-heart" <?= isHasWithList($item) ? "style=\"display:block\"" : "" ?>></i>
                                        <i class="far fa-heart" <?= isHasWithList($item) ? "style=\"display:none\"" : "" ?>></i>
                                        <div class="wishlist-tooltip">
                                            <span>Bỏ yêu thích</span>
                                            <span>Yêu thích</span>
                                        </div>
                                    </span>
                                    <div class="product-name">
                                        <a class="link" href="<?= get_permalink($item) ?>" title="<?= get_the_title($item) ?>"><?= get_the_title($item) ?></a>
                                    </div>
                                    <div class="product-item-cta position-relative">
                                        <div class="price-box">
                                            <?= get_product_price($item) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            echo '</div>';
        }
    }
    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_product_item_with_cat', 'nkd_ux_builder_product_item_with_cat_func');


function nkd_ux_builder_flash_sale_coundown_ss()
{
    add_ux_builder_shortcode('nkd_ux_builder_flash_sale', array(
        'name' => 'Customize Flash Sales',
        'category' => 'Nguyên Khôi Dev',
        'thumbnail' => getThumbnailUXCustomer('nkd_ux_builder_flash_sale')
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_flash_sale_coundown_ss');

function nkd_ux_builder_flash_sale_func()
{
    ob_start();
    if (get_option('config_setting_enable') === 'on') {
        $time_start = strtotime(get_option('config_setting_time_start'));
        $time_end = strtotime(get_option('config_setting_time_end'));
        // pre($time_end);
        $products = wc_get_products(array(
            'limit' => get_option('config_setting_limit'),
            'isFlashSale' => 'on',
            'return' => 'ids'
        ));
        $action = get_option('config_setting_after_end');
        if (time() >= $time_start && (time() < $time_end || $action === 'noChange') && count($products)) {
            ?>
            <section class="section ss-flash_sale">
                <div class="row">
                    <div class="col large-12 pb-0">
                        <div class="d-flex align-items-center flex-wrap flashsale__header justify-content-between">
                            <div class="flash-sale-heading">
                                <h2 class="heading-bar__title flashsale__title ">
                                    <?= get_option('config_setting_title_section') ? get_option('config_setting_title_section') : "GIẢM SỐC 50%" ?>
                                </h2>
                            </div>
                            <div class="flashsale__countdown-wrapper">
                                <span class="flashsale__countdown-label">Kết thúc sau</span>
                                <div class="flashsale__countdown">
                                    <?= do_shortcode('[ux_countdown year="' . date('Y', $time_end) . '" month="' . date('m', $time_end) . '" day="' . date('d', $time_end) . '" time="00:00" t_week="Tuần" t_day="Ngày" t_hour="Giờ" t_min="Phút" t_sec="Giây"]') ?>
                                </div>
                            </div>
                        </div>
                        <div class="flash-sale__tab">
                            <div class="row">
                                <?php
                                foreach ($products as $item) {
                                    $product = wc_get_product($item);
                                    $terms = get_the_terms($item, 'product_cat');
                                    $term = $terms[0];
                                ?>
                                    <div class="col large-3 small-12 medium-6 pb-0">
                                        <div class="item_product_main">
                                            <div class="product-col">
                                                <div class="product-thumbnail pos-relative">
                                                    <a class="image_thumb pos-relative embed-responsive embed-responsive-3by4" href="<?= get_permalink($item) ?>" title="Áo bra tập gym yoga">
                                                        <img class="img-fetured" width="480" height="480" style="--image-scale: 1;" src="<?= wp_get_attachment_url($product->get_image_id()) ?>" alt="<?= get_the_title($item) ?>">
                                                    </a>
                                                    <div class="action-bar">
                                                        <a href="<?= get_permalink($item) ?>" class="action-child btn-circle btn-views btn_view btn right-to m-0">
                                                            <i class="fas fa-shopping-cart"></i>
                                                            <span class="action-name">Tùy chọn</span>
                                                        </a>
                                                        <a href="<?= get_permalink($item) ?>" data-handle="ao-bra-tap-gym-yoga" class="action-child xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                            <i class="fas fa-eye"></i>
                                                            <span class="action-name">Xem nhanh</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-info has-wishlist">
                                                    <span class="product-vendor"><?= $term->name ?></span>
                                                    <span class="js-wishlist btn-wishlist" data-id="<?= $item ?>" data-title="<?= get_the_title($item) ?>">
                                                        <i class="fas fa-heart"></i>
                                                        <i class="far fa-heart"></i>
                                                        <div class="wishlist-tooltip">
                                                            <span>Bỏ yêu thích</span>
                                                            <span>Yêu thích</span>
                                                        </div>
                                                    </span>
                                                    <div class="product-name">
                                                        <a class="link" href="<?= get_permalink($item) ?>" title="<?= get_the_title($item) ?>"><?= get_the_title($item) ?></a>
                                                    </div>
                                                    <div class="product-item-cta position-relative">
                                                        <div class="price-box">
                                                            <?= get_product_price($item) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
    <?php
        }
    }
    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_flash_sale', 'nkd_ux_builder_flash_sale_func');

function nkd_ux_builder_rating_container()
{
    add_ux_builder_shortcode('nkd_ux_builder_rating_container', array(
        'type' => 'container',
        'name' => 'Customer reviews',
        'category' => 'Nguyên Khôi Dev',
        'thumbnail' => '',
        'allow' => array('nkd_ux_builder_reviews'),
        'options' => array(
            'type' => array(
                'type' => 'select',
                'heading' => 'Container Style',
                'default' => 'slider',
                'options' => array(
                    'slider' => 'Slider'
                )
            ),
            'class_name' => array(
                'type' => 'textfield',
                'heading' => 'Class',
                'default' => '',
                'auto_focus' => false
            )
        )
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_rating_container');

function nkd_ux_builder_rating_container_func($atts, $content = null)
{
    extract(shortcode_atts(array(
        'type' => 'slider',
        'class_name'
    ), $atts));
    ob_start();
    ?>
    <div class="feedback_body owl-carousel btn-slide--new">
        <?= $content ?>
    </div>
<?php
    $content =  ob_get_clean();
    return do_shortcode($content);
}

add_shortcode('nkd_ux_builder_rating_container', 'nkd_ux_builder_rating_container_func');

function nkd_ux_builder_reviews()
{
    add_ux_builder_shortcode('nkd_ux_builder_reviews', array(
        'name' => 'Reviews',
        'category' => 'Nguyên Khôi Dev',
        'require' => array('nkd_ux_builder_rating_container'),
        'thumbnail' => '',
        'options' => array(
            'id' => array(
                'type' => 'image',
                'heading' => __('Image'),
                'default' => 173
            ),
            'name'             => array(
                'type'       => 'textfield',
                'heading'    => 'Name',
                'default'    => 'Change this to anything',
                'auto_focus' => false,
            ),
            'job'             => array(
                'type'       => 'textfield',
                'heading'    => 'Jobs',
                'default'    => 'Change this to anything',
                'auto_focus' => false,
            ),
            'rate'             => array(
                'type'       => 'scrubfield',
                'heading'    => 'Ratings',
                'default'    => 5,
                'min' => 1,
                'max' => 5,
                'unit' => '',
                'step' => 1
            ),
            'descriptions'             => array(
                'type'       => 'textarea',
                'heading'    => 'Message',
                'default'    => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>'
            ),
        )
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_reviews');

function nkd_ux_builder_reviews_func($atts)
{
    extract(shortcode_atts(array(
        'id' => 173,
        'name' => 'Change this to anything',
        'job' => 'Change this to anything',
        'rate' => 5,
        'descriptions' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
    ), $atts));
    ob_start();
?>
    <div class="item">
        <div class="box-reviews">
            <div class="row align-middle">
                <div class="col large-7">
                    <div class="box-image__name">
                        <div class="box-img">
                            <div class="box-bg__trans">
                                <div class="action">
                                    <span class="like-action"><i class="fas fa-thumbs-up"></i></span>
                                    Đánh giá khách hàng
                                </div>
                                <div class="action_2">
                                    Khách hàng nói gì về chúng tôi
                                </div>
                                <div class="action_3" style="background-image: url(<?= get_stylesheet_directory_uri() . '/assets/img/quotes.png' ?>);">
                                </div>
                            </div>
                            <div class="image-box">
                                <img src="<?= wp_get_attachment_url($id) ?>" alt="">
                            </div>
                        </div>
                        <div class="box-name">
                            <p class="customer-name"><?= ucwords($name) ?></p>
                            <p class="customer-job"><?= $job ?></p>
                        </div>
                    </div>
                </div>
                <div class="col large-5">
                    <div class="box-text">
                        <div class="text-content">
                            <?= $descriptions ?>
                        </div>
                        <div class="box-ratings">
                            <?= renderRatings($rate) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_reviews', 'nkd_ux_builder_reviews_func');


function nkd_custom_video_iframe()
{
    add_ux_builder_shortcode('nkd_video_custom', array(
        'name'      => __('Custom Video Iframe'),
        'category'  => __('Nguyên Khôi Dev'),
        'thumbnail' => '',
        'priority'  => 1,
        'options' => array(
            'url'             => array(
                'type'       => 'textfield',
                'heading'    => 'Video URL',
                'default'    => '',
            ),
            'id' => array(
                'type' => 'image',
                'heading' => __('Image'),
                'default' => ''
            ),
        ),
    ));
}
add_action('ux_builder_setup', 'nkd_custom_video_iframe');

function nkd_video_custom_func($atts)
{
    extract(shortcode_atts(array(
        'url' => 'https://www.youtube.com/watch?v=VA2jlmINSFY',
        'id' => 162
    ), $atts));
    ob_start();
?>
    <div class="box-video-custom">
        <div class="box-image__background">
            <img alt="Video Fancybox" class="lazy-load-active" src="<?= wp_get_attachment_url($id) ?>">
        </div>
        <div class="box-action">

            <a data-fancybox type="videos" href="<?= $url ?>" class="btn-action__icon" data-title="Video Fancybox" data-size="3200x1800">
                <i class="fas fa-play"></i>
            </a>
        </div>
    </div>
    <?php
    if (!wp_script_is('fancybox')) {
        wp_enqueue_script('fancybox', get_stylesheet_directory_uri() . '/assets/js/jquery.fancybox.min.js', array('jquery'), time(), true);
        wp_enqueue_script('fancybox_custom', get_stylesheet_directory_uri() . '/assets/js/fancybox_custom.js', array('jquery'), time(), true);
    }
    if (!wp_style_is('fancybox')) {
        wp_enqueue_style(
            'fancybox',
            get_stylesheet_directory_uri() .
                '/assets/css/jquery.fancybox.min.css'
        );
    }

    return ob_get_clean();
}
add_shortcode('nkd_video_custom', 'nkd_video_custom_func');

function nkd_ux_builder_post_with_cat()
{
    add_ux_builder_shortcode('nkd_ux_builder_post', array(
        'name' => 'Custom Post With Category',
        'category' => 'Nguyên Khôi Dev',
        'thumbnail' => '',
        'options' => array(
            'cat' => array(
                'type' => 'select',
                'heading' => 'Category',
                'param_name' => 'cat',
                'full_width' => true,
                'default' => '',
                'config' => array(
                    'multiple' => true,
                    'placeholder' => 'Select...',
                    'termSelect' => array(
                        'post_type' => 'post',
                        'taxonomies' => 'category'
                    ),
                )
            ),
        )
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_post_with_cat');

function nkd_ux_builder_post_func($atts)
{
    extract(shortcode_atts(array(
        'cat' => ''
    ), $atts));
    ob_start();
    $args = array(
        'posts_per_page' => 4,
    );
    $cat ? $args['category'] = $cat : "";

    $posts = get_posts($args);
    if (count($posts)) {
        echo '<div class="row blog-list">';
        foreach ($posts as $post) {
    ?>
            <div class="col large-3 medium-6 small-12">
                <div class="blogwp clearfix media only-title">

                    <a class="image-blog text-center" href="/blogs/news/trang-phuc-ly-tuong-cho-hoat-dong-the-thao" title="TRANG PHỤC LÝ TƯỞNG CHO HOẠT ĐỘNG THỂ THAO">
                        <img class="img-fluid" src="<?= get_the_post_thumbnail_url($post->ID) ?>" alt="<?= get_the_title($post->ID) ?>">
                    </a>

                    <div class="content_blog clearfix media-body ">
                        <h3 class="mt-0 mb-2">
                            <a class="link" href="<?= get_permalink($post->ID) ?>" title="<?= get_the_title($post->ID) ?>"><?= get_the_title($post->ID) ?></a>
                        </h3>
                        <a class="btn btn-view" href="<?= get_permalink($post->ID) ?>" title="Xem ngay">Xem ngay</a>
                    </div>
                </div>
            </div>
    <?php
        }
        echo '</div>';
    }
    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_post', 'nkd_ux_builder_post_func');

function nkd_ux_custom_copyright_element()
{
    add_ux_builder_shortcode('nkd_custom_copyright', array(
        'name'      => __('Custom Copyright'),
        'category'  => __('Nguyên Khôi Dev'),
        'thumbnail' => getThumbnailUXCustomer('nkd_custom_copyright'),
        'priority'  => 1,
    ));
}
add_action('ux_builder_setup', 'nkd_ux_custom_copyright_element');

function nkd_custom_copyright_func()
{
    ob_start();
    $blog_name = ucwords(get_bloginfo('name'));
    echo "<p>Copyright " . date("Y") . " © $blog_name - Developer by <a href=\"https://tgs.com.vn\" target=\"_blank\" rel=\"noopener noreferrer nofollow\">Thế Giới
                                Số</a></p> ";
    return ob_get_clean();
}
add_shortcode('nkd_custom_copyright', 'nkd_custom_copyright_func');

function nkd_custom_ux_builder_breadcrumbs()
{
    add_ux_builder_shortcode('nkd_custom_breadcrumbs', array(
        'name'      => __('Custom Breadcrumbs'),
        'category'  => __('Nguyên Khôi Dev'),
        'thumbnail' => getThumbnailUXCustomer('nkd_custom_breadcrumbs'),
        'priority'  => 1,
    ));
}
add_action('ux_builder_setup', 'nkd_custom_ux_builder_breadcrumbs');

function nkd_custom_breadcrumbs_func($atts)
{
    ob_start();
    echo dimox_breadcrumbs();
    return ob_get_clean();
}
add_shortcode('nkd_custom_breadcrumbs', 'nkd_custom_breadcrumbs_func');


function nkd_ux_builder_product_gallery_shrt()
{
    add_ux_builder_shortcode('nkd_ux_builder_product_gallery', array(
        'name' => 'Customize Product Gallery',
        'category' => 'Nguyên Khôi Dev - Woocommerce',
        'thumbnail' => '',
        'options' => array()
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_product_gallery_shrt');

function nkd_ux_builder_product_gallery_func($atts)
{
    global $product;
    ob_start();
    $video = get_post_meta($product->get_id(), 'video_feature', true);
    $video_type = get_post_meta($product->get_id(), 'video_type', true);
    $video_thumbnail = get_post_meta($product->get_id(), 'video_thumbnail', true);
    $video_thumbnail = $video_thumbnail ? wp_get_attachment_url($video_thumbnail) : "";
    $thumbnail_id = $product->get_image_id();
    $gallery_id = $product->get_gallery_image_ids();
    $listIMG = [];
    if ($thumbnail_id) {
        $listIMG = array_merge([(int) $thumbnail_id], $gallery_id);
    }
    ?>

    <div class="vehicle-detail-banner banner-content clearfix">
        <div class="slider slider-nav thumb-image">
            <?php
            if ($video && $video_thumbnail) {
            ?>

                <div class="thumbnail-image">
                    <div class="thumbImg">
                        <img src="<?= $video_thumbnail ?>" alt="slider-img">
                    </div>
                </div>
            <?php
            }
            foreach ($listIMG as $_id) {
            ?>
                <div class="thumbnail-image">
                    <div class="thumbImg">
                        <img src="<?= wp_get_attachment_url($_id) ?>" alt="slider-img">
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="banner-slider">
            <div class="slider slider-for">
                <?php
                if ($video && $video_thumbnail) {
                ?>
                    <div class="slider-banner-image">
                        <div class="box-video-custom">
                            <div class="box-image__background">
                                <img decoding="async" alt="Video Fancybox" class="lazy-load-active" src="<?= $video_thumbnail ?>">
                            </div>
                            <div class="box-action">

                                <a data-fancybox="" data-target="<?= $video_type ?>" type="videos" href="<?= $video ?>" class="btn-action__icon" data-title="Video Fancybox" data-size="3200x1800">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                foreach ($listIMG as $_id) {
                ?>
                    <div class="slider-banner-image">
                        <img src="<?= wp_get_attachment_url($_id) ?>" alt="Car-Image">
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

    </div>


    <?php
    if (!wp_style_is('slick')) {
        wp_enqueue_style(
            'slick',
            get_stylesheet_directory_uri() . '/assets/css/slick.css',
            array(),
            '1.0',
            'all'
        );
    }

    if (!wp_script_is('slick')) {
        wp_enqueue_script(
            'slick',
            get_stylesheet_directory_uri() . '/assets/js/slick.min.js',
            array('jquery'),
            '1.0',
            true
        );
    }
    if (!wp_script_is('product')) {
        wp_enqueue_script(
            'carousel-custome',
            get_stylesheet_directory_uri() . '/assets/js/product.js',
            array('jquery'),
            '1.0',
            true
        );
    }
    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_product_gallery', 'nkd_ux_builder_product_gallery_func');

function nkd_ux_builder_customize_sku()
{
    add_ux_builder_shortcode('nkd_ux_builder_customize_sku', array(
        'name' => 'Customize Product SKU',
        'category' => 'Nguyên Khôi Dev - Woocommerce',
        'thumbnail' => '',
        'options' => array()
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_customize_sku');

function nkd_ux_builder_customize_sku_func()
{
    ob_start();
    global $product;
    ?>
    <div class="group-status">
        <span class="first_status product_sku">
            Mã sản phẩm:
            <span class="status_name product-sku" itemprop="sku">
                <?= $product->get_sku() ? $product->get_sku() : "Đang cập nhật" ?>
            </span>
        </span>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_customize_sku', 'nkd_ux_builder_customize_sku_func');

function nkd_ux_builder_customize_flash_sale()
{
    add_ux_builder_shortcode('nkd_ux_builder_customize_flash_sale_detail', array(
        'name' => 'Customize Product Flash Sale Detail',
        'category' => 'Nguyên Khôi Dev - Woocommerce',
        'thumbnail' => '',
        'options' => array()
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_customize_flash_sale');

function nkd_ux_builder_customize_flash_sale_detail_func()
{
    ob_start();
    global $product;
    $isFlashSale = get_post_meta($product->get_id(), 'isFlashSale', true);

    if ($isFlashSale == 'on') {
        $time_start = strtotime(get_option('config_setting_time_start'));
        $time_end = strtotime(get_option('config_setting_time_end'));
        if (time() >= $time_start && time() < $time_end) {
    ?>
            <div class="product-flash__sale">
                <div class="d-flex align-items-center flex-wrap flashsale__header justify-content-between">
                    <div class="flash-sale-heading">
                        <h5 class="heading-bar__title flashsale__title ">
                            <?= get_option('config_setting_title_section') ? get_option('config_setting_title_section') : "GIẢM SỐC 50%" ?>
                        </h5>
                    </div>
                    <div class="flashsale__countdown-wrapper">
                        <span class="flashsale__countdown-label">Kết thúc sau</span>
                        <div class="flashsale__countdown">
                            <?= do_shortcode('[ux_countdown year="' . date('Y', $time_end) . '" month="' . date('m', $time_end) . '" day="' . date('d', $time_end) . '" time="00:00" t_week="Tuần" t_day="Ngày" t_hour="Giờ" t_min="Phút" t_sec="Giây"]') ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_customize_flash_sale_detail', 'nkd_ux_builder_customize_flash_sale_detail_func');


function nkd_ux_builder_product_price()
{
    add_ux_builder_shortcode('nkd_ux_builder_customize_product_detail_price', array(
        'name' => 'Customize Product Price',
        'category' => 'Nguyên Khôi Dev - Woocommerce',
        'thumbnail' => '',
        'options' => array()
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_product_price');

function nkd_ux_builder_customize_product_detail_price_func($atts)
{
    global $product;
    ob_start();
    $curentSymbal = get_woocommerce_currency_symbol();
    $sale_price = $product->get_sale_price();
    $price =  $product->get_regular_price() ? number_format($product->get_regular_price(), 0) . $curentSymbal : "Liên hệ";

    if ($sale_price) {
        $old_price = $price;
        $price =  number_format($sale_price, 0) . $curentSymbal;
        $sale_percent = ($product->get_sale_price() / $product->get_regular_price()) * 100;
        $sale_percent .= '%';

        $fixAmountSale = number_format($product->get_regular_price() - $product->get_sale_price(), 0) . $curentSymbal;
    }
    ?>
    <div class="price-box">
        <span class="special-price">
            <span class="price product-price"><?= $price ?></span>
        </span>
        <span class="old-price">
            <del class="price product-price-old sale"><?= isset($old_price) ? $old_price : "" ?></del>
        </span>
        <div class="label_product"><?= isset($sale_percent) ? $sale_percent : "" ?></div>
        <?php
        if (isset($fixAmountSale)) {
            echo '<div class="save-price">(Tiết kiệm <span>' . $fixAmountSale . '</span>)</div>';
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('nkd_ux_builder_customize_product_detail_price', 'nkd_ux_builder_customize_product_detail_price_func');


function nkd_ux_builder_product_short_descriptions()
{
    add_ux_builder_shortcode('nkd_ux_builder_product_short_descriptions', array(
        'name' => 'Customize Product Descriptions',
        'category' => 'Nguyên Khôi Dev - Woocommerce',
        'thumbnail' => '',
        'options' => array()
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_product_short_descriptions');

function nkd_ux_builder_product_short_descriptions_func($atts)
{
    ob_start();
    global $product;

    $content = wpautop(get_post_meta($product->get_id(), 'promotions_offer', true));
    if ($content) {
    ?>
        <div class="product-promotion rounded-sm" id="ega-salebox">
            <h3 class="product-promotion__heading rounded-sm d-inline-flex align-items-center">
                <img src="<?= get_stylesheet_directory_uri() . '/assets/img/icon-product-promotion.webp' ?>" alt="KHUYẾN MÃI - ƯU ĐÃI" width="22" height="22" class="mr-2">
                KHUYẾN MÃI - ƯU ĐÃI
            </h3>
            <?= $content ?>
        </div>
    <?php
    }
    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_product_short_descriptions', 'nkd_ux_builder_product_short_descriptions_func');

function nkd_ux_builder_product_coupon_detail()
{
    add_ux_builder_shortcode('nkd_ux_builder_product_coupon_detail', array(
        'name' => 'Customize Product Coupon Detail',
        'category' => 'Nguyên Khôi Dev - Woocommerce',
        'thumbnail' => '',
        'options' => array()
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_product_coupon_detail');

function nkd_ux_builder_product_coupon_detail_func()
{
    $coupon_key = require_once __DIR__ . '/config/counpons.php';

    $coupon_codes = get_posts(array(
        'posts_per_page'   => 4,
        'orderby'          => 'name',
        'order'            => 'asc',
        'post_type'        => 'shop_coupon',
        'post_status'      => 'publish',
    ));
    ob_start();
    $coupon_codes = array_map(function ($code) {
        return new WC_Coupon($code->ID);
    }, $coupon_codes);

    if (get_option('config_setting_shop_coupon_enable_product_detail') == 'on' && count($coupon_codes)) {
    ?>
        <div class="product-coupon__wrapper my-3">
            <p class="d-block mb-2"><strong>Mã giảm giá</strong></p>
            <div class="product-coupons coupon-toggle-btn">
                <?php
                foreach ($coupon_codes as $code) {
                ?>
                    <div class="coupon_item lite">
                        <div class="coupon_content">
                            <?= strtoupper($code->get_code()) ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    }
    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_product_coupon_detail', 'nkd_ux_builder_product_coupon_detail_func');

function nkd_ux_builder_product_related_shrt()
{
    add_ux_builder_shortcode('nkd_ux_builder_product_related', array(
        'name' => 'Customize Product Related',
        'category' => 'Nguyên Khôi Dev - Woocommerce',
        'thumbnail' => '',
        'options' => array()
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_product_related_shrt');

function nkd_ux_builder_product_related_func()
{
    ob_start();
    global $product;
    $cat = $product->get_category_ids()[0];
    // pre($cat);
    echo '[nkd_ux_builder_product_item_with_cat limit="4" cat="' . $cat . '"]';

    $content = ob_get_clean();
    return do_shortcode($content);
}

add_shortcode('nkd_ux_builder_product_related', 'nkd_ux_builder_product_related_func');

function nkd_ux_builder_product_lastedVisted_shrt()
{
    add_ux_builder_shortcode('nkd_ux_builder_product_viewed', array(
        'name' => 'Customize Product Viewed ',
        'category' => 'Nguyên Khôi Dev - Woocommerce',
        'thumbnail' => '',
        'options' => array()
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_product_lastedVisted_shrt');

function nkd_ux_builder_product_viewed_func()
{
    ob_start();

    $viewed_products = !empty($_COOKIE['woocommerce_recently_viewed']) ? (array) explode('|', wp_unslash($_COOKIE['woocommerce_recently_viewed'])) : array();
    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));
    if ($viewed_products) {
        echo do_shortcode('[nkd_ux_builder_product_item_with_cat limit="4" ids="' . implode(",", $viewed_products) . '"]');
    } else {
        echo "<p>Không có sản phẩm đã xem</p>";
    }

    return ob_get_clean();
}

add_shortcode('nkd_ux_builder_product_viewed', 'nkd_ux_builder_product_viewed_func');

function nkd_ux_builder_product_withlist_shrt()
{
    add_ux_builder_shortcode('nkd_ux_builder_product_withlist', array(
        'name' => 'Customize Product Withlist ',
        'category' => 'Nguyên Khôi Dev - Woocommerce',
        'thumbnail' => '',
        'options' => array()
    ));
}
add_action('ux_builder_setup', 'nkd_ux_builder_product_withlist_shrt');

function nkd_ux_builder_product_withlist_func()
{
    ob_start();

    $viewed_products = !empty($_COOKIE['woocommerce_recently_wishlisted']) ? (array) explode('|', wp_unslash($_COOKIE['woocommerce_recently_wishlisted'])) : array();
    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));
    if ($viewed_products) {
        echo do_shortcode('[nkd_ux_builder_product_item_with_cat limit="4" ids="' . implode(",", $viewed_products) . '"]');
    } else {
        echo "<p>Không có sản phẩm yêu thích</p>";
    }

    return ob_get_clean();
}
add_shortcode('nkd_ux_builder_product_withlist', 'nkd_ux_builder_product_withlist_func');


/* ======================================= */

function getThumbnailUXCustomer($name = '')
{
    return get_stylesheet_directory_uri() . "/thumbnail/$name.png";
}


function get_product_price($product_id)
{
    $product = wc_get_product($product_id);
    $curentSymbal = get_woocommerce_currency_symbol();
    $sale_price = $product->get_sale_price();
    $price =  $product->get_regular_price() ? number_format($product->get_regular_price(), 0) . $curentSymbal : "Liên hệ";

    if ($sale_price) {
        $old_price = $price;
        $price =  number_format($sale_price, 0) . $curentSymbal;
        $sale_percent = ($product->get_sale_price() / $product->get_regular_price()) * 100;
        $sale_percent .= '%';
    }
    $html = '<span class="price">' . $price . '</span>';
    if (isset($old_price)) {
        $html .= ' <span class="compare-price">' . $old_price . '</span>
                                        <div class="label_product" style="display: inline-block">
                                            <div class="label_wrapper">
                                                -' . $sale_percent . '
                                            </div>
                                        </div>';
    }

    return $html;
}


function add_menu_item()
{
    add_menu_page(
        'Flash SALES',
        'Flash SALES',
        'administrator',
        'flash-sales-setting',
        'callback_func_flash_sales_settings',
        'dashicons-clock',
        '5'
    );
    add_menu_page(
        'Shop Settings',
        'Shop Settings',
        'administrator',
        'shop-setting',
        'callback_func_shop_settings',
        'dashicons-cart',
        '6'
    );
}
add_action('init', 'add_menu_item');

function callback_func_flash_sales_settings()
{
    ?>
    <div class="wrap nkd-contact">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    Flash Sales Settings
                </h3>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['settings-updated'])) { ?>
                    <div id="message" class="updated">
                        <p><strong><?php _e('Settings saved.') ?></strong></p>
                    </div>
                <?php } ?>
                <?php
                ?>
                <div class="row">
                    <div class="col small-8">
                        <form method="post" action="options.php">
                            <?php settings_fields('nkd_settings_options_group'); ?>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        Enable/Disable
                                    </th>
                                    <td>
                                        <input type="checkbox" name="config_setting_enable" <?= get_option('config_setting_enable') == "on" ? "checked" : "" ?> id="">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Product SALE Limit show
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= get_option('config_setting_limit') ?>" name="config_setting_limit">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Product SALE SECTION TITLE
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= get_option('config_setting_title_section') ? get_option('config_setting_title_section') : "" ?>" name="config_setting_title_section">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Set Time Start Flash Sale
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= get_option('config_setting_time_start') ?>" name="config_setting_time_start" id="datepicker">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Set Time End Flash Sale
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" value="<?= get_option('config_setting_time_end') ?>" name="config_setting_time_end" id="datepicker_2">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Action After Flash END
                                    </th>
                                    <td>
                                        <select name="config_setting_postion" class="form-control">
                                            <option value="hidden" <?= get_option('config_setting_after_end') == 'hidden' ? 'selected' : '' ?>>
                                                HIDE</option>
                                            <option value="noChange" <?= get_option('config_setting_after_end') == 'noChange' ? 'selected' : '' ?>>
                                                No Action</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        SHORT CODE
                                    </th>
                                    <td>
                                        [nkd_ux_builder_flash_sale]
                                    </td>
                                </tr>
                            </table>
                            <hr>
                            <?php submit_button(); ?>
                        </form>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(function() {
            jQuery("#datepicker").datepicker();
            jQuery("#datepicker_2").datepicker();
        });
    </script>
<?php
}

function callback_func_shop_settings()
{
    wp_enqueue_media();
?>
    <div class="wrap nkd-contact">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    Shop Pages Settings
                </h3>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['settings-updated'])) { ?>
                    <div id="message" class="updated">
                        <p><strong><?php _e('Settings saved.') ?></strong></p>
                    </div>
                <?php } ?>
                <?php
                ?>
                <div class="row">
                    <div class="col small-8">
                        <form method="post" action="options.php">
                            <?php settings_fields('nkd_settings_shop_options_group'); ?>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        Enable/Disable Shop Banner
                                    </th>
                                    <td>
                                        <input type="checkbox" name="config_setting_shop_enable_banner" <?= get_option('config_setting_shop_enable_banner') == "on" ? "checked" : "" ?> id="">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Shop Banner
                                    </th>
                                    <td>
                                        <input type="hidden" class="form-control" value="<?= get_option('config_setting_shop_banner_link') ?>" name="config_setting_shop_banner_link">
                                        <?php
                                        if (get_option('config_setting_shop_banner_link')) {
                                            echo '<img src="' . wp_get_attachment_url(get_option('config_setting_shop_banner_link')) . '" alt="" style="width: 300px; display: block;margin-bottom: 20px;"/>';
                                        }
                                        ?>
                                        <button type="button" class="button button-primary btn-select__banner_link">
                                            Select IMG
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Enable/Disable Shop Coupon
                                    </th>
                                    <td>
                                        <input type="checkbox" name="config_setting_shop_coupon_enable" <?= get_option('config_setting_shop_coupon_enable') == "on" ? "checked" : "" ?> id="">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Enable/Disable Product Detail Coupon
                                    </th>
                                    <td>
                                        <input type="checkbox" name="config_setting_shop_coupon_enable_product_detail" <?= get_option('config_setting_shop_coupon_enable_product_detail') == "on" ? "checked" : "" ?> id="">
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <th scope="row">
                                        Enable/Disable Filter Price
                                    </th>
                                    <td>
                                        <input type="checkbox" name="config_setting_shop_enable_filter_price" <?= get_option('config_setting_shop_enable_filter_price') == "on" ? "checked" : "" ?> id="">
                                    </td>
                                </tr> -->

                                <?php
                                if (get_option('config_setting_shop_enable_filter_price') == "on") {
                                ?>
                                    <tr class="filter__label">
                                        <th scope="row">
                                            Filter Price Label Name
                                        </th>
                                        <td>
                                            <input type="text" class="form-control" value="<?= get_option('config_setting_shop_filter_price_label') ?>" name="config_setting_shop_filter_price_label">
                                        </td>
                                    </tr>
                                <?php
                                }
                                if (get_option('config_setting_shop_filter_price_data')) {
                                    $filterData = get_option('config_setting_shop_filter_price_data');

                                ?>

                                    <tr data-key="<?= count($filterData) ?>" class="append-filter__data <?= get_option('config_setting_shop_enable_filter_price') == "on" ? "" : "d-none" ?> ">

                                        <th scope="row">
                                            List Data Filter
                                        </th>
                                        <td>
                                            <table>
                                                <tbody>
                                                    <?php
                                                    if (count($filterData)) {
                                                        foreach ($filterData as $key => $data) {
                                                    ?>
                                                            <tr>
                                                                <td>
                                                                    <label>MIN</label>
                                                                    <input type="number" name="config_setting_shop_filter_price_data[<?= $key ?>][min]" value="<?= $data['min'] ?>">
                                                                </td>
                                                                <td>
                                                                    <label>MAX</label>
                                                                    <input type="number" name="config_setting_shop_filter_price_data[<?= $key ?>][max]" value="<?= $data['max'] ?>">
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="button button-primary btn-remove_data">
                                                                        Remove this data
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <button type="button" class="button button-primary btn-add_filter_price_data">
                                                Add Filter Data
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                if (get_option('config_setting_shop_enable_filter_price') == "on") {
                                ?>
                                    <tr class="filter__shortcode">
                                        <th scope="row">
                                            SHORT CODE
                                        </th>
                                        <td>
                                            [nkd_ux_builder_price_filter_data]
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <th scope="row">
                                        Enable/Disable Delivery Policy
                                    </th>
                                    <td>
                                        <input type="checkbox" name="config_setting_shop_enable_shipping" <?= get_option('config_setting_shop_enable_shipping') == "on" ? "checked" : "" ?> id="">
                                    </td>
                                </tr>

                                <tr class="shipping_content <?= get_option('config_setting_shop_enable_shipping') == "on" ? "" : "d-none" ?>">
                                    <th scope="row">
                                        Delivery Policy Content
                                    </th>
                                    <td>
                                        <?php
                                        $content = wpautop(get_option('config_setting_shop_shipping_content'));
                                        $custom_editor_id = "config_setting_shop_shipping_content";
                                        $custom_editor_name = "config_setting_shop_shipping_content";
                                        $args = array(
                                            'media_buttons' => false,
                                            'textarea_name' => $custom_editor_name,
                                            'textarea_rows' => 10,
                                        );

                                        wp_editor($content, $custom_editor_id, $args);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        Enable/Disable Exchange Policy
                                    </th>
                                    <td>
                                        <input type="checkbox" name="config_setting_shop_enable_exchange" <?= get_option('config_setting_shop_enable_exchange') == "on" ? "checked" : "" ?> id="">
                                    </td>
                                </tr>
                                <tr class="exchange_content <?= get_option('config_setting_shop_enable_exchange') == "on" ? "" : "d-none" ?>">
                                    <th scope="row">
                                        Delivery Policy Content
                                    </th>
                                    <td>
                                        <?php
                                        $content = wpautop(get_option('config_setting_shop_exchange_content'));
                                        $custom_editor_id = "config_setting_shop_exchange_content";
                                        $custom_editor_name = "config_setting_shop_exchange_content";
                                        $args = array(
                                            'media_buttons' => false,
                                            'textarea_name' => $custom_editor_name,
                                            'textarea_rows' => 10,
                                        );

                                        wp_editor($content, $custom_editor_id, $args);
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                            <?php submit_button(); ?>
                        </form>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
<?php
}

// register Setting
if (!function_exists('nkd_register_setting')) {
    function nkd_register_setting()
    {
        //Setting Form
        register_setting('nkd_settings_options_group', 'config_setting_enable');
        register_setting('nkd_settings_options_group', 'config_setting_limit');
        register_setting('nkd_settings_options_group', 'config_setting_title_section');
        register_setting('nkd_settings_options_group', 'config_setting_time_start');
        register_setting('nkd_settings_options_group', 'config_setting_time_end');
        register_setting('nkd_settings_options_group', 'config_setting_after_end');

        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_enable_banner');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_banner_link');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_coupon_enable');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_coupon_enable_product_detail');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_enable_filter_price');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_filter_price_label');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_filter_price_data');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_enable_shipping');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_shipping_content');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_enable_exchange');
        register_setting('nkd_settings_shop_options_group', 'config_setting_shop_exchange_content');
    }
}
add_action('admin_init', 'nkd_register_setting');



function handling_custom_meta_query_keys($wp_query_args, $query_vars, $data_store_cpt)
{
    $meta_key = 'isFlashSale'; // The custom meta_key

    if (!empty($query_vars[$meta_key])) {
        $wp_query_args['meta_query'][] = array(
            'key'     => $meta_key,
            'value'   => 'on',
            'compare' => '=', // <=== Here you can set other comparison arguments
        );
    }
    return $wp_query_args;
}
add_filter('woocommerce_product_data_store_cpt_get_products_query', 'handling_custom_meta_query_keys', 10, 3);


function renderRatings($rate = 5)
{
    $html = '<ul class="list-star">';
    switch ($rate) {
        case 5:
            $html .= '<li><i class="fas fa-star"></i></li>
            <li><i class="fas fa-star"></i></li>
            <li><i class="fas fa-star"></i></li>
            <li><i class="fas fa-star"></i></li>
            <li><i class="fas fa-star"></i></li></ul>';
            break;
        case 4:
            $html .= '<li><i class="fas fa-star"></i></li>
                <li><i class="fas fa-star"></i></li>
                <li><i class="fas fa-star"></i></li>
                <li><i class="fas fa-star"></i></li>
                <li><i class="far fa-star"></i></li></ul>';
            break;
        case 3:
            $html .= '<li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                     <li><i class="far fa-star"></i></li>
                    <li><i class="far fa-star"></i></li></ul>';
            break;
        case 2:
            $html .= '<li><i class="fas fa-star"></i></li>
                        <li><i class="fas fa-star"></i></li>
                        <li><i class="far fa-star"></i></li>
                         <li><i class="far fa-star"></i></li>
                        <li><i class="far fa-star"></i></li></ul>';
            break;
        case 1:
            $html .= '<li><i class="fas fa-star"></i></li>
                            <li><i class="far fa-star"></i></li>
                            <li><i class="far fa-star"></i></li>
                             <li><i class="far fa-star"></i></li>
                            <li><i class="far fa-star"></i></li></ul>';
            break;
        default:
            $html .= '<li><i class="far fa-star"></i></li>
                                <li><i class="far fa-star"></i></li>
                                <li><i class="far fa-star"></i></li>
                                 <li><i class="far fa-star"></i></li>
                                <li><i class="far fa-star"></i></li></ul>';
            break;
    }
    return $html;
}

/* Create Buy Now Button dynamically after Add To Cart button */
function add_content_after_addtocart()
{

    $current_product_id = get_the_ID();

    $product = wc_get_product($current_product_id);

    $checkout_url = wc_get_checkout_url();

    if ($product->is_type('simple')) {
        echo '<a href="' . $checkout_url . '?add-to-cart=' . $current_product_id . '" class="buy-now button">Mua ngay</a>';
    }
}
add_action('woocommerce_after_add_to_cart_button', 'add_content_after_addtocart');


/**
 * Breadcrumb
 */
function dimox_breadcrumbs()
{

    $delimiter = '»';
    $home = 'Trang chủ'; // chữ thay thế cho phần 'Home' link
    $before = '<span class="current">'; // thẻ html đằng trước mỗi link
    $after = '</span>'; // thẻ đằng sau mỗi link

    if (!is_home() && !is_front_page() || is_paged()) {
        echo '<div id="crumbs">';
        global $post;
        $homeLink = get_bloginfo('url');
        echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
        if (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo (get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
            echo $before . single_cat_title('', false) . $after;
        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
                echo $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo $before . get_the_title() . $after;
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
        } elseif (is_page() && !$post->post_parent) {
            echo $before . get_the_title() . $after;
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '"> ' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
        } elseif (is_search()) {
            echo $before . 'Search results for "' . get_search_query() . '"' . $after;
        } elseif (is_tag()) {
            echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_author()) {
            global $author;
            echo $before . 'Articles posted by ' . $author->display_name . $after;
        } elseif (is_404()) {
            echo $before . 'Error 404' . $after;
        }
        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' ( ';
            echo " » ";
            echo __('Page') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
        }
        echo '</div>';
    }
} // end dimox_breadcrumbs()






function woo_custom_product_tabs($tabs)
{

    unset($tabs['reviews']);

    $tabs['description']['title'] = 'Mô tả sản phẩm';

    if (get_option('config_setting_shop_enable_shipping') == 'on') {

        $tabs['shipping_tab'] = array(
            'title'     => __('Chính sách giao hàng', 'woocommerce'),
            'priority'  => 100,
            'callback'  => 'callback_shipping_tab_content'
        );
    }

    if (get_option('config_setting_shop_enable_exchange') == 'on') {

        // Adds the qty pricing  tab
        $tabs['exchange_tab'] = array(
            'title'     => __('Chính sách đổi trả', 'woocommerce'),
            'priority'  => 110,
            'callback'  => 'callback_exchange_tab_content'
        );
    }

    return $tabs;
}

add_filter('woocommerce_product_tabs', 'woo_custom_product_tabs');



// New Tab contents

function callback_shipping_tab_content()
{

    echo apply_filters('the_content', wpautop(get_option('config_setting_shop_shipping_content')));
}
function callback_exchange_tab_content()
{
    echo apply_filters('the_content', wpautop(get_option('config_setting_shop_exchange_content')));
}



// Prodcut Lasted View

function isures_set_user_visited_product_cookie()
{
    if (!is_singular('product')) {
        return;
    }

    global $post;

    if (empty($_COOKIE['woocommerce_recently_viewed'])) {
        $viewed_products = array();
    } else {
        $viewed_products = wp_parse_id_list((array) explode('|', wp_unslash($_COOKIE['woocommerce_recently_viewed'])));
    }

    $keys = array_flip($viewed_products);

    if (isset($keys[$post->ID])) {
        unset($viewed_products[$keys[$post->ID]]);
    }

    $viewed_products[] = $post->ID;

    if (count($viewed_products) > 22) {
        array_shift($viewed_products);
    }

    wc_setcookie('woocommerce_recently_viewed', implode('|', $viewed_products));
}
add_action('wp', 'isures_set_user_visited_product_cookie');




function twooc_extra_register_fields()
{
?>
    <p class="form-row form-row-first">
        <label for="reg_billing_first_name"><?php _e('First name', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>" />
    </p>
    <p class="form-row form-row-last">
        <label for="reg_billing_last_name"><?php _e('Last name', 'woocommerce'); ?><span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e($_POST['billing_last_name']); ?>" />
    </p>
    <p class="form-row form-row-wide">
        <label for="reg_billing_phone"><?php _e('Phone', 'woocommerce'); ?></label>
        <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e($_POST['billing_phone']); ?>" />
    </p>
    <div class="clear"></div>
    <?php
}

add_action('woocommerce_register_form_start', 'twooc_extra_register_fields');

/**
 * Below code save extra fields.
 */
function twooc_save_extra_register_fields($customer_id)
{
    if (isset($_POST['billing_phone'])) {
        // Phone input filed which is used in WooCommerce
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
    if (isset($_POST['billing_first_name'])) {
        //First name field which is by default
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
        // First name field which is used in WooCommerce
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    }
    if (isset($_POST['billing_last_name'])) {
        // Last name field which is by default
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
        // Last name field which is used in WooCommerce
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
    }
}
add_action('woocommerce_created_customer', 'twooc_save_extra_register_fields');


// Form đăng ký woocommecer
function show_registration_form()
{
    if (!is_user_logged_in()) {
        ob_start();
        require __DIR__ . "/woocommerce/myaccount/login_layout.php";
        return ob_get_clean();
    } else {
        wp_redirect(home_url('/tai-khoan'));
    }
}


add_shortcode('woocommerce_registration_form', 'show_registration_form');

// Form reset woocommecer
function show_reset_form()
{
    if (!is_user_logged_in()) {
        ob_start();
        require __DIR__ . "/woocommerce/myaccount/reset_layout.php";
        return ob_get_clean();
    } else {
        wp_redirect(home_url('/tai-khoan'));
    }
}


add_shortcode('woocommerce_reset_form', 'show_reset_form');



function wc_custom_user_redirect($redirect, $user)
{
    // Get the first of all the roles assigned to the user
    $role = $user->roles[0];

    $myaccount = get_permalink(wc_get_page_id('myaccount'));

    $redirect = $myaccount;

    return $redirect;
}
add_filter('woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2);




function ajax_register_account()
{
    global $wpdb;
    $table = $wpdb->prefix . "users";
    $table_meta = $wpdb->prefix . "usermeta";

    $_nonce_field = isset($_POST['_nonce']) ? esc_attr($_POST['_nonce']) : "";
    $billing_first_name = isset($_POST['billing_first_name']) ? esc_attr($_POST['billing_first_name']) : "";
    $billing_last_name = isset($_POST['billing_last_name']) ? esc_attr($_POST['billing_last_name']) : "";
    // $billing_phone = isset($_POST['billing_phone']) ? esc_attr($_POST['billing_phone']) : "";

    $email = isset($_POST['billing_email']) ? esc_attr($_POST['billing_email']) : "";
    $password = isset($_POST['password']) ? esc_attr($_POST['password']) : "";

    $user_gender = isset($_POST['user_gender']) ? esc_attr($_POST['user_gender']) : "";
    $billing_birthday = isset($_POST['reg_billing_birth_date']) ? esc_attr($_POST['reg_billing_birth_date']) : "";
    // $billing_email = isset($_POST['billing_email']) ? esc_attr($_POST['billing_email']) : "";

    if (!wp_verify_nonce($_nonce_field, 'create_new_account')) {
        die(json_encode(['error' => true, 'message' => 'Yêu cầu không hợp lệ']));
    }

    if (!$billing_first_name || !$billing_last_name || !$email || !$password) {
        die(json_encode(['error' => true, 'message' => 'Yêu cầu không hợp lệ']));
    }

    $results_email = $wpdb->get_var($wpdb->prepare("SELECT * FROM $table WHERE `user_email` = %s", $email));

    if ($results_email) {
        die(json_encode(['error' => true, 'message' => 'Email đã đã được sử dụng']));
    }

    // $results_phone = $wpdb->get_var($wpdb->prepare("SELECT * FROM $table_meta WHERE `meta_value` = %s", $billing_phone));
    // if ($results_phone) {
    //   die(json_encode(['error' => true, 'message' => 'Số điện thoại đã đã được sử dụng']));
    // }


    $user_id = wp_create_user(substr($email, 0, strpos($email, '@')), $password, $email);
    // echo $user_id;

    if (!is_wp_error($user_id)) {
        update_user_meta($user_id, 'nickname', substr($email, 0, strpos($email, '@')));
        update_user_meta($user_id, 'first_name', substr($email, 0, strpos($email, '@')));
        update_user_meta($user_id, 'last_name', '');
        update_user_meta($user_id, 'description', '');
        update_user_meta($user_id, 'rich_editing', true);
        update_user_meta($user_id, 'syntax_highlighting', true);
        update_user_meta($user_id, 'comment_shortcuts', false);
        update_user_meta($user_id, 'admin_color', 'fresh');
        update_user_meta($user_id, 'use_ssl', false);
        update_user_meta($user_id, 'show_admin_bar_front', true);
        update_user_meta($user_id, 'locale', '');
        update_user_meta($user_id, $wpdb->prefix . 'capabilities', 'a:1:{s:8:"customer";b:1;}');
        update_user_meta($user_id, $wpdb->prefix . 'user_level', 0);
        update_user_meta($user_id, 'dismissed_wp_pointers', '');
        update_user_meta($user_id, 'billing_first_name', substr($email, 0, strpos($email, '@')));
        update_user_meta($user_id, 'billing_last_name', '');
        update_user_meta($user_id, 'billing_company', '');
        update_user_meta($user_id, 'billing_address_1', '');
        update_user_meta($user_id, 'billing_address_2', '');
        update_user_meta($user_id, 'billing_city', '');
        update_user_meta($user_id, 'billing_postcode', '');
        update_user_meta($user_id, 'billing_country', 'VN');
        update_user_meta($user_id, 'billing_state', '');
        // update_user_meta($user_id, 'billing_phone', $billing_phone);
        update_user_meta($user_id, 'billing_email', $email);
        update_user_meta($user_id, 'shipping_first_name', substr($email, 0, strpos($email, '@')));
        update_user_meta($user_id, 'shipping_last_name', '');
        update_user_meta($user_id, 'shipping_company', '');
        update_user_meta($user_id, 'shipping_address_1', '');
        update_user_meta($user_id, 'shipping_address_2', '');
        update_user_meta($user_id, 'shipping_city', '');
        update_user_meta($user_id, 'shipping_postcode', '');
        update_user_meta($user_id, 'shipping_country', '');
        update_user_meta($user_id, 'shipping_state', '');
        update_user_meta($user_id, 'shipping_phone', '');
        update_user_meta($user_id, 'birth_day', $billing_birthday);
        update_user_meta($user_id, 'gender', $user_gender);

        die(json_encode(['error' => false, 'message' => 'Đăng ký tài khoản thành công!']));
    }
    // die(json_encode(['data' => $password]));
    die(json_encode(['error' => true, 'message' => $user_id->get_error_message()]));
}
add_action('wp_ajax_register_account', 'ajax_register_account');
add_action('wp_ajax_nopriv_register_account', 'ajax_register_account');

function ajax_wishlist_product()
{
    $product_id = isset($_POST['id']) ? esc_html($_POST['id']) : "";

    if (!$product_id) {
        wp_send_json_error("Yêu cầu không hợp lệ");
    }
    if (empty($_COOKIE['woocommerce_recently_wishlisted'])) {
        $viewed_products = array();
    } else {
        $viewed_products = wp_parse_id_list((array) explode('|', wp_unslash($_COOKIE['woocommerce_recently_wishlisted'])));
    }

    $keys = array_flip($viewed_products);

    if (isset($keys[$product_id])) {
        unset($viewed_products[$keys[$product_id]]);
        wc_setcookie('woocommerce_recently_wishlisted', implode('|', $viewed_products));
        wp_send_json_success($viewed_products);
    }

    $viewed_products[] = (int) $product_id;

    if (count($viewed_products) > 22) {
        array_shift($viewed_products);
    }

    wc_setcookie('woocommerce_recently_wishlisted', implode('|', $viewed_products));
    wp_send_json_success($viewed_products);
}
add_action('wp_ajax_wishlist_product', 'ajax_wishlist_product');
add_action('wp_ajax_nopriv_wishlist_product', 'ajax_wishlist_product');


function isHasWithList($product_id)
{
    if (empty($_COOKIE['woocommerce_recently_wishlisted'])) {
        $viewed_products = array();
    } else {
        $viewed_products = wp_parse_id_list((array) explode('|', wp_unslash($_COOKIE['woocommerce_recently_wishlisted'])));
    }
    $keys = array_flip($viewed_products);

    return isset($keys[$product_id]);
}

/* Function MENU Withlish */



function renderCountWithList()
{
    if (empty($_COOKIE['woocommerce_recently_wishlisted'])) {
        $viewed_products = array();
    } else {
        $viewed_products = wp_parse_id_list((array) explode('|', wp_unslash($_COOKIE['woocommerce_recently_wishlisted'])));
    }

    wp_send_json_success(count($viewed_products));
}
add_action('wp_ajax_wishlist_count', 'renderCountWithList');
add_action('wp_ajax_nopriv_wishlist_count', 'renderCountWithList');


function add_toggle_coupon_product()
{
    if (is_singular('product') && get_option('config_setting_shop_coupon_enable_product_detail') == 'on') {
    ?>
        <div class="cart-coupon my-4">
            <div class="cart-coupon-header">
                <span class="coupon-toggle-btn">
                    <i class="fa fa-arrow-left "> </i>
                </span>
                <span>Mã giảm giá</span>
            </div>
            <div class="section_coupons">
                <div class="container card border-0 ">
                    <div class="row scroll justify-content-xl-center   coupon--four-item">
                        <?php
                        $coupon_codes = get_posts(array(
                            'posts_per_page'   => 4,
                            'orderby'          => 'name',
                            'order'            => 'asc',
                            'post_type'        => 'shop_coupon',
                            'post_status'      => 'publish',
                        ));
                        ob_start();
                        $coupon_codes = array_map(function ($code) {
                            return new WC_Coupon($code->ID);
                        }, $coupon_codes);

                        $coupon_key = include __DIR__ . '/config/counpons.php';

                        if (count($coupon_codes)) {
                            foreach ($coupon_codes as $code) {
                                $exprity_time = strtotime($code->get_date_expires());
                                $type = $code->get_discount_type();
                                $meta_title = get_post_meta($code->get_id(), 'meta_title', true);
                                $short_description = get_post_meta($code->get_id(), 'short_description', true);
                        ?>
                                <div class="coupon-item-wrap">
                                    <div class="coupon_item coupon--new-style ">
                                        <div class="coupon_icon pos-relative embed-responsive embed-responsive-1by1">
                                            <a href="/collections/all" title="/collections/all">
                                                <img class="img-fluid" src="<?= $coupon_key[$type] ?>" alt="coupon_1_img.png" width="79" height="70">
                                            </a>
                                        </div>
                                        <div class="coupon_body">
                                            <div class="coupon_head coupon--has-info">
                                                <h3 class="coupon_title"><?= $meta_title ?></h3>
                                                <div class="coupon_desc"><?= $short_description ?></div>
                                            </div>
                                            <div class="box-coupon_default">
                                                <div class="coupon-code-body">
                                                    <div class="coupon-code-row">
                                                        <span>Mã:</span> <?= strtoupper($code->get_code()) ?>
                                                    </div>
                                                    <div class="coupon-code-row">
                                                        <span>HSD: <?= $code->get_date_expires()->date('d/m/Y') ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($exprity_time < time()) {
                                                    echo '<img src="' . $coupon_key['expiry'] . '" alt="outdated">';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="cart-coupon-overlay coupon-toggle-btn"></div>
<?php
    }
    if (wp_is_mobile() && (is_shop() || is_product_category() ))
    {
        echo do_shortcode('[yith_wcan_mobile_modal_opener]');
    }
}
add_action('wp_footer', 'add_toggle_coupon_product');





function wc_remove_checkout_fields($fields)
{

    //rename labal + placeholder
    $fields['billing']['billing_first_name']['label'] = 'Họ và Tên:';
    $fields['shipping']['shipping_first_name']['label'] = 'Họ và Tên:';
    $fields['billing']['billing_first_name']['placeholder'] = 'Tên của bạn...';
    $fields['shipping']['shipping_first_name']['placeholder'] = 'Tên của bạn...';
    $fields['billing']['billing_address_1']['label'] = 'Địa chỉ:';
    $fields['shipping']['shipping_address_1']['label'] = 'Địa chỉ:';
    $fields['billing']['billing_address_1']['placeholder'] = 'Địa chỉ nhận hàng...';
    $fields['shipping']['shipping_address_1']['placeholder'] = 'Địa chỉ nhận hàng...';
    $fields['billing']['billing_email']['label'] = 'Email của bạn:';
    $fields['billing']['billing_email']['placeholder'] = 'Nhập email...';
    $fields['billing']['billing_phone']['label'] = 'Phone:';
    $fields['billing']['billing_phone']['placeholder'] = 'Nhập số điện thoại...';


    // Billing fields
    // Unset -> remove
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    //unset( $fields['billing']['billing_country'] );

    // Shipping fields
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_state']);
    unset($fields['shipping']['shipping_last_name']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_city']);
    unset($fields['shipping']['shipping_postcode']);
    //unset( $fields['shipping']['shipping_country'] );
    $fields['shipping_country']['required'] = false;

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_remove_checkout_fields');


function change_default_checkout_country()
{
    return 'VN'; // country code
}

add_filter('default_checkout_billing_country', 'change_default_checkout_country');
