<?php

	if ( ! defined( 'ABSPATH' ) ) {
				exit;
			}

	$footer_work_schedule = carbon_get_theme_option('option_work_schedule');

	if( !empty($footer_work_schedule) ):?>
     <p class="contact-item schedule-item"><?php echo $footer_work_schedule;?></p>
	<?php endif;?>
