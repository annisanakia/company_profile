/*!
 *
 *  Web Starter Kit
 *  Copyright 2015 Google Inc. All rights reserved.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *    https://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License
 *
 */
/* eslint-env browser */
(function() {
    'use strict';
  
    // Check to make sure service workers are supported in the current browser,
    // and that the current page is accessed from a secure origin. Using a
    // service worker from an insecure origin will trigger JS console errors. See
    // http://www.chromium.org/Home/chromium-security/prefer-secure-origins-for-powerful-new-features
  
    $.fn.visible = function(partial) {
      
          var $t            = $(this),
              $w            = $(window),
              viewTop       = $w.scrollTop(),
              viewBottom    = viewTop + $w.height(),
              _top          = $t.offset().top - 100,
              _bottom       = _top + $t.height(),
              compareTop    = partial === true ? _bottom : _top,
              compareBottom = partial === true ? _top : _bottom;
        
        return ((compareBottom <= viewBottom));
      //   return ((compareBottom <= viewBottom) && (compareTop >= viewTop));
      };
  
      $(window).scroll(function(event) {
        $(".animated").each(function(i, el) {
            var el = $(el);
            if (el.visible(true)) {
                el.addClass("inview"); 
            } else {
            //el.removeClass("inview");
            }
        });
    });

  
    // Your custom JavaScript goes here
    $(document).ready(function(){
        $(".animated.now").each(function(i, el) {
            var el = $(el);
            if (el.visible(true)) {
                el.addClass("inview"); 
            } else {
            //el.removeClass("inview");
            }
        });
      $('.hero-home').slick({
        infinite: false,
        fade: false,
        dots: true,
        speed: 1000,
        arrows: false,
        //autoplay: true,
        autoplaySpeed: 2000,
      });
  
      setTimeout(function(){
        $('.main-header .animated').addClass('inview');
      }, 1000);
  
      if ($('.section-hero').length){
              setTimeout(function(){
          $('.hero-slide.slide0 .animated').addClass('inview');
          $('.main-header .animated').addClass('inview');
          $('.section-hero .slick-dots').addClass('inview');
          $('.section-hero .section-next').addClass('inview');
        }, 1000);
        setTimeout(function(){
          $('.hero-slide.slide0').addClass('inview');
              }, 1500);
      }
  
      if ($('.about-page').length){
              setTimeout(function(){
          $('.hero-about .animated').addClass('inview');
          $('.section-pricing .animated-auto').addClass('inview');
        }, 1000);
      }
      if ($('.hero-auth').length){
        setTimeout(function(){
          $('.hero-auth .animated').addClass('inview');
        }, 1000);
      }
      if ($('.hero-request').length){
        setTimeout(function(){
          $('.hero-request .animated').addClass('inview');
        }, 1000);
      }
      if ($('.info-page').length){
        setTimeout(function(){
          $('.info-page .animated').addClass('inview');
        }, 1000);
      }
  
      if ($('.section-price').length){
        setTimeout(function(){
          $('.section-price > h1.animated').addClass('inview');
          $('.section-price .card.animated').addClass('inview');
          $('.section-price h2 .animated').addClass('inview');
        }, 1000);
        setTimeout(function(){
          $(".section-price .accordion.animated").each(function(i, el) {
            var el = $(el);
            if (el.visible(true)) {
              el.delay(500 * i).addClass("inview"); 
            }
          });
              }, 3000);
      }
  
      if ($('.section-feature').length){
        setTimeout(function(){
          $('.section-feature h1.animated').addClass('inview');
          $('.section-feature p.animated').addClass('inview');
          $('.section-feature .hero-img.animated').addClass('inview');
        }, 1000);
        setTimeout(function(){
          $(".section-feature .acc-list.animated").each(function(i, el) {
            var el = $(el);
            if (el.visible(true)) {
              el.delay(1000 * i).addClass("inview"); 
            }
          });
        }, 4000);
        
        $('.special-links a[data-link]').click(function(e){
          e.preventDefault();
          var currentItem = $('#'+$(this).attr('data-link'));
          currentItem.addClass('active');
          currentItem.find('ul').slideDown();
          $('.acc-list').not(currentItem).removeClass('active');
          $('.acc-list ul').not(currentItem.children('ul')).slideUp();
        });
      }
      if ($('.section-solutions').length){
        if(window.location.hash){
          window.scrollTo(0, 0); // execute it straight away
          setTimeout(function() {
            window.scrollTo(0, 0); // run it a bit later also for browser compatibility
          }, 2);
          
          $('[href="'+window.location.hash+'"]').parent().addClass('active');
          $('.tabs-content '+ window.location.hash).addClass('tabs-active');
          if(!$('.tabs-content '+ window.location.hash).hasClass('tabs-dark')){
            $('body').addClass('is-light');
          }else{
            $('body').removeClass('is-light');
          }
        }else{
          $('.tabs-toggle li').eq(0).addClass('active');
          $('.tabs-content > div').eq(0).addClass('tabs-active');
        }
  
        setTimeout(function(){
          $('.section-solutions h1.animated').addClass('inview');
          $('.section-solutions p.animated').addClass('inview');
          $('.section-solutions h3.animated').addClass('inview');
          $('.section-solutions .tabs-active .tabs-bg').fadeIn();
        }, 1000);
        setTimeout(function(){
          $(".section-solutions .tabs-toggle > li").each(function(i, el) {
            var el = $(el);
            setTimeout(function(){
              el.addClass('inview');
            },(100 * i))
          });
        }, 3000);
        setTimeout(function(){
          $(".section-solutions .tabs-active ul > li").each(function(i, el) {
            var el = $(el);
            setTimeout(function(){
              el.addClass('inview');
            },(100 * i))
          });
        }, 4000);
      }
  
      
      $('.hero-home').on('afterChange', function(event, slick, currentSlide){
        var currentShow = $('.hero-slide.slide'+currentSlide);
        currentShow.addClass('inview');
        $('.hero-slide').not(currentShow).removeClass('inview');
      });
      // $('.hero-home').on('beforeChange', function(event, slick, currentSlide, nextSlide){
      //   $('.hero-slide.slide'+currentSlide).removeClass('inview');
      //   $('.hero-slide.slide'+nextSlide).addClass('inview');
      // });
  
  
      $('.customer-slider').slick({
        fade: true,
        dots: true,
        speed: 500,
        arrows: false
      });
  
      $('.team-slider').slick({
        fade: true,
        dots: true,
        speed: 500,
        arrows: false
      });
        
      $('.btn-scroll').click(function(e){
        e.preventDefault();
        var scrollTarget = $($(this).attr('href'));
              $('html, body').animate({
                  scrollTop: scrollTarget.offset().top
              }, 1500);
      });
      
      $('.pop-btn').click(function(e){
        e.preventDefault();
        var currentPop = $(this).closest('.pop-group');
        currentPop.toggleClass('open');
        $('.pop-group').not(currentPop).removeClass('open');
      });
      
  
      $('.btn-toggle').click(function(e){
        e.preventDefault();
        var targetId = $('#'+$(this).attr('show-for'));
        targetId.toggleClass('open');
        $('.toggled-item').not(targetId).removeClass('open');
        $(this).addClass('active');
        $('.btn-toggle').not(this).removeClass('active');
      });
  
      $('body').mouseup(function(e) 
      {
          var targetDiv = $(".h-dropdown");
          if (!targetDiv.is(e.target) && targetDiv.has(e.target).length === 0) 
          {
            targetDiv.removeClass('show');
          }
      });
  
      $('.category-options>li').click(function(){
        $(this).toggleClass('checked');
        var currentCheckbox = $(this).find('input[type="checkbox"]');
        $('#btn-choose-category').addClass('btn-solid').text('Done');
        if ($(this).hasClass('checked')){
          currentCheckbox.prop('checked', true);
        }
        else{
          currentCheckbox.prop('checked', false);
        }
      });
  
      $('.btn-step').click(function(){
        var currentStep = $(this).attr('goto-step');
        $('.steps-wrapper').attr('current-step', currentStep);
        $('#'+currentStep).addClass('open');
        $('.signup-step').not('#'+currentStep).removeClass('open');
        var indicatorStep = $('.step-indicator>li[step-for="'+ currentStep +'"]');
        indicatorStep.addClass('complete');
        $('.step-indicator>li').not(indicatorStep).removeClass('complete');
      });
  
      $(".field-range").change(function(){
        var range1 = $('.field-range:first').val();
        var range2 = $('.field-range:last').val();
        // Neither slider will clip the other, so make sure we determine which is larger
        if( range1 > range2 ){ var tmp = range2; range2 = range1; range1 = tmp; }
        $(".range-values .min").text("$ " + range1);
        $(".range-values .max").text("$ " + range2);
      });
  
      $('.rating').click(function(){
        $(this).addClass('active');
        $('.rating').not(this).removeClass('active');
        var currentStar = $(this).find('input[type="radio"]');
        if($(this).hasClass('active')){
          currentStar.prop('checked', true);
        }
        else{
          currentStar.prop('checked', false);
        }
      });
  
      $('.btn-change-photo').click(function(){
        
      });
      
      $('.tabs a').click(function(e){
        e.preventDefault();
        var target = $(this).attr('href');
        $(this).parent().siblings().removeClass('active');
        $(this).parent().addClass('active');      
        $('.tabs-content div').removeClass('tabs-active');
        $('.tabs-content div li').removeClass('inview');
        $('.tabs-content .animated').removeClass(function(index, css) {
          return (css.match(/(d-[0-9][0-9])/g) || []).join(' ');
        });
        $('.tabs-content .animated').removeClass('inview');
        setTimeout(function(){
          $(target).find('h3').addClass('inview');
          $(target).find('p').addClass('inview');
          $(target).find('.img-details').addClass('inview');
        }, 100);
        $('.tabs-content').find(target).addClass('tabs-active');
        $('.tabs-content').find(target).find('.tabs-bg').fadeIn(1000);
        setTimeout(function(){
          $('.tabs-content').find(target).find('li').each(function(i, el) {
            var el = $(el);
            setTimeout(function(){
              el.addClass('inview');
            },(100 * i))
          });
        }, 1000);
        if(!$('.tabs-content').find(target).hasClass('tabs-dark')){
          $('body').addClass('is-light');
        }else{
          $('body').removeClass('is-light');
        }
      });
      $('.content-list li').click(function(){
        var currentImg = $('#' + $(this).attr('show-img'));
        $(this).addClass('active');
        $(this).siblings('li').removeClass('active');
        currentImg.addClass('active');
        currentImg.siblings('img').removeClass('active');
      });
  
      $('.card-tabs a').click(function(e){
        e.preventDefault();
        var target = $(this).attr('href');
        $(this).parent().siblings().removeClass('active');
        $(this).parent().addClass('active');      
        $('.tabs-contents').removeClass('tabs-active');
        $('.tabs-contents .animated').removeClass('inview');
        $('.tabs-contents .animated').removeClass(function(index, css) {
          return (css.match(/(d-[0-9][0-9])/g) || []).join(' ');
        });
        $(target).addClass('tabs-active');
        setTimeout(function(){
          $(target).find('.animated').addClass('inview delay1');
        }, 100)
        
      });
  
      if($('.accordion').length){
        $('.accordion.active').find('ul').delay(5000).slideDown();
      }
      
      $('.accordion .accordion-toggle').click(function(e) {
          var dropDown = $(this).siblings('.accordion-content').find('ul');
  
          $(this).parents('.accordion-wrap').find('ul').not(dropDown).slideUp(1000);
  
          if ($(this).parent().hasClass('active')) {
              $(this).parent().removeClass('active');
          } else {
              $(this).parent().closest('.active').removeClass('active');
              $(this).parent().addClass('active');
          }
  
          dropDown.stop(false, true).slideToggle(500);
  
          e.preventDefault();
      });
  
      if($('.acc-list').length){
        console.log(window.location.hash);
        if(window.location.hash){
          window.scrollTo(0, 0); // execute it straight away
          setTimeout(function() {
            window.scrollTo(0, 0); // run it a bit later also for browser compatibility
          }, 1);
          $('.acc-list'+ window.location.hash).addClass('active').find('ul').delay(5000).slideDown();
          $('.acc-list'+ window.location.hash).find('a').text('Show Less');
        }else{
          $('.acc-list').eq(0).addClass('active').find('ul').delay(5000).slideDown();
          $('.acc-list').eq(0).find('a').text('Show Less');
          
        }
      }
      $('.acc-list a').click(function(e) {
        var dropDown = $(this).siblings('ul');
  
        $('.acc-list ul').not(dropDown).slideUp();
        if ($(this).parent().hasClass('active')) {
            $(this).text('Show More');
            $(this).parent().removeClass('active');
        } else {
            $(this).parents('.hero-content').find('.active').find('a').text('Show More');
            $(this).parents('.hero-content').find('.active').removeClass('active');
            $(this).parent().addClass('active');
            $(this).text('Show Less');
        }
  
        dropDown.stop(false, true).slideToggle();
  
        e.preventDefault();
      });
  
      $('.btn-menu').click(function(){
        $(this).toggleClass('open');
        $(this).parent('.main-header').toggleClass('open');
      });
  
      $('.btn-dialog').click(function(e){
        e.preventDefault();
        var currentDialog = $('#'+ $(this).attr('show-dialog'));
        currentDialog.addClass('open');
        $('.mdl-dialog-wrap').not(currentDialog).removeClass('open');
      });
      $('.btn-close').click(function(){
        $(this).closest('.mdl-dialog-wrap').removeClass('open');
      });
    });
    
  })();