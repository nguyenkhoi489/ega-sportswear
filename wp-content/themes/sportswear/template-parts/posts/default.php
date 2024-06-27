<?php

/**
 * Posts content single.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

?>
<div class="row align-center">
	<div class="col large-9">
		<div class="entry-content single-page">
			<img class="img-fluid mx-auto mb-3 d-block mh-100 w-auto" src="<?= get_the_post_thumbnail_url() ?>" alt="<?= get_the_title() ?>" style="width: 100%">
			<h1 class="article-title title_page"><?= get_the_title() ?></h1>
			<div class="media ">
				<div class="media-body text-right">
					<div class="mt-0 "><?php the_author_meta('display_name') ?></div>
					<div class="art-info text-muted font-weight-light justify-content-end ">
						<span>
							<i class="fas fa-calendar-alt"></i> <?= get_the_time() ?>
						</span>
					</div>
				</div>
			</div>
			<div class="article-content">
				<?php the_content(); ?>
			</div>
			<?php
			wp_link_pages();
			?>
		</div>

	</div>
</div>