<?php
/**
 * Posts layout.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

do_action('flatsome_before_blog');
$object = get_queried_object();
?>

<div class="row align-center">
	
	<?php
		if(is_single()){
			
			echo '<div class="large-12 col">';
			echo dimox_breadcrumbs();
			include __DIR__ . '/default.php';
			include __DIR__ . '/post-related.php';
		} elseif(get_theme_mod('blog_style_archive', '') && (is_archive() || is_search())){
			echo '<div class="large-12 col">';
			echo '<h1 class="title_page text-center">'.(isset($object->name) ? $object->name : $object->post_title).'</h1>';
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style', 'normal') );
		} else{
			echo '<div class="large-12 col">';
			echo '<h1 class="title_page text-center">'.(isset($object->name) ? $object->name : $object->post_title).'</h1>';
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style', 'normal') );
		}
		echo '</div>';
	?>
	

</div>

<?php do_action('flatsome_after_blog');
