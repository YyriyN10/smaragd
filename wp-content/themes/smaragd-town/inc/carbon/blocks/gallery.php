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
					Field::make_complex('media_gallery', 'Галерея зображень')
            ->set_min(5)
            ->set_max(5)
						->set_required(true)
            ->add_fields(array(
                Field::make_image('image', 'Зображення')
	                ->set_type('image')
            ))

				))
			     ->add_tab('Опції', array(

				     Field::make_color('block_options_text_color', 'Колір тексту')
               ->set_width(50)
				          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

				     Field::make_color('block_options_bg_color', 'Колір тла блоку')
				          ->set_width(50)
				          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

				     Field::make_select('block_option_indent_top', 'Розмір верхнього внутрішнього відступу')
                  ->set_width(50)
				          ->add_options( array(
					          'indent-top-big' => 'Великий відступ',
					          'indent-top-medium' => 'Середній відступ',
					          'indent-top-small' => 'Малкнький відступ',
				          ) ),
				     Field::make_select('block_option_indent_bottom', 'Розмір нижнього внутрішнього відступу')
					        ->set_width(50)
				          ->add_options( array(
					          'indent-bottom-big' => 'Великий відступ',
					          'indent-bottom-medium' => 'Середній відступ',
					          'indent-bottom-small' => 'Малкнький відступ',
				          ) ),



				     Field::make_text('block_option_anchor_id', 'Якір блоку')
				        ->set_help_text('Потрібен для посилання на цей блок на априклад якогось пункту меню чи кнопки. Може містити латинські літери, ціфри, тере та підкреслення. Має бути унікальним на одній сторінці. Не може містити пробілів')

			     ))
			     ->set_category( 'custom-category-home' )
			     ->set_icon('format-gallery')

			     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				     ?>

				     <?php if( !empty( $fields['title'] ) ):?>

				         <section class="our-gallery animation-tracking <?php if ( !empty( $fields['block_option_indent_top'] ) ){echo $fields['block_option_indent_top'];}?> <?php if ( !empty( $fields['block_option_indent_bottom'] ) ){echo $fields['block_option_indent_bottom'];}?>"

						     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
							     id="<?php echo $fields['block_option_anchor_id'];?>"
						     <?php endif;?>

					         <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
                     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
					         <?php endif;?>
						     >
                   <div class="container">
                     <div class="row">
                       <h2 class="block-title col-xxl-8 col-xl-10 col-12 text-center offset-xxl-2 offset-xl-1 offset-0">
		                     <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
                       </h2>
                     </div>
                     <div class="row">
	                     <?php if( !empty($fields['media_gallery']) ):?>
                         <div class="gallery-wrapper col-12">
			                     <?php foreach( $fields['media_gallery'] as $item):?>
                             <a href="<?php echo wp_get_attachment_image_src($item['image'], 'full')[0];?>" data-fancybox="gallery" class="image-wrapper" >
                               <img
                                   src="<?php echo wp_get_attachment_image_src($item['image'], 'full')[0];?>"
						                     <?php
							                     $altText = get_post_meta($item['image'], '_wp_attachment_image_alt', TRUE);
							                     if ( !empty( $altText ) ):?>
                                     alt="<?php echo $altText;?>"
							                     <?php else:?>
                                     alt="<?php echo wp_strip_all_tags($fields['title']);?>"
							                     <?php endif;?>
                               >
                             </a>
			                     <?php endforeach;?>

                         </div>
	                     <?php endif;?>
                     </div>
                   </div>
				         </section>
				     <?php endif;?>

				     <?php
			     } );
		}
