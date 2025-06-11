<?php

	if ( ! defined( 'ABSPATH' ) ) {
				exit;
			}
	?>

<form method="post">
	<input type="hidden" name="action" value="form_integration">
	<div class="form-group">
    <label>
      <span class="label">Ім’я</span>
      <input type="text" name="name" class="form-control" autocomplete="on" required>
    </label>
	</div>
	<div class="form-group">
    <label>
      <span class="label">Телефон</span>
      <input type="tel" name="phone" class="form-control" autocomplete="off" required>
    </label>
	</div>
	<div class="form-group">
    <label>
      <span class="label">Email</span>
      <input type="email" name="email" class="form-control" autocomplete="of" required>
    </label>
	</div>
	<button type="submit" class="button small-btn <?php if(!empty($args['btn_color'])){echo $args['btn_color'].'-btn';}?>">
    <?php echo $args['btn_text'];?>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <path d="M10.4391 8.11065C10.4391 7.83462 10.663 7.61088 10.939 7.61071L15.8888 7.61071L15.9896 7.62037C16.2174 7.66698 16.3887 7.86902 16.3887 8.11065V13.0604L16.379 13.1612C16.3324 13.389 16.1303 13.5603 15.8888 13.5603C15.6473 13.5602 15.4451 13.3889 15.3985 13.1612L15.3888 13.0604V9.31771L8.46414 16.2424C8.26886 16.4374 7.95221 16.4376 7.75703 16.2424C7.56194 16.0472 7.56203 15.7305 7.75703 15.5353L14.6817 8.6106L10.939 8.6106C10.6631 8.61042 10.4391 8.38662 10.4391 8.11065Z" fill="#F9FCF5"/>
    </svg>
  </button>
	<input type="hidden" name="home-url" value="<?php echo home_url( '/' ); ?>">
	<input type="hidden" name="page-name" value="<?php the_title(); ?>">
	<input type="hidden" name="page-url" value="<?php the_permalink(); ?>">
	<?php wp_nonce_field( "form_integration", "form_integration_nonce" ); ?>

</form>
