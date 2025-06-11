<?php

		if ( ! defined( 'ABSPATH' ) ) {
			exit;
		}

		use Carbon_Fields\Block;
		use Carbon_Fields\Field;

		add_action( 'carbon_fields_register_fields', 'home_main_screen' );

		function home_main_screen(){
			Block::make( 'Home main screen' )
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
					Field::make_rich_text('text', 'Текст блоку')
					     ->set_rows(1)
					     ->set_width(50)
					     ->set_settings([
						     'media_buttons' => false,
						     'tinymce' => [
							     'toolbar1' => 'forecolor, bold, link',
							     'toolbar2' => '',

						     ],
					     ]),
					Field::make_text('btn_text', 'Текст кнопки')
						->set_width(50),
          Field::make_image('bg_image', 'Фонове зображення')
            ->set_width(50),
          Field::make_complex('more_info', 'Додаткова інформація')
            ->add_fields(array(
	            Field::make_rich_text('title', 'Теза')
	                 ->set_required(true)
	                 ->set_width(30)
	                 ->set_rows(1)
	                 ->set_settings([
		                 'media_buttons' => false,
		                 'tinymce' => [
			                 'toolbar1' => 'forecolor',
			                 'toolbar2' => '',

		                 ],
	                 ]),
	            Field::make_rich_text('description', 'Значення')
		               ->set_required(true)
	                 ->set_rows(1)
	                 ->set_width(50)
	                 ->set_settings([
		                 'media_buttons' => false,
		                 'tinymce' => [
			                 'toolbar1' => 'forecolor, bold, link',
			                 'toolbar2' => '',

		                 ],
	                 ]),
              Field::make_image('image', 'Зображення')
                ->set_type('image')
	              ->set_required(true)
                ->set_width(20),
	            Field::make_rich_text('more_text', 'Додатковий прихований текст')
	                 ->set_rows(1)
	                 ->set_settings([
		                 'media_buttons' => false,
		                 'tinymce' => [
			                 'toolbar1' => 'forecolor, bold, link',
			                 'toolbar2' => '',

		                 ],
	                 ]),

            )),
          Field::make_text('location_text', 'Місце знаходження')

				))
			     ->add_tab('Опції', array(

				     Field::make_color('block_options_bg_color', 'Колір тла блоку')
				          ->set_width(50)
				          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

				     Field::make_color('block_options_text_color', 'Колір тексту')
				          ->set_width(50)
				          ->set_palette( array( '#F9FCF5', '#F9FCF5', '#034F43', '#02B513', '#F2682C') ),

				     Field::make_select('block_option_btn_color', 'Колір кнопки')
				          ->set_width(50)
				          ->add_options( array(
					          'orange' => 'Помаранчевий',
					          'green' => 'Зелений',
				          ) ),

			     ))
			     ->set_category( 'custom-category-home' )
			     ->set_icon('cover-image')

			     ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				     ?>

				     <?php if( !empty( $fields['title'] ) ):?>

				         <section class="main-screen home-main-screen"

						     <?php if( !empty( $fields['block_options_bg_color'] ) || !empty( $fields['block_options_text_color'] )):?>
							     style="<?php if ( !empty( $fields['block_options_bg_color'] ) ){echo 'background-color: '.$fields['block_options_bg_color'].';';} if ( !empty( $fields['block_options_text_color'] ) ){echo 'color: '.$fields['block_options_text_color'].';';}?>"
						     <?php endif;?>
						     >
                   <?php if( !empty($fields['bg_image']) ):?>
                     <div class="bg-image">
                       <img
                           src="<?php echo wp_get_attachment_image_src($fields['bg_image'], 'full')[0];?>"
			                   <?php
				                   $altText = get_post_meta($fields['bg_image'], '_wp_attachment_image_alt', TRUE);
				                   if ( !empty( $altText ) ):?>
                             alt="<?php echo $altText;?>"
				                   <?php else:?>
                             alt="<?php echo get_bloginfo('name');?>"
				                   <?php endif;?>

                       >
                     </div>
                   <?php endif;?>

				           <div class="container">
				             <div class="row">
                       <div class="content col-12">
                         <div class="text-content">
                           <h1 class="page-title">
			                       <?php echo str_replace(['<p>', '</p>'], '', $fields['title'] );?>
                           </h1>
		                       <?php if( !empty($fields['text']) ):?>
                             <p class="main-text"><?php echo str_replace(['<p>', '</p>'], '', $fields['text'] );?></p>
		                       <?php endif;?>
		                       <?php if ( !empty( $fields['btn_text'] ) ):?>
                             <div class="button big-btn <?php if ( !empty( $fields['block_option_btn_color'] ) ){echo $fields['block_option_btn_color'].'-btn';}else{echo 'basic-btn';}?>" data-bs-toggle="modal" data-bs-target="#formModal">
				                       <?php echo $fields['btn_text'];?>
                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                 <path d="M10.4391 8.1109C10.4391 7.83486 10.663 7.61113 10.939 7.61095L15.8888 7.61095L15.9896 7.62062C16.2174 7.66723 16.3887 7.86926 16.3887 8.1109V13.0606L16.379 13.1615C16.3324 13.3892 16.1303 13.5606 15.8888 13.5606C15.6473 13.5604 15.4451 13.3892 15.3985 13.1615L15.3888 13.0606V9.31795L8.46414 16.2426C8.26886 16.4377 7.95221 16.4378 7.75703 16.2426C7.56194 16.0474 7.56203 15.7308 7.75703 15.5355L14.6817 8.61084L10.939 8.61084C10.6631 8.61067 10.4391 8.38687 10.4391 8.1109Z" fill="#F9FCF5"/>
                               </svg>
                             </div>
		                       <?php endif;?>
                         </div>
                         <div class="more-info-wrapper">
		                       <?php if( $fields['more_info'] ):?>
                             <ul class="card-list-wrapper">
				                       <?php foreach( $fields['more_info'] as $item):?>
                                 <li class="card-item">
                                   <div class="pic-wrapper">
                                     <img
                                         src="<?php echo wp_get_attachment_image_src($item['image'], 'full')[0];?>"
								                       <?php
									                       $altText = get_post_meta($item['image'], '_wp_attachment_image_alt', TRUE);
									                       if ( !empty( $altText ) ):?>
                                           alt="<?php echo $altText;?>"
									                       <?php else:?>
                                           alt="<?php echo wp_strip_all_tags($item['title']);?>"
									                       <?php endif;?>

                                     >
                                   </div>
                                   <div class="info">
                                     <p class="name"><?php echo str_replace(['<p>', '</p>'], '', $item['title'] );?></p>
                                     <p class="description"><?php echo str_replace(['<p>', '</p>'], '', $item['description'] );?></p>
                                   </div>

						                       <?php if( !empty($item['more_text']) ):?>
                                     <p class="more-text">
	                                     <?php echo str_replace(['<p>', '</p>'], '', $item['more_text'] );?>
                                     </p>
						                       <?php endif;?>
                                 </li>

				                       <?php endforeach;?>
                             </ul>
		                       <?php endif;?>
		                       <?php if( $fields['location_text'] ):?>
                             <p class="location">
                               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="24" viewBox="0 0 17 24" fill="none">
                                 <path d="M8.5 11.4C7.69488 11.4 6.92273 11.0839 6.35343 10.5213C5.78412 9.95871 5.46429 9.19565 5.46429 8.4C5.46429 7.60435 5.78412 6.84129 6.35343 6.27868C6.92273 5.71607 7.69488 5.4 8.5 5.4C9.30512 5.4 10.0773 5.71607 10.6466 6.27868C11.2159 6.84129 11.5357 7.60435 11.5357 8.4C11.5357 8.79397 11.4572 9.18407 11.3046 9.54805C11.1521 9.91203 10.9285 10.2427 10.6466 10.5213C10.3647 10.7999 10.03 11.0209 9.66172 11.1716C9.29341 11.3224 8.89866 11.4 8.5 11.4ZM8.5 0C6.24566 0 4.08365 0.884997 2.48959 2.4603C0.895533 4.03561 0 6.17218 0 8.4C0 14.7 8.5 24 8.5 24C8.5 24 17 14.7 17 8.4C17 6.17218 16.1045 4.03561 14.5104 2.4603C12.9163 0.884997 10.7543 0 8.5 0Z" fill="#F2682C"/>
                               </svg>
                               <span><?php echo $fields['location_text'];?></span>

                             </p>
		                       <?php endif;?>
                         </div>
                       </div>
				             </div>
				           </div>
				         </section>
				     <?php endif;?>

				     <?php
			     } );
		}
