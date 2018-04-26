<?php
/**
 * The template part for displaying cta section on front page
 *
 * @package business-lander
 */

$subtitle    = get_theme_mod( 'cta_title', __( 'Expect the extraordinary', 'business-lander' ) );
$title       = get_theme_mod( 'cta_text', __( 'We are A Team of Experts', 'business-lander' ) );
$button_url  = get_theme_mod( 'cta_button_url', 'https://gretathemes.com/' );
$button_text = get_theme_mod( 'cta_button_text', __( 'contact us', 'business-lander' ) );

$image = get_theme_mod( 'cta_background' );
if ( $image ) {
	$image = ' style="background-image: url(' . esc_url( $image ) . ')"';
}
?>

<section class="section--cta"<?php echo $image; // WPCS: XSS OK. ?>>
	<div class="container">
		<h3 class="section-cta__title">
			<?php echo esc_html( $subtitle ); ?>
		</h3>
		<p class="section-cta__text">
			<?php echo esc_html( $title ); ?>
		</p>
		<div class="section-cta__link">
			<a href="<?php echo esc_url( $button_url ); ?>" class="btn btn-primary">
				<?php echo esc_html( $button_text ); ?>
			</a>
		</div>
	</div>
</section>
