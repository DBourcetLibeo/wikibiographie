<?php get_header(); ?>

<div class="default-max-width">

    <h2><?php _e("Biographies"); ?></h2>

    <div>
        <?php get_search_form(); ?>
    </div>

    <div>
        <form action="<?php echo get_post_type_archive_link('biographie'); ?>" method="get">
            <label for="search">Search in <?php echo home_url( '/' ); ?></label>
            <input type="text" name="biographie_s" id="search" value="<?php the_search_query(); ?>" />
            <input type="submit" value="Search">
            <input type="hidden" value="biographie" name="post_type" id="post_type" />
        </form>
    </div>

    <ul>
        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; ?>

            <?php echo paginate_links(); ?>

        <?php endif; ?>
    </ul>

</div>


<?php get_footer(); ?>
