<?php

	if ( ! defined( 'ABSPATH' ) ) {
				exit;
			}

	/**
	 * Change turn gallery
	 */

	add_action('wp_ajax_change_turn_gallery', 'change_turn_gallery_callback');
	add_action('wp_ajax_nopriv_change_turn_gallery', 'change_turn_gallery_callback');
	function change_turn_gallery_callback() {

		$galleryList = $_POST['galleryList'];

		$galleryList = explode(",", $galleryList);

		?>
		<?php foreach( $galleryList as $image):?>
			<div class="slide">
				<img
				   src="<?php echo wp_get_attachment_image_src($image, 'full')[0];?>"
				   <?php
				    $altText = get_post_meta($image, '_wp_attachment_image_alt', TRUE);
				    if ( !empty( $altText ) ):?>
				        alt="<?php echo $altText;?>"
				    <?php else:?>
				        alt="<?php the_title();?>"
				    <?php endif;?>
				>
			</div>

		<?php endforeach;?>
		<?php
		wp_die();
	}
