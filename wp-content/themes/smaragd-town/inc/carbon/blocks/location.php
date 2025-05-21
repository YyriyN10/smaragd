<?php

		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}

		use Carbon_Fields\Block;
		use Carbon_Fields\Field;

		add_action( 'carbon_fields_register_fields', 'our_location' );

		function our_location(){
			Block::make( 'Location' )
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
					Field::make_image('block_image', 'Зображення блоку')
						->set_required(true)
						->set_width(50),
					Field::make_complex('block_list', 'Перелік обʼєктів')
						->set_required(true)
						->add_fields(array(
							Field::make_text('distance_time', 'Відстань та час')
								->set_required(true)
								->set_width(50),
							Field::make_text('object_name', 'Назва обʼєкту')
								->set_required(true)
								->set_width(50),
						)),


				))
			     ->add_tab('Опції', array(
				     Field::make_select('block_option_indent_top', 'Розмір верхнього внутрішнього відступу')
				          ->add_options( array(
					          'indent-top-big' => 'Великий відступ',
					          'indent-top-small' => 'Малкнький відступ',
				          ) ),
				     Field::make_select('block_option_indent_bottom', 'Розмір нижнього внутрішнього відступу')
				          ->add_options( array(
					          'indent-bottom-big' => 'Великий відступ',
					          'indent-bottom-small' => 'Малкнький відступ',
				          ) ),
				     Field::make_color('block_options_bg_color', 'Колір тла блоку')
				          ->set_palette( array( '#1201FF', '#F7F00F', '#F64B0A', '#F9F9F9', '#FFFDFC', '#1D1D1B', '#CFCFCF') ),

				     Field::make_color('block_options_text_color', 'Колір тексту')
				          ->set_palette( array( '#1201FF', '#F7F00F', '#F64B0A', '#F9F9F9', '#FFFDFC', '#1D1D1B', '#CFCFCF') ),

				     Field::make_text('block_option_anchor_id', 'Якір блоку')
					     ->set_help_text('Потрібен для посилання на цей блок на априклад якогось пункту меню чи кнопки. Може містити латинські літери, ціфри, тере та підкреслення. Має бути унікальним на одній сторінці. Не може містити пробілів')



			     ))
			     ->set_category( 'custom-category-home' )
			     ->set_icon('location-alt')

			     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				     ?>

				     <?php if( !empty( $fields['title'] ) ):?>

				         <section class="our-location <?php if ( !empty( $fields['block_option_indent_top'] ) ){echo $fields['block_option_indent_top'];}?> <?php if ( !empty( $fields['block_option_indent_bottom'] ) ){echo $fields['block_option_indent_bottom'];}?> animation-tracking"

						     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
							     id="<?php echo $fields['block_option_anchor_id'];?>"
						     <?php endif;?>

						     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
							     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
						     <?php endif;?>
						     >
				           <div class="container">
				             <div class="row">
				               <h2 class="block-title col-12">
					               <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
				               </h2>
				             </div>
				             <div class="row">
					             <div class="pic-wrapper col-12">
						             <img
							             class="lazy"
							             data-src="<?php echo wp_get_attachment_image_src($fields['block_image'], 'full')[0];?>"
							             <?php
								             $altText = get_post_meta($fields['block_image'], '_wp_attachment_image_alt', TRUE);
								             if ( !empty( $altText ) ):?>
									             alt="<?php echo $altText;?>"
								             <?php else:?>
									             alt="<?php echo wp_strip_all_tags($fields['title']);?>"
								             <?php endif;?>

						             >
					             </div>
				               <?php if( $fields['block_list'] ):?>
				                 <ul class="card-list-wrapper col-12">
				                   <?php foreach( $fields['block_list'] as $item):?>
				                    <li class="card-item">
				                      <p class="name"><?php echo str_replace(['<p>', '</p>'], '', $item['distance_time'] );?></p>
				                      <p class="description"><?php echo str_replace(['<p>', '</p>'], '', $item['object_name'] );?></p>
				                    </li>
				                   <?php endforeach;?>
				                 </ul>
				               <?php endif;?>
					             <?php
						             $object_position = carbon_get_theme_option('option_object_location');

						             if(!empty($object_position) ):?>
							             <div class="map" id="map" data-lat="<?php echo $object_position['lat'];?>" data-lng="<?php echo $object_position['lng'];?>"></div>
					             <?php endif;?>

				             </div>
				           </div>
				         </section>
				     <?php endif;?>

				     <?php
			     } );
		}
