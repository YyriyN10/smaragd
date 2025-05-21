<?php

		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}

		use Carbon_Fields\Block;
		use Carbon_Fields\Field;

		add_action( 'carbon_fields_register_fields', 'call_to_action' );

		function call_to_action(){
			Block::make( 'Call to action' )
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
					Field::make_rich_text('text', 'Обмежений текст')
					     ->set_width(50)
					     ->set_rows(1)
					     ->set_settings([
						     'media_buttons' => false,
						     'tinymce' => [
							     'toolbar1' => 'forecolor, bold, link',
							     'toolbar2' => '',

						     ],
					     ]),
					Field::make_text('btn_text', 'Текст кнопки'),
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

				     Field::make_select('block_option_btn_color', 'Колір кнопки')
				          ->add_options( array(
					          'red' => 'Червоний',
					          'black' => 'Чорний',
				          ) ),
				     Field::make_text('block_option_anchor_id', 'Якір блоку')
				        ->set_help_text('Потрібен для посилання на цей блок на априклад якогось пункту меню чи кнопки. Може містити латинські літери, ціфри, тере та підкреслення. Має бути унікальним на одній сторінці. Не може містити пробілів'),
				     Field::make_radio('block_option_add_form', 'Варіант відображення блоку')
					     ->set_required(true)
					     ->add_options( array(
						     'call-to-form' => 'Виводити форму у блоці',
						     'call-to-single' => 'Не виводити форму у блоці',

					     ) )



			     ))
			     ->set_category( 'custom-category-home' )
			     ->set_icon('megaphone')

			     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				     ?>

				     <?php if( !empty( $fields['title'] ) && !empty( $fields['text'] ) ):?>

				         <section class="call-to-action <?php echo $fields['block_option_add_form'];?> <?php if ( !empty( $fields['block_option_indent_top'] ) ){echo $fields['block_option_indent_top'];}?> <?php if ( !empty( $fields['block_option_indent_bottom'] ) ){echo $fields['block_option_indent_bottom'];}?> animation-tracking"

						     <?php if( !empty( $fields['block_option_anchor_id'] ) ):?>
							     id="<?php echo $fields['block_option_anchor_id'];?>"
						     <?php endif;?>

						     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
							     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
						     <?php endif;?>
						     >
				           <div class="container">
				             <div class="row">
					             <div class="text-wrapper col-12">
						             <h2 class="block-title">
							             <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
						             </h2>
						             <?php if( !empty($fields['text']) ):?>
							             <p class="subtitle"><?php echo str_replace(['<p>', '</p>'], '', $fields['text'] );?></p>
						             <?php endif;?>
						             <?php if( $fields['block_option_add_form'] === 'call-to-single' ):?>
							             <div class="button <?php if ( !empty( $fields['block_option_btn_color'] ) ){echo $fields['block_option_btn_color'].'-btn';}else{echo 'basic-btn';}?>" data-bs-toggle="modal" data-bs-target="#formModal">
								             <?php echo $fields['btn_text'];?>
							             </div>
						             <?php endif;?>
					             </div>
					             <?php if( $fields['block_option_add_form'] === 'call-to-form' ):?>

						             <?php

						              $form_args = array(
						              	'btn_text' => $fields['btn_text'],
							              'btn_color' => $fields['block_option_btn_color']
						              );

						             get_template_part('template-parts/form', null, $form_args);?>
					             <?php endif;?>

				             </div>
				           </div>
				         </section>
				     <?php endif;?>

				     <?php
			     } );
		}
