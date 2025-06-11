<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	use Carbon_Fields\Block;
	use Carbon_Fields\Field;

	add_action( 'carbon_fields_register_fields', 'life_spase' );

	function life_spase(){
		Block::make( 'Life spase' )
		     ->add_tab('Контент блоку', array(
			     Field::make_rich_text('title', 'Заголовок блоку')
			          ->set_required(true)
			          ->set_rows(1)
			          ->set_settings([
				          'media_buttons' => false,
				          'tinymce' => [
					          'toolbar1' => 'forecolor',
					          'toolbar2' => '',

				          ],
			          ]),
			     Field::make_complex('block_list', 'Перелік переваг')
			          ->set_required(true)
			          ->add_fields(array(
			          	Field::make_image('icon', 'Зображення картки')
					          ->set_required(true)
					          ->set_width(20)
										->set_value('url'),
				          Field::make_rich_text('name', 'Назва')
				               ->set_rows(1)
					             ->set_required(true)
					             ->set_width(40)
				               ->set_settings([
					               'media_buttons' => false,
					               'tinymce' => [
						               'toolbar1' => 'forecolor',
						               'toolbar2' => '',
					               ],
				               ]),
				          Field::make_rich_text('text', 'Опис')
				               ->set_rows(1)
					             ->set_width(40)
					             ->set_required(true)
				               ->set_settings([
					               'media_buttons' => false,
					               'tinymce' => [
						               'toolbar1' => 'forecolor, bold, link',
						               'toolbar2' => '',

					               ],
				               ]),
			          )),

		     ))
		     ->add_tab('Опції', array(
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

			     Field::make_color('block_options_text_color', 'Колір тексту')
			          ->set_width(50)
			          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

			     Field::make_color('block_options_bg_color', 'Колір тла блоку')
			          ->set_width(50)
			          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

			     Field::make_text('block_option_anchor_id', 'Якір блоку')
				     ->set_help_text('Потрібен для посилання на цей блок на априклад якогось пункту меню чи кнопки. Може містити латинські літери, ціфри, тере та підкреслення. Має бути унікальним на одній сторінці. Не може містити пробілів')

		     ))
		     ->set_category( 'custom-category-home' )
		     ->set_icon('excerpt-view')

		     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
			     ?>

			     <?php if( !empty( $fields['title'] ) && !empty( $fields['block_list'] ) ):?>

				     <section class="life-space <?php if ( !empty( $fields['block_option_indent_bottom'] ) ){echo $fields['block_option_indent_bottom'];}?> animation-tracking"

					     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
						     id="<?php echo $fields['block_option_anchor_id'];?>"
					     <?php endif;?>

					     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
						     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
					     <?php endif;?>
				     >
					     <div class="container <?php if ( !empty( $fields['block_option_indent_top'] ) ){echo $fields['block_option_indent_top'];}?>">
                 <div class="block-pic">
                   <svg xmlns="http://www.w3.org/2000/svg" width="173" height="321" viewBox="0 0 173 321" fill="none">
                     <path d="M156.87 122.864H76.3232L76.0967 123.811L172.296 172.662L143.313 221.297L143.31 221.304L86.4951 320.006L14.8672 198.136H95.4043L95.6328 197.19L0.6875 148.333L14.4238 123.618L86.4951 0.992188L156.87 122.864Z" stroke="#02B513"/>
                   </svg>
                 </div>
						     <div class="row">
							     <h2 class="block-title col-12 text-center">
								     <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
							     </h2>
						     </div>
						     <div class="row">
							     <ul class="content card-list-wrapper col-12">
								     <?php foreach( $fields['block_list'] as $item ):?>
									     <li class="card-item">
										     <div class="icon">
                           <img
                              class="lazy"
                              data-src="<?php echo wp_get_attachment_image_src($item['icon'], 'full')[0];?>"
                              <?php
                               $altText = get_post_meta($item['icon'], '_wp_attachment_image_alt', TRUE);
                               if ( !empty( $altText ) ):?>
                                   alt="<?php echo $altText;?>"
                               <?php else:?>
                                   alt="<?php echo str_replace(['<p>', '</p>'], '', $item['name'] );?>"
                               <?php endif;?>

                           >
										     </div>
										     <p class="name card-title"><?php echo str_replace(['<p>', '</p>'], '', $item['name'] );?></p>
										     <p class="description"><?php echo str_replace(['<p>', '</p>'], '', $item['text'] );?></p>
									     </li>
								     <?php endforeach;?>
							     </ul>
						     </div>
					     </div>
				     </section>
			     <?php endif;?>

			     <?php
		     } );
	}
