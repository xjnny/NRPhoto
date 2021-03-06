<?php
get_header();
?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">
    <section class="home__galleries">
      <?php
      $latest_posts = get_posts(array(
          'numberposts' => 6
      ));
      ?>
      <div class="gallery__container">
        <?php
        if ($latest_posts) {
          foreach ($latest_posts as $post) {
            setup_postdata($post);
            ?>
            <div class="reveal image__container">
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('thumbnail', array('class' => 'image__thumb')); ?>
                <div class="image__thumb-overlay">
                  <div class="image__thumb-text"><?php the_title(); ?></div>
                  <div class="image__thumb-icon"><?php
                    $hover = get_post_meta($post->ID, '_nrphoto_attached_image', true);
                    echo wp_get_attachment_image($hover);
                    ?>
                  </div>
                </div>
              </a>
            </div>
            <?php
          }
          wp_reset_postdata();
        }
        ?>
        <a href="portfolio"><button>View My Portfolio</button></a>
      </div>
    </section>
    <section class="stars__section" style="background-image: url('<?php echo esc_url(get_theme_mod('nrphoto_quote_image')) ?>')">
      <div class="reveal quote__block">
        <div class="stars__quote-mark">“</div>
        <div class="stars__quote"> <?php echo get_bloginfo('description', 'display'); ?>
        </div>
      </div>
    </section>
    <?php
    $args = array(
        'page_id' => '304'
    );
    $about = new WP_Query($args);
    $about_meta = get_post_meta(304);
    ?>

    <section class="reveal about__section">
      <div class="about__image" style="background-image: url('<?php echo esc_url(get_theme_mod('nrphoto_bio_image')); ?>')">


      </div>
      <?php if ($about->have_posts()) : ?>

        <?php
        while ($about->have_posts()) :
          $about->the_post();
          $bio = $about_meta['about_bio'][0];
          ?>
          <div class="about__text">
            <h2><?php echo $about_meta['about_head'][0] ?></h2>
            <p><?php echo substr($bio, 0, 350); ?> ...</p>
            <a href="about"><button >Read More</button></a>
            <?php
          endwhile;
          wp_reset_postdata();
          ?>
        <?php endif; ?>

    </section>

    <?php $contact_meta = get_post_meta(259); ?>

    <section class="contact__section" style="background-image: url('<?php echo esc_url(get_theme_mod('nrphoto_contact_image')) ?>')">
      <div class="reveal contact__container">
        <h3>Contact</h3>
        <a href="tel:<?php echo $contact_meta['contact_number'][0]; ?>"><p><?php echo $contact_meta['contact_number'][0]; ?></p></a>
        <a href="mailto:<?php echo $contact_meta['contact_email'][0]; ?>" ><p class="contact-email"><?php echo $contact_meta['contact_email'][0]; ?></p></a>
      </div>
    </section> 


  </main>
</div>

<?php
get_footer();
