<?php
/**
 * Template part for displaying contact.
 *
 * @package business-lander
 */

the_post();

$image = get_the_post_thumbnail_url( 'full' );
if ( $image ) {
	$image = ' style="background-image: url(' . esc_url( $image ) . ')"';
}
?>
<section class="section--contact"<?php echo $image; // WPCS: XSS OK. ?>>
	<div class="container">
		<div class="section-contact__left">
			<div class="contact__left">
				<div class="title">
					<h2><?php the_title(); ?></h2>
				</div>
				<?php the_content(); ?>
			</div>
		</div>
		<div class="section-contact__right">
			<div class="contact__right">
				<?php
				$contact_page = get_theme_mod( 'contact_form' );
				$query        = new WP_Query( array(
					'post_type' => 'page',
					'page_id'   => $contact_page,
				) );
				while ( $query->have_posts() ) :
					$query->the_post();
					?>
					<h3 class="title"><?php the_title(); ?></h3>
					<?php the_content(); ?>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</div>
</section>
