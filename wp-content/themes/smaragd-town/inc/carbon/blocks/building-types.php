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
					Field::make_complex('block_list', 'Перелік типів забудови')
						->set_required(true)
						->add_fields(array(
							Field::make_text('type_name', 'Назва типу')
								->set_required(true)
								->set_width(30),
							Field::make_complex('characteristics_list', 'Перелік планувань')
								->set_required(true)
								->set_width(70)
								->add_fields(array(
								  Field::make_text('name', 'Назва типу планування'),
									Field::make_text('total_area', 'Загальна площа')
                    ->set_attribute('type', 'number')
                    ->set_help_text('Зазначити у метрах квадратних'),
									Field::make_text('living_space', 'Жила площа')
									     ->set_attribute('type', 'number')
									     ->set_help_text('Зазначити у метрах квадратних'),
                  Field::make_image('image', 'Зображення планування')
                    ->set_type('image')
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
							Field::make_image('image', 'Зображення до опису')
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
                ->set_value_type('url')
								->set_width(20),
							Field::make_text('name', 'Назва')
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
				     Field::make_color('block_options_bg_color', 'Колір тла блоку')
				          ->set_width(50)
				          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

				     Field::make_color('block_options_text_color', 'Колір тексту')
				          ->set_width(50)
				          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

				     Field::make_select('block_option_btn_color', 'Колір кнопки')
				          ->add_options( array(
					          'orange' => 'Помаранчевий',
					          'green' => 'Зелений',
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
				               <h2 class="block-title col-12 text-center">
					               <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
				               </h2>
				             </div>
					           <div class="row">
						           <?php if( $fields['block_list'] ):?>
							           <div class="types-wrapper col-12">
								           <ul class="nav nav-tabs">
									           <?php foreach( $fields['block_list'] as $index=>$item ):?>
										           <li class="nav-item">
											           <a class="nav-link tub-btn" data-bs-toggle="tab" href="#building-type-<?php echo $index;?>">
												           <?php echo str_replace(['<p>', '</p>'], '', $item['type_name'] );?>
											           </a>
										           </li>
									           <?php endforeach;?>
								           </ul>
								           <div class="tab-content">
									           <?php foreach( $fields['block_list'] as $index=>$item ):?>
										           <div class="tab-pane" id="building-type-<?php echo $index;?>">
											           <div class="inner-content">
												           <div class="text-content col-xl-4 col-md-6">
                                     <div class="inner">
                                       <div class="description-pic">
                                         <img
                                             class="lazy object-fit"
                                             data-src="<?php echo wp_get_attachment_image_src($item['image'], 'full')[0];?>"
			                                     <?php
				                                     $altText = get_post_meta($item['image'], '_wp_attachment_image_alt', TRUE);
				                                     if ( !empty( $altText ) ):?>
                                               alt="<?php echo $altText;?>"
				                                     <?php else:?>
                                               alt="<?php echo wp_strip_all_tags($item['type_name']);?>"
				                                     <?php endif;?>

                                         >
                                       </div>
                                       <p class="name card-title big-title"><?php echo str_replace(['<p>', '</p>'], '', $item['type_name'] );?></p>
	                                     <?php if( !empty($item['description']) ):?>
                                         <p class="description">
			                                     <?php echo str_replace(['<p>', '</p>'], '', $item['description'] );?>
                                         </p>
	                                     <?php endif;?>
	                                     <?php if ( !empty( $fields['btn_text'] ) ):?>
                                         <div class="button big-btn <?php if ( !empty( $fields['block_option_btn_color'] ) ){echo $fields['block_option_btn_color'].'-btn';}else{echo 'basic-btn';}?>" data-bs-toggle="modal" data-bs-target="#formModal">
			                                     <?php echo $fields['btn_text'];?>
                                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                             <path d="M10.4391 8.11065C10.4391 7.83462 10.663 7.61088 10.939 7.61071L15.8888 7.61071L15.9896 7.62037C16.2174 7.66698 16.3887 7.86902 16.3887 8.11065V13.0604L16.379 13.1612C16.3324 13.389 16.1303 13.5603 15.8888 13.5603C15.6473 13.5602 15.4451 13.3889 15.3985 13.1612L15.3888 13.0604V9.31771L8.46414 16.2424C8.26886 16.4374 7.95221 16.4376 7.75703 16.2424C7.56194 16.0472 7.56203 15.7305 7.75703 15.5353L14.6817 8.6106L10.939 8.6106C10.6631 8.61042 10.4391 8.38662 10.4391 8.11065Z" fill="#F9FCF5"/>
                                           </svg>
                                         </div>
	                                     <?php endif;?>
                                     </div>
												           </div>
												           <?php if( $item['characteristics_list'] ):?>
                                     <ul class="card-list-wrapper type-list col-xl-8 col-md-6">
														           <?php foreach( $item['characteristics_list'] as $innerItem ):?>
                                         <li class="card-item type-item">
                                           <div class="planning-image">

                                             <img
                                                class="lazy"
                                                data-src="<?php echo wp_get_attachment_image_src($innerItem['image'], 'full')[0];?>"
                                                <?php
                                                 $altText = get_post_meta($innerItem['image'], '_wp_attachment_image_alt', TRUE);
                                                 if ( !empty( $altText ) ):?>
                                                     alt="<?php echo $altText;?>"
                                                 <?php else:?>
                                                     alt="<?php echo wp_strip_all_tags($innerItem['name']);?>"
                                                 <?php endif;?>

                                             >
                                           </div>
                                           <div class="info">
                                             <p class="type-name"><?php echo $innerItem['name'];?></p>
                                             <div class="area-list">
                                               <p class="area"><?php echo $innerItem['living_space'];?> м²</p>
                                               <p class="area"><?php echo $innerItem['total_area'];?> м²</p>
                                             </div>

                                           </div>
                                         </li>
														           <?php endforeach;?>
                                     </ul>
												           <?php endif;?>
											           </div>
										           </div>
									           <?php endforeach;?>
								           </div>
							           </div>
						           <?php endif;?>
					           </div>
                     <div class="row">
                       <h2 class="block-title col-12 text-center">
		                     <?php echo str_replace(['<p>', '</p>'], '', $fields['second_title'] );?>
                       </h2>
                     </div>
					           <?php if( !empty($fields['foundation']) ):?>
					           <div class="row">
						           <ul class="card-list-wrapper composition-list col-12">
							           <?php foreach( $fields['foundation'] as $item):?>
								           <li class="card-item">
                             <div class="heading">
                               <div class="icon-wrapper">
                                 <img src="<?php echo $item['icon'];?>" alt="<?php echo wp_strip_all_tags($item['name']);?>" class="svg-pic">
                               </div>
                               <p class="name card-title"><?php echo str_replace(['<p>', '</p>'], '', $item['name'] );?></p>
                             </div>

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
