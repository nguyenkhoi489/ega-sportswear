<?php

/**
 * Category title.
 *
 * @package          Flatsome/WooCommerce/Templates
 * @flatsome-version 3.18.4
 */

$classes = [
	'shop-page-title',
	'category-page-title',
	'page-title',
	flatsome_header_title_classes(false),
];

if (get_theme_mod('content_color') === 'dark') {
	$classes[] = 'dark';
}
if (get_option('config_setting_shop_enable_banner') == 'on' && get_option('config_setting_shop_banner_link')) {
?>
	<div class="row">
		<div class="col large-12 pb-0">
			<?= dimox_breadcrumbs() ?>
			<picture class="mt-20">
				<img class=" img-fluid"
				 src="<?=wp_get_attachment_url(get_option('config_setting_shop_banner_link'))?>" alt="Shop banner">
			</picture>
			<?php
			if(get_option('config_setting_shop_coupon_enable') == 'on')
			{
				echo '<div class="mt-20 mb-10">';
				echo do_shortcode('[nkd_ux_builder_coupon_code]');
				echo '</div>';
			}
			?>
		</div>
	</div>
<?php
}
?>

<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<div class="flex-row  medium-flex-wrap container">
		<div class="flex-col flex-grow medium-text-center">

		</div>
		<div class="flex-col medium-text-center">
			<?php do_action('flatsome_category_title_alt'); ?>
		</div>
	</div>
</div>