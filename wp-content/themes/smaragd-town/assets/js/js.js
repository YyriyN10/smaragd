jQuery(function($) {

  /**
   * Lazy load
   */
  $('.lazy').lazy();

  /**
   * Phone mask
   */

  $("input[type=tel]").mask("+38(099) 999-99-99");

  /**
   * Fixed Menu
   */

  $(document).scroll(function() {

    let scrollPosition = $(this).scrollTop();

    if ( scrollPosition > 1 ) {
      $('.site-header').addClass('fixed-header');
    } else {
      $('.site-header').removeClass('fixed-header');
    }
  });

  let positionScrollHeader = $(window).scrollTop();

  $(window).scroll(function() {

    let scroll = $(window).scrollTop();

    if( scroll > positionScrollHeader ) {

      $('#lang-nav').slideUp(200);
      $('#lang-btn').removeClass('active');

      if ( $('.header-navigation.open-menu').length ){
        $('.site-header').addClass('fixed-header-visible');
      }else{
        $('.site-header').removeClass('fixed-header-visible');
      }

    } else {
      $('.site-header').addClass('fixed-header-visible');

    }

    positionScrollHeader = scroll;

  });

  /**
   * Input focus animation
   */

  $('.form-group input').on('focus', function () {
    $(this).closest('label').find('.label').addClass('active');
  });

  $('.form-group input').on('blur', function () {
    $(this).closest('label').find('.label').removeClass('active');
  });

  /**
   * Fancybox Init
   */

  $('[data-fancybox]').fancybox({
    protect: true,
    loop : true,
    fullScreen : true,
    scrolling : 'yes',
    image : {
      preload : "auto",
      protect : true
    },
    buttons: [
      "zoom",
      "slideShow",
      "fullScreen",
      "close"
    ]

  });

  /**
   * Nav tabs
   */

  if ($('.nav-tabs').length){

    $('.nav-tabs .nav-item:first-child .nav-link').addClass('active');

    $('.tab-content .tab-pane:first-child').addClass('active');

    /*$('.building-types .nav-tabs .nav-item:first-child .nav-link').addClass('active');
    $('.building-types .tab-content .tab-pane:first-child').addClass('active');*/

    $('.progress-position').each(function () {
      let thisItem = $(this);
      let thisProgress = thisItem.attr('data-progress');

      thisItem.find('.progress-indicator').css('width', ''+thisProgress+'%');
    });

    function turnGallery($galleryList){

      let data = {
        action: 'change_turn_gallery',
        galleryList: $galleryList,
      };

      $.post( yuna_ajax.url, data, function(response) {

        if($.trim(response) !== ''){

          $('#building-progress').html(response);

          $("#building-progress").slick('refresh');
        }
      });
    }

    $('.nav-tabs').each(function () {
      let thisTabList = $(this);

      let galleryList = thisTabList.find('.nav-item:first-child .nav-link').attr('data-gallery');

      turnGallery(galleryList);

    });

    $('.building-progress .nav-link').on('click', function () {
      let galleryList = $(this).attr('data-gallery');

      turnGallery(galleryList);
    });


    $('#building-progress').slick({
      autoplay: false,
      autoplaySpeed: 5000,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      dots: true,
      fade: true
    });

  }

  /**
   * Swiper
   */

  const swiperInfrastructure = new Swiper("#infrastructure-slider", {
    slidesPerView: 4,
    spaceBetween: 24,
    scrollbar: {
      el: ".swiper-scrollbar",
      hide: true,
    },
  });


  /**
   * Form integratioin
   */

  let utmList = sessionStorage.getItem("utmList");

    if ( utmList ){
      storageUtm(utmList);
    }else{
      let currentUtmList = window.location.search.substring(1);

      if ( currentUtmList != '' ){
        sessionStorage.setItem("utmList", currentUtmList);

        storageUtm(currentUtmList);
      }
    }

    function storageUtm(utmList){

      let utmArray = utmList.split('&');

      function checkUtm(utmName) {
        for (let i = 0; i < utmArray.length; i++) {
          let pair = utmArray[i].split('=');
          if (decodeURIComponent(pair[0]) == utmName) {
            return decodeURIComponent(pair[1]);
          }
        }
      }

      let utm_source = checkUtm('utm_source') ? checkUtm('utm_source') : "";
      let utm_medium = checkUtm('utm_medium') ? checkUtm('utm_medium') : "";
      let utm_campaign = checkUtm('utm_campaign') ? checkUtm('utm_campaign') : "";
      let utm_term = checkUtm('utm_term') ? checkUtm('utm_term') : "";
      let utm_content = checkUtm('utm_content') ? checkUtm('utm_content') : "";


      let forms = $('form');
      $.each(forms, function (index, form) {
        let thisForm = $(form);
        thisForm.append('<input type="hidden" name="utm_source" value="' + utm_source + '">');
        thisForm.append('<input type="hidden" name="utm_medium" value="' + utm_medium + '">');
        thisForm.append('<input type="hidden" name="utm_campaign" value="' + utm_campaign + '">');
        thisForm.append('<input type="hidden" name="utm_term" value="' + utm_term + '">');
        thisForm.append('<input type="hidden" name="utm_content" value="' + utm_content + '">');

        let thisPageUrl = thisForm.find('input[name = page-url]').val();
        thisForm.find('input[name = page-url]').val(thisPageUrl + '?' + utmList);
      });
    }

    $('form').on('submit', function (e) {
      e.preventDefault();

      const thisForm = $(this);
      const formData = $(this).serialize();

      /*let thxPage = atob(thisForm.find('input[name = thx-page]').val());*/

      thisForm.find('.button').addClass('form-accepted');

      sessionStorage.removeItem("utmList");

      $.post( yuna_ajax.url, formData, function(response) {

        console.log(response);

        /*fbq("track","Lead");*/
        /*window.location.href = thxPage;*/

      });



    })


  //Get Window Width, Height

  /*let windWid = jQuery(window).width();
  let windHeig = jQuery(window).height();

  jQuery(window).resize(function () {
    windWid = jQuery(window).width();
    windHeig = jQuery(window).height();
  });*/





  //Mob Menu

  /*jQuery('#mob-menu').on('click', function (e) {
    e.preventDefault();

    jQuery(this).toggleClass('active');
    jQuery('header').toggleClass('active-menu');
    jQuery('header nav').toggleClass('open-menu');
    jQuery('html').toggleClass("fixedPosition");

  });*/

  //SCROLL MENU

  /*jQuery('#primary-menu li a').addClass('scroll-to');

  jQuery(document).on('click', '.scroll-to', function (e) {
    e.preventDefault();

    let href = jQuery(this).attr('href');

    jQuery('html, body').animate({
      scrollTop: jQuery(href).offset().top
    }, 1000);

  });*/

  //Смена категории курсов

  /*jQuery('.page-template-template-home .curses-cat-wrapper .cat').on('click', function (e) {
    e.preventDefault();

    jQuery('.page-template-template-home .curses-cat-wrapper .cat').removeClass('active-cat');

    jQuery(this).addClass('active-cat');

    var subCatId = jQuery(this).data('subcatid');

    var allCat = jQuery(this).data('allcat');

    var currentLang = jQuery(this).data('lang');

    var pageCatNavWrapper = jQuery('#mor-curses-dtn-wrap');

    var allCatPosts = Number(jQuery(this).attr('data-allposts'));

    pageCatNavWrapper.attr('data-allposts', allCatPosts);

    var targetAllPosts = Number(pageCatNavWrapper.attr('data-allposts'));

    if ( targetAllPosts <= 6 ){
      pageCatNavWrapper.addClass('d-none');
    }else{
      pageCatNavWrapper.removeClass('d-none');
    }

    let data = {

      action: 'change_curses_category',
      allCat: allCat,
      currentLang: currentLang,
      subCatId: subCatId
    };

    jQuery.post( myajax.url, data, function(response) {

      if(jQuery.trim(response) !== ''){

        jQuery('#curses-list').html(response);
      }
    });

  });*/

  //Вывод больше курсов

  /*if ( jQuery('.page-template-template-home').length ){

    var activeCat = jQuery('.curses-cat-wrapper .cat.active-cat');
    var allPosts = Number(activeCat.attr('data-allposts'));

    jQuery('#mor-curses-dtn-wrap').attr('data-allposts', allPosts);

    var targetAllPosts = Number(jQuery('#mor-curses-dtn-wrap').attr('data-allposts'));

    var btnMore = jQuery('#more-curses');

    btnMore.attr('data-currentcat', activeCat.attr('data-subcatid'));
    btnMore.attr('data-allcat', activeCat.attr('data-allcat'));

    btnMore.on('click', function (e) {
      e.preventDefault();

      var curseLeng = jQuery(this).attr('data-lang');
      var curseCurrentCat = Number(jQuery(this).attr('data-currentcat'));
      var curseAllCat = Number(jQuery(this).attr('data-allcat'));

      var moreCurses = {
        action: 'more_curses',
        currentLang: curseLeng,
        allCat: curseAllCat,
        currentCat: curseCurrentCat
      };

      jQuery.post( myajax.url, moreCurses, function(response) {

        if(jQuery.trim(response) !== ''){

          jQuery('#curses-list').append(response);
        }
      });

      jQuery('#mor-curses-dtn-wrap').addClass('d-none');

    });

  }*/



  //Webinar Countdown Timer

  /*if ( jQuery('.courses-template-template-webinar-page').length ){

    let startData = Number(jQuery('#timer').data('start'));

    const date = new Date(startData*1000);

    startData = new Date(date).getTime();

    // Update the count down every 1 second
    let dataTimer = setInterval(function() {

      // Get today's date and time
      let getDate = new Date().getTime();

      // Find the distance between now and the count down date
      let distance = startData - getDate;

      // Time calculations for days, hours, minutes and seconds
      let days = Math.floor(distance / (1000 * 60 * 60 * 24));
      let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      let seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Display the result in the element with id="demo"

      jQuery('#timer .day .date').text(days);
      jQuery('#timer .hour .date').text(hours);
      jQuery('#timer .minute .date').text(minutes);
      jQuery('#timer .second .date').text(seconds);


      // If the count down is finished, write some text
      if (distance < 0) {
        clearInterval(dataTimer);

      }
    }, 1000);

  }*/
    // MAP INIT

    /*function initMap() {
        var location = {
            lat: 48.268376,
            lng: 25.9301257
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: location,
            scrollwheel: false
        });

        var marker = new google.maps.Marker({
            position: location,
            map: map
        });

        var marker = new google.maps.Marker({ // кастомный марекр + подпись
            position: location,
            title:"Город, Улица, \n" +
            "Дом, Квартира",
            map: map,
            icon: {
                url: ('img/marker.svg'),
                scaledSize: new google.maps.Size(141, 128)
            }
        });

        jQuery.getJSON("map-style_dark.json", function(data) { // подключения стиля для гугл карты
            map.setOptions({styles: data});
        });

    }

    initMap();*/

    // MOB-MENU

    /*jQuery('#menu-btn').on('click', function (e) {
       e.preventDefault();

       jQuery('#mob-menu').toggleClass('active-menu');
       jQuery(this).toggleClass('open-menu');
    });

    jQuery('#mob-menu a').on('click', function (e) {
        e.preventDefault();

        jQuery('#mob-menu').removeClass('active-menu');
        jQuery('#menu-btn').removeClass('open-menu');
    });*/


    //SCROLL MENU

    /*jQuery(document).on('click', '.scroll-to', function (e) {
        e.preventDefault();

        var href = jQuery(this).attr('href');

        jQuery('html, body').animate({
            scrollTop: jQuery(href).offset().top
        }, 1000);

    });*/

    // CASTOME SLIDER ARROWS

    /*jQuery('.mein-slider').slick({
        autoplay: false,
        autoplaySpeed: 5000,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true

    });

    jQuery('.main-page .arrow-left').click(function(e){
        e.preventDefault();

        jQuery('.mein-slider').slick('slickPrev');
    });

    jQuery('.main-page .arrow-right').click(function(e){
        e.preventDefault();

        jQuery('.mein-slider').slick('slickNext');
    });*/



    // DTA VALUE REPLACE

    /*jQuery('.open-form').on('click', function (e) {
        e.preventDefault();
        var type = jQuery(this).data('type');
        jQuery('#type-form').find('input[name=type]').val(type);
    });*/

    // FORM LABEL FOCUS UP

    /*jQuery('.form-control').on('focus', function() {
        jQuery(this).closest('.form-control').find('label').addClass('active');
    });

    jQuery('.form-control').on('blur', function() {
        var jQuerythis = jQuery(this);
        if (jQuerythis.val() == '') {
            jQuerythis.closest('.form-control').find('label').removeClass('active');
        }
    });*/

    // SCROLL TOP.

    /*jQuery(document).on('click', '.up-btn', function() {
        jQuery('html, body').animate({
            scrollTop: 0
        }, 300);
    });*/

    // SHOW SCROLL TOP BUTTON.

    /*jQuery(document).scroll(function() {
        var y = jQuery(this).scrollTop();

        if (y > 800) {
            jQuery('.up-btn').fadeIn();
        } else {
            jQuery('.up-btn').fadeOut();
        }
    });*/

    // UTM

    /*function getQueryVariable(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split('&');
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            if (decodeURIComponent(pair[0]) == variable) {
                return decodeURIComponent(pair[1]);
            }
        }
    }
    utm_source = getQueryVariable('utm_source') ? getQueryVariable('utm_source') : "";
    utm_medium = getQueryVariable('utm_medium') ? getQueryVariable('utm_medium') : "";
    utm_campaign = getQueryVariable('utm_campaign') ? getQueryVariable('utm_campaign') : "";
    utm_term = getQueryVariable('utm_term') ? getQueryVariable('utm_term') : "";
    utm_content = getQueryVariable('utm_content') ? getQueryVariable('utm_content') : "";

    var forms = jQuery('form');
    jQuery.each(forms, function (index, form) {
        jQueryform = jQuery(form);
        jQueryform.append('<input type="hidden" name="utm_source" value="' + utm_source + '">');
        jQueryform.append('<input type="hidden" name="utm_medium" value="' + utm_medium + '">');
        jQueryform.append('<input type="hidden" name="utm_campaign" value="' + utm_campaign + '">');
        jQueryform.append('<input type="hidden" name="utm_term" value="' + utm_term + '">');
        jQueryform.append('<input type="hidden" name="utm_content" value="' + utm_content + '">');
    });*/

});

// PRELOADER

/*jQuery(window).on('load', function () {

    jQuery('#loader').fadeOut(400);
});*/
