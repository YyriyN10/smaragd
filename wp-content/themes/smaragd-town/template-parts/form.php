<?php

	if ( ! defined( 'ABSPATH' ) ) {
				exit;
			}
	?>

<form method="post">
	<input type="hidden" name="action" value="form_integration">
	<div class="form-group">
		<input type="text" name="name" class="form-control" placeholder=""
		       required>
	</div>
	<div class="form-group">
		<input type="tel" name="phone" class="form-control" placeholder=""
		       required>
	</div>
	<div class="form-group">
		<input type="email" name="email" class="form-control" placeholder="Email" required>
	</div>
	<div class="form-group textarea-group">
		<textarea name="message" class="form-control"
		          placeholder=""></textarea>
	</div>
	<button type="submit" class="button <?php if(!empty($args['btn_color'])){echo $args['btn_color'].'-btn';}?>"><?php echo $args['btn_text'];?></button>
	<input type="hidden" name="home-url" value="<?php echo home_url( '/' ); ?>">
	<input type="hidden" name="page-name" value="<?php the_title(); ?>">
	<input type="hidden" name="page-url" value="<?php the_permalink(); ?>">
	<?php wp_nonce_field( "form_integration" ); ?>

</form>
