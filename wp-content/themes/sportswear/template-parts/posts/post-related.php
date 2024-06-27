<?php

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 4,
    'post__not_in' => array(get_the_ID())
);
$posts = get_posts($args);

if (count($posts)) {
    echo '<div class="row">';
?>
    <div class="mb-3">
        <h2 class="heading-bar__title text-center" style="margin-bottom: 1em;">
            Tin liên quan
        </h2>
    </div>
    <div class="row ml-0 mr-0">
        <?php
        foreach ($posts as $item) {
            $post_id = $item->ID;
        ?>
            <div class="col large-3 medium-6 post-item">
                <div class="blogwp column ">
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
                            <span class="art-summary d-webkit d-webkit-3">
                                <?= get_the_excerpt($post_id) ?>
                            </span>
                            <a class="button_custome_35 link" href="<?= get_the_permalink($post_id) ?>" title="Đọc tiếp">Đọc tiếp</a>
                        </p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
<?php
    echo '</div>';
}
