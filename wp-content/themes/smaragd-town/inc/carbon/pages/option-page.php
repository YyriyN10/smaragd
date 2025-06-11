<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}


	/*function lang_list(){
		$siteLangSlug = pll_languages_list(array('hide_empty' => 0, 'fields' => 'slug'));
		$siteLangName = pll_languages_list(array('hide_empty' => 0, 'fields' => 'name'));
		$langList = [];

		for ($i = 0; $i<count($siteLangSlug); $i++){
			$langList +=[$siteLangSlug[$i] => $siteLangName[$i]];
		}

		return $langList;
	}*/


	use Carbon_Fields\Container;
	use Carbon_Fields\Field;

	add_action( 'carbon_fields_register_fields', 'yuna_site_options' );

	function yuna_site_options(){
		Container::make( 'theme_options', 'Опції сайту' )
		         ->set_icon( 'dashicons-admin-tools' )
		         ->add_tab('Головні', array(
			         Field::make_image('option_site_logo', 'Логотип')
			              ->set_value_type('url'),
			         Field::make_text('option_site_copy_text', 'Текст копірайту, без року'),
			         Field::make_text('option_sales_address', 'Адреса відділу продажів'),
			         Field::make_text('option_work_schedule', 'Розклад роботи'),
			         Field::make_complex('option_phone_list', 'Контактні телефони')
			          ->add_fields(array(
			          	Field::make_text('phone', 'Телефонний номер')
				            ->set_attribute('type', 'tel')
			          )),
			         Field::make_complex('option_email_list', 'Електронні скриньки')
			              ->add_fields(array(
				              Field::make_text('email', 'Електронна скринька')
				                   ->set_attribute('type', 'email')
			              )),
			         Field::make_map('option_object_location', 'Розташування обʼєкту на мапі')

		         ))
							->add_tab('Сторінка входу', array(
								Field::make_radio('option_login_page_logo_or_text', 'Обрати тип брендінгу')
									->set_width(50)
									->add_options( array(
										'logo' => 'Зображення логотипу',
										'text' => 'Текстова назва',
									) ),
								Field::make_text('option_login_page_site_name', 'Імʼя сайту')
									->set_conditional_logic( array(
										'relation' => 'AND',
										array(
											'field' => 'option_login_page_logo_or_text',
											'value' => 'text',
											'compare' => '=',
										)
									) )
									->set_width(50),
								Field::make_image('option_login_page_logo_image', 'Зображення логотипу на сторінці входу')
								     ->set_conditional_logic( array(
									     'relation' => 'AND',
									     array(
										     'field' => 'option_login_page_logo_or_text',
										     'value' => 'logo',
										     'compare' => '=',
									     )
								     ) )
								     ->set_width(50)
								     ->set_value_type('url'),
								Field::make_color('option_login_page_accent_color', 'Акцентний колір')
									->set_width(50),
								Field::make_color('option_login_page_bg_color', 'Колір тла')
								     ->set_width(50),
							))
							->add_tab('Інтегріції форм', array(
								Field::make_separator('option_separator_1', 'Налштування для Telegram'),
								Field::make_text('option_integration_telegram_api_key', 'API KEY Телеграм боту')
									->set_width(50),
								Field::make_text('option_integration_telegram_chat_id', 'ID чату в Телеграм куди надсилати повідомлення')
									->set_width(50),
								Field::make_separator('option_separator_2', 'Налштування для Email'),
								Field::make_complex('option_integration_email_list', 'Перелік пошт на які приходять сповіщення')
									->add_fields(array(
										Field::make_text('email', 'Пошта')
											->set_attribute('type', 'email')
									)),
								Field::make_separator('option_separator_3', 'Налштування для KeyCrm'),
								Field::make_text('option_integration_key_crm_api_key', 'API KEY')
									->set_width(50),
								Field::make_text('option_integration_key_crm_source_id', 'ID джерела')
									->set_width(50)
									->set_attribute('type', 'number'),
								Field::make_text('option_integration_key_crm_manager_id', 'ID менеджера')
								     ->set_width(50)
								     ->set_attribute('type', 'number'),
								Field::make_select('option_integration_key_crm_lid_target', 'Де має створюватись заявка')
									->set_width(50)
									->add_options( array(
										'/pipelines/cards' => 'Створення нової картки у воронці',
										'/order' => 'Створення нового замовлення',

									) ),
								Field::make_separator('option_separator_thx', 'Перенаправлення після відправки форми'),
								Field::make_association('option_thx_page', 'Сторінка подяки')
								     ->set_max(1)
								     ->set_required(false)
								     ->set_types( array(
									     array(
										     'type' => 'post',
										     'post_type' => 'page',
									     )
								     ) ),

							))
		         ->add_tab('Футер', array(
		         	  Field::make_text('option_site_footer_form_title', 'Заголовок форми'),
			          Field::make_text('option_site_footer_form_sub_title', 'Підзаголовок форми'),
			          Field::make_text('option_site_footer_form_btn_text', 'Текст кнопки'),
			          Field::make_text('option_site_footer_contacts_title', 'Заголовок блоку контактів'),
			          Field::make_text('option_site_footer_social_title', 'Заголовок блоку соціальних мереж'),
			          Field::make_text('option_site_footer_sale_title', 'Заголовок блоку відділу продажів'),
		         ))
							->add_tab('Сторінка 404', array(
								Field::make_text('option_site_404_title', 'Заголовок'),
								Field::make_text('option_site_404_text', 'Текст'),

								Field::make_image('option_site_404_image', 'Зображення')
							))
		         ->add_tab('Соціальні мережі', array(
			         Field::make_complex('option_site_social_networks', 'Перелік соціальних мереж')
			              ->add_fields(array(
				              Field::make_text('name', 'Назва')
				                   ->set_required(true),
				              Field::make_text('link', 'Посилання')
				                   ->set_required(true)
				                   ->set_attribute('type', 'url'),
				              Field::make_image('icon', 'Іконка')
				                   ->set_value_type('url')
				                   ->set_required(true)
			              ))
		         ));


	}
