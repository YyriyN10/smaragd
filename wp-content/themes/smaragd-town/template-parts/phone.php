<?php

	if ( ! defined( 'ABSPATH' ) ) {
				exit;
			}

	$mainPhone = carbon_get_theme_option('option_phone_list');

		if ( $mainPhone ):?>
      <div class="phones-wrapper">
	      <?php foreach( $mainPhone as $phone ):
		      $phoneToColl = preg_replace( '/[^0-9]/', '', $phone['phone']);
		      ?>

		      <?php if( str_contains( strval($phone['phone']), '+') ):?>
          <p class="contact-item"><a href="tel:+<?php echo $phoneToColl;?>" class="phone"><?php echo $phone['phone'];?></a></p>
	      <?php else :?>
          <p class="contact-item"><a href="tel:<?php echo $phoneToColl;?>" class="phone"><?php echo $phone['phone'];?></a></p>
	      <?php endif;?>

	      <?php endforeach;?>
      </div>
	<?php endif;?>
