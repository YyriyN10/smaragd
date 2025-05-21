<?php

		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}

		use Carbon_Fields\Block;
		use Carbon_Fields\Field;

		add_action( 'carbon_fields_register_fields', 'building_types' );

		function building_types(){
			Block::make( 'Building types' )
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
					Field::make_complex('block_list', 'Переліе типів забудови')
						->set_required(true)
						->add_fields(array(
							Field::make_text('type_name', 'Назва типу')
								->set_required(true)
								->set_width(30),
							Field::make_complex('characteristics_list', 'Перелік зарактеристик')
								->set_required(true)
								->set_width(70)
								->add_fields(array(
									Field::make_text('characteristic', 'Текст характеристики')
								)),
							Field::make_rich_text('description', 'Опис')
							     ->set_width(50)
							     ->set_settings([
								     'media_buttons' => false,
								     'tinymce' => [
									     'toolbar1' => 'forecolor, bold, link',
									     'toolbar2' => '',

								     ],
							     ]),
							Field::make_media_gallery('planning_options', 'Зображення можливих планувань')
								->set_required(true)
								->set_width(50)
								->set_type('image')
						)),
					Field::make_text('btn_text', 'Текст кнопки'),
					Field::make_separator('block_separator', 'Основа надійного дому'),
					Field::make_rich_text('second_title', 'Заголовок')
					     ->set_rows(1)
					     ->set_settings([
						     'media_buttons' => false,
						     'tinymce' => [
							     'toolbar1' => 'forecolor',
							     'toolbar2' => '',

						     ],
					     ]),
					Field::make_complex('foundation', 'Перелік складових')
						->add_fields(array(
							Field::make_image('icon', 'Іконка')
								->set_required(true)
								->set_width(20),
							Field::make_text('name', 'Нвазва')
								->set_required(true)
								->set_width(30),
							Field::make_rich_text('description', 'Опис')
									->set_required(true)
							     ->set_width(50)
							     ->set_settings([
								     'media_buttons' => false,
								     'tinymce' => [
									     'toolbar1' => 'forecolor, bold, link',
									     'toolbar2' => '',

								     ],
							     ]),
						))

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
				        ->set_help_text('Потрібен для посилання на цей блок на априклад якогось пункту меню чи кнопки. Може містити латинські літери, ціфри, тере та підкреслення. Має бути унікальним на одній сторінці. Не може містити пробілів')



			     ))
			     ->set_category( 'custom-category-home' )
			     ->set_icon('admin-multisite')

			     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				     ?>

				     <?php if( !empty( $fields['title'] ) ):?>

				         <section class="building-types <?php if ( !empty( $fields['block_option_indent_top'] ) ){echo $fields['block_option_indent_top'];}?> <?php if ( !empty( $fields['block_option_indent_bottom'] ) ){echo $fields['block_option_indent_bottom'];}?> animation-tracking"

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
						           <?php if( $fields['block_list'] ):?>
							           <div class="types-wrapper col-12">
								           <ul class="nav nav-pills">
									           <?php foreach( $fields['block_list'] as $index=>$item ):?>
										           <li class="nav-item">
											           <a class="nav-link" data-bs-toggle="pill" href="#building-type-<?php echo $index;?>">
												           <?php echo str_replace(['<p>', '</p>'], '', $item['type_name'] );?>
											           </a>
										           </li>
									           <?php endforeach;?>
								           </ul>
								           <div class="tab-content">
									           <?php foreach( $fields['block_list'] as $index=>$item ):?>
										           <div class="tab-pane fade" id="building-type-<?php echo $index;?>">
											           <div class="inner-content">
												           <div class="text-content">
													           <?php if( $item['characteristics_list'] ):?>
														            <ul class="characteristics-list">
															            <?php foreach( $item['characteristics_list'] as $innerItem ):?>
															              <li class="characteristic">
																              <?php echo str_replace(['<p>', '</p>'], '', $innerItem['characteristic'] );?>
															              </li>
															            <?php endforeach;?>
														            </ul>
													           <?php endif;?>
													           <?php if( !empty($item['description']) ):?>
													            <p class="description">
														            <?php echo str_replace(['<p>', '</p>'], '', $item['description'] );?>
													            </p>
													           <?php endif;?>
													           <?php if ( !empty( $fields['btn_text'] ) ):?>
														           <div class="button <?php if ( !empty( $fields['block_option_btn_color'] ) ){echo $fields['block_option_btn_color'].'-btn';}else{echo 'basic-btn';}?>" data-bs-toggle="modal" data-bs-target="#formModal">
															           <?php echo $fields['btn_text'];?>
														           </div>
													           <?php endif;?>
												           </div>
												           <?php if( !empty($item['planning_options']) ):?>
													           <div class="planning-options">
														           <?php foreach( $item['planning_options'] as $slide):?>
														            <div class="slide">
															            <img
															               src="<?php echo wp_get_attachment_image_src($slide['id'], 'full')[0];?>"
															               <?php
															                $altText = get_post_meta($slide['id'], '_wp_attachment_image_alt', TRUE);
															                if ( !empty( $altText ) ):?>
															                    alt="<?php echo $altText;?>"
															                <?php else:?>
															                    alt="<?php echo wp_strip_all_tags($item['type_name']);?>"
															                <?php endif;?>

															            >
														            </div>
														           <?php endforeach;?>
													           </div>
												           <?php endif;?>

											           </div>
										           </div>
									           <?php endforeach;?>
								           </div>
							           </div>
						           <?php endif;?>
					           </div>
					           <?php if( !empty($fields['foundation']) ):?>
					           <div class="row">
						           <ul class="card-list-wrapper col-12">
							           <?php foreach( $fields['foundation'] as $item):?>
								           <li class="card-item">
									           <div class="icon-wrapper">
										           <img src="<?php echo $item['icon'];?>" alt="<?php echo wp_strip_all_tags($item['name']);?>" class="svg-pic">
									           </div>
									           <p class="name"><?php echo str_replace(['<p>', '</p>'], '', $item['name'] );?></p>
									           <p class="description"><?php echo str_replace(['<p>', '</p>'], '', $item['description'] );?></p>
								           </li>

							           <?php endforeach;?>
						           </ul>
					           <?php endif;?>

				             </div>
				           </div>
				         </section>
				     <?php endif;?>

				     <?php
			     } );
		}
