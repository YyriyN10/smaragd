<?php

		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}

		use Carbon_Fields\Block;
		use Carbon_Fields\Field;

		add_action( 'carbon_fields_register_fields', 'project_gallery' );

		function project_gallery(){
			Block::make( 'Gallery' )
				->add_tab('Контент блоку', array(
					Field::make_rich_text('title', 'Заголовок блоку')
					     ->set_required(true)
					     ->set_width(50)
					     ->set_rows(1)
					     ->set_settings([
						     'media_buttons' => false,
						     'tinymce' => [
							     'toolbar1' => 'forecolor',
							     'toolbar2' => '',

						     ],
					     ]),
					Field::make_media_gallery('media_gallery', 'Галерея зображень')
						->set_required(true)
						->set_type('image')
				))
			     ->add_tab('Опції', array(

				     Field::make_color('block_options_text_color', 'Колір тексту')
				          ->set_palette( array( '#1201FF', '#F7F00F', '#F64B0A', '#F9F9F9', '#FFFDFC', '#1D1D1B', '#CFCFCF') ),

				     Field::make_text('block_option_anchor_id', 'Якір блоку')
				        ->set_help_text('Потрібен для посилання на цей блок на априклад якогось пункту меню чи кнопки. Може містити латинські літери, ціфри, тере та підкреслення. Має бути унікальним на одній сторінці. Не може містити пробілів')

			     ))
			     ->set_category( 'custom-category-home' )
			     ->set_icon('format-gallery')

			     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				     ?>

				     <?php if( !empty( $fields['title'] ) ):?>

				         <section class="our-gallery animation-tracking"

						     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
							     id="<?php echo $fields['block_option_anchor_id'];?>"
						     <?php endif;?>

						     <?php if( !empty( $fields['block_options_text_color'] )):?>
							     style="<?php if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
						     <?php endif;?>
						     >
					         <h2 class="block-title">
						         <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
					         </h2>
					         <?php if( !empty($fields['media_gallery']) ):?>
						         <div class="slider-wrapper">
							         <?php foreach( $fields['media_gallery'] as $item):?>
								         <div class="slider" id="gallery-slider">
													<img
													   src="<?php echo wp_get_attachment_image_src($item['id'], 'full')[0];?>"
													   <?php
													    $altText = get_post_meta($item['id'], '_wp_attachment_image_alt', TRUE);
													    if ( !empty( $altText ) ):?>
													        alt="<?php echo $altText;?>"
													    <?php else:?>
													        alt="<?php echo wp_strip_all_tags($fields['title']);?>"
													    <?php endif;?>

													>
								         </div>
							         <?php endforeach;?>

						         </div>
					         <?php endif;?>
				         </section>
				     <?php endif;?>

				     <?php
			     } );
		}
