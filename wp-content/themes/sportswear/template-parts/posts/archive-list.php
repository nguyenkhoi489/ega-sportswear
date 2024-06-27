<?php

/**
 * Posts archive list.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.18.0
 */

if (have_posts()) : ?>
	<div id="post-list">
		<div class="row">
			<div class="col large-9 medium-12 pb-0">
				<div class="row large-columns-1 medium-columns- small-columns-1">
					<?php
					while (have_posts()) : the_post();
						$post_id = get_the_ID();
					?>
						<div class="col post-item">
							<div class="blogwp ">
								<a class="image-blog  card-img-top text-center position-relative d-flex" href="<?= get_the_permalink($post_id) ?>" title="<?= get_the_title($post_id) ?>">
									<img class="img-fluid m-auto mh-100 w-auto" src="<?= get_the_post_thumbnail_url($post_id, 'full') ?>" alt="<?= get_the_title($post_id) ?>">
								</a>
								<div class="content_blog clearfix card-body px-0 py-2">
									<h3 class="">
										<a class="link d-webkit d-webkit-2" href="<?= get_the_permalink($post_id) ?>" title="<?= get_the_title($post_id) ?>"><?= get_the_title($post_id) ?></a>
									</h3>
									<div class="media">
										<div class="media-body">
											<div class="art-info text-muted ">
												<span>
													<i class="fas fa-calendar-alt" style="margin-right: 10px;"></i><?= get_the_time('d/m/Y',$post_id) ?>
												</span>
											</div>
										</div>
									</div>
									<p class="justify">
										<span class="art-summary">
											<?=get_the_excerpt($post_id)?>
										</span>
										<a class="button_custome_35 link" href="<?= get_the_permalink($post_id) ?>" title="Đọc tiếp">Đọc tiếp</a>
									</p>
								</div>
							</div>
						</div>
					<?php
					endwhile; // end of the loop.
					echo '<div class="col">';
					flatsome_posts_pagination();
					echo '</div>' ?>
				</div>
			</div>
			<div class="col large-3 hide-for-medium">
			<?php get_sidebar(); ?>
			</div>
		</div>

	</div>
<?php else : ?>

	<?php get_template_part('template-parts/posts/content', 'none'); ?>

<?php endif; ?>