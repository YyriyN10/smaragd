<?php

	if ( ! defined( 'ABSPATH' ) ) {
				exit;
			}

	$contacts_email = carbon_get_theme_option('option_email_list');

	if (!empty($contacts_email)):?>

    <div class="emails-wrapper">
	    <?php foreach( $contacts_email as $email):?>
        <p class="contact-item">
          <a href="mailto:<?php echo antispambot($email['email'], 1);?>"><?php echo antispambot($email['email'], 0) ;?></a>
        </p>
	    <?php endforeach;?>
    </div>

<?php endif;?>
