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
  
  //# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiIiwic291cmNlcyI6WyJtYWluLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIi8qIVxuICpcbiAqICBXZWIgU3RhcnRlciBLaXRcbiAqICBDb3B5cmlnaHQgMjAxNSBHb29nbGUgSW5jLiBBbGwgcmlnaHRzIHJlc2VydmVkLlxuICpcbiAqICBMaWNlbnNlZCB1bmRlciB0aGUgQXBhY2hlIExpY2Vuc2UsIFZlcnNpb24gMi4wICh0aGUgXCJMaWNlbnNlXCIpO1xuICogIHlvdSBtYXkgbm90IHVzZSB0aGlzIGZpbGUgZXhjZXB0IGluIGNvbXBsaWFuY2Ugd2l0aCB0aGUgTGljZW5zZS5cbiAqICBZb3UgbWF5IG9idGFpbiBhIGNvcHkgb2YgdGhlIExpY2Vuc2UgYXRcbiAqXG4gKiAgICBodHRwczovL3d3dy5hcGFjaGUub3JnL2xpY2Vuc2VzL0xJQ0VOU0UtMi4wXG4gKlxuICogIFVubGVzcyByZXF1aXJlZCBieSBhcHBsaWNhYmxlIGxhdyBvciBhZ3JlZWQgdG8gaW4gd3JpdGluZywgc29mdHdhcmVcbiAqICBkaXN0cmlidXRlZCB1bmRlciB0aGUgTGljZW5zZSBpcyBkaXN0cmlidXRlZCBvbiBhbiBcIkFTIElTXCIgQkFTSVMsXG4gKiAgV0lUSE9VVCBXQVJSQU5USUVTIE9SIENPTkRJVElPTlMgT0YgQU5ZIEtJTkQsIGVpdGhlciBleHByZXNzIG9yIGltcGxpZWQuXG4gKiAgU2VlIHRoZSBMaWNlbnNlIGZvciB0aGUgc3BlY2lmaWMgbGFuZ3VhZ2UgZ292ZXJuaW5nIHBlcm1pc3Npb25zIGFuZFxuICogIGxpbWl0YXRpb25zIHVuZGVyIHRoZSBMaWNlbnNlXG4gKlxuICovXG4vKiBlc2xpbnQtZW52IGJyb3dzZXIgKi9cbihmdW5jdGlvbigpIHtcbiAgJ3VzZSBzdHJpY3QnO1xuXG4gIC8vIENoZWNrIHRvIG1ha2Ugc3VyZSBzZXJ2aWNlIHdvcmtlcnMgYXJlIHN1cHBvcnRlZCBpbiB0aGUgY3VycmVudCBicm93c2VyLFxuICAvLyBhbmQgdGhhdCB0aGUgY3VycmVudCBwYWdlIGlzIGFjY2Vzc2VkIGZyb20gYSBzZWN1cmUgb3JpZ2luLiBVc2luZyBhXG4gIC8vIHNlcnZpY2Ugd29ya2VyIGZyb20gYW4gaW5zZWN1cmUgb3JpZ2luIHdpbGwgdHJpZ2dlciBKUyBjb25zb2xlIGVycm9ycy4gU2VlXG4gIC8vIGh0dHA6Ly93d3cuY2hyb21pdW0ub3JnL0hvbWUvY2hyb21pdW0tc2VjdXJpdHkvcHJlZmVyLXNlY3VyZS1vcmlnaW5zLWZvci1wb3dlcmZ1bC1uZXctZmVhdHVyZXNcbiAgdmFyIGlzTG9jYWxob3N0ID0gQm9vbGVhbih3aW5kb3cubG9jYXRpb24uaG9zdG5hbWUgPT09ICdsb2NhbGhvc3QnIHx8XG4gICAgICAvLyBbOjoxXSBpcyB0aGUgSVB2NiBsb2NhbGhvc3QgYWRkcmVzcy5cbiAgICAgIHdpbmRvdy5sb2NhdGlvbi5ob3N0bmFtZSA9PT0gJ1s6OjFdJyB8fFxuICAgICAgLy8gMTI3LjAuMC4xLzggaXMgY29uc2lkZXJlZCBsb2NhbGhvc3QgZm9yIElQdjQuXG4gICAgICB3aW5kb3cubG9jYXRpb24uaG9zdG5hbWUubWF0Y2goXG4gICAgICAgIC9eMTI3KD86XFwuKD86MjVbMC01XXwyWzAtNF1bMC05XXxbMDFdP1swLTldWzAtOV0/KSl7M30kL1xuICAgICAgKVxuICAgICk7XG5cbiAgaWYgKCdzZXJ2aWNlV29ya2VyJyBpbiBuYXZpZ2F0b3IgJiZcbiAgICAgICh3aW5kb3cubG9jYXRpb24ucHJvdG9jb2wgPT09ICdodHRwczonIHx8IGlzTG9jYWxob3N0KSkge1xuICAgIG5hdmlnYXRvci5zZXJ2aWNlV29ya2VyLnJlZ2lzdGVyKCdzZXJ2aWNlLXdvcmtlci5qcycpXG4gICAgLnRoZW4oZnVuY3Rpb24ocmVnaXN0cmF0aW9uKSB7XG4gICAgICAvLyB1cGRhdGVmb3VuZCBpcyBmaXJlZCBpZiBzZXJ2aWNlLXdvcmtlci5qcyBjaGFuZ2VzLlxuICAgICAgcmVnaXN0cmF0aW9uLm9udXBkYXRlZm91bmQgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgLy8gdXBkYXRlZm91bmQgaXMgYWxzbyBmaXJlZCB0aGUgdmVyeSBmaXJzdCB0aW1lIHRoZSBTVyBpcyBpbnN0YWxsZWQsXG4gICAgICAgIC8vIGFuZCB0aGVyZSdzIG5vIG5lZWQgdG8gcHJvbXB0IGZvciBhIHJlbG9hZCBhdCB0aGF0IHBvaW50LlxuICAgICAgICAvLyBTbyBjaGVjayBoZXJlIHRvIHNlZSBpZiB0aGUgcGFnZSBpcyBhbHJlYWR5IGNvbnRyb2xsZWQsXG4gICAgICAgIC8vIGkuZS4gd2hldGhlciB0aGVyZSdzIGFuIGV4aXN0aW5nIHNlcnZpY2Ugd29ya2VyLlxuICAgICAgICBpZiAobmF2aWdhdG9yLnNlcnZpY2VXb3JrZXIuY29udHJvbGxlcikge1xuICAgICAgICAgIC8vIFRoZSB1cGRhdGVmb3VuZCBldmVudCBpbXBsaWVzIHRoYXQgcmVnaXN0cmF0aW9uLmluc3RhbGxpbmcgaXMgc2V0OlxuICAgICAgICAgIC8vIGh0dHBzOi8vc2xpZ2h0bHlvZmYuZ2l0aHViLmlvL1NlcnZpY2VXb3JrZXIvc3BlYy9zZXJ2aWNlX3dvcmtlci9pbmRleC5odG1sI3NlcnZpY2Utd29ya2VyLWNvbnRhaW5lci11cGRhdGVmb3VuZC1ldmVudFxuICAgICAgICAgIHZhciBpbnN0YWxsaW5nV29ya2VyID0gcmVnaXN0cmF0aW9uLmluc3RhbGxpbmc7XG5cbiAgICAgICAgICBpbnN0YWxsaW5nV29ya2VyLm9uc3RhdGVjaGFuZ2UgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIHN3aXRjaCAoaW5zdGFsbGluZ1dvcmtlci5zdGF0ZSkge1xuICAgICAgICAgICAgICBjYXNlICdpbnN0YWxsZWQnOlxuICAgICAgICAgICAgICAgIC8vIEF0IHRoaXMgcG9pbnQsIHRoZSBvbGQgY29udGVudCB3aWxsIGhhdmUgYmVlbiBwdXJnZWQgYW5kIHRoZVxuICAgICAgICAgICAgICAgIC8vIGZyZXNoIGNvbnRlbnQgd2lsbCBoYXZlIGJlZW4gYWRkZWQgdG8gdGhlIGNhY2hlLlxuICAgICAgICAgICAgICAgIC8vIEl0J3MgdGhlIHBlcmZlY3QgdGltZSB0byBkaXNwbGF5IGEgXCJOZXcgY29udGVudCBpc1xuICAgICAgICAgICAgICAgIC8vIGF2YWlsYWJsZTsgcGxlYXNlIHJlZnJlc2guXCIgbWVzc2FnZSBpbiB0aGUgcGFnZSdzIGludGVyZmFjZS5cbiAgICAgICAgICAgICAgICBicmVhaztcblxuICAgICAgICAgICAgICBjYXNlICdyZWR1bmRhbnQnOlxuICAgICAgICAgICAgICAgIHRocm93IG5ldyBFcnJvcignVGhlIGluc3RhbGxpbmcgJyArXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICdzZXJ2aWNlIHdvcmtlciBiZWNhbWUgcmVkdW5kYW50LicpO1xuXG4gICAgICAgICAgICAgIGRlZmF1bHQ6XG4gICAgICAgICAgICAgICAgLy8gSWdub3JlXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgICAgfTtcbiAgICB9KS5jYXRjaChmdW5jdGlvbihlKSB7XG4gICAgICBjb25zb2xlLmVycm9yKCdFcnJvciBkdXJpbmcgc2VydmljZSB3b3JrZXIgcmVnaXN0cmF0aW9uOicsIGUpO1xuICAgIH0pO1xuICB9XG5cbiAgJC5mbi52aXNpYmxlID0gZnVuY3Rpb24ocGFydGlhbCkge1xuICAgIFxuXHRcdHZhciAkdCAgICAgICAgICAgID0gJCh0aGlzKSxcblx0XHRcdCR3ICAgICAgICAgICAgPSAkKHdpbmRvdyksXG5cdFx0XHR2aWV3VG9wICAgICAgID0gJHcuc2Nyb2xsVG9wKCksXG5cdFx0XHR2aWV3Qm90dG9tICAgID0gdmlld1RvcCArICR3LmhlaWdodCgpLFxuXHRcdFx0X3RvcCAgICAgICAgICA9ICR0Lm9mZnNldCgpLnRvcCAtIDEwMCxcblx0XHRcdF9ib3R0b20gICAgICAgPSBfdG9wICsgJHQuaGVpZ2h0KCksXG5cdFx0XHRjb21wYXJlVG9wICAgID0gcGFydGlhbCA9PT0gdHJ1ZSA/IF9ib3R0b20gOiBfdG9wLFxuXHRcdFx0Y29tcGFyZUJvdHRvbSA9IHBhcnRpYWwgPT09IHRydWUgPyBfdG9wIDogX2JvdHRvbTtcblx0ICBcblx0ICByZXR1cm4gKChjb21wYXJlQm90dG9tIDw9IHZpZXdCb3R0b20pKTtcblx0Ly8gICByZXR1cm4gKChjb21wYXJlQm90dG9tIDw9IHZpZXdCb3R0b20pICYmIChjb21wYXJlVG9wID49IHZpZXdUb3ApKTtcblx0fTtcblxuXHQkKHdpbmRvdykuc2Nyb2xsKGZ1bmN0aW9uKGV2ZW50KSB7XG5cdFx0JChcIi5hbmltYXRlZFwiKS5lYWNoKGZ1bmN0aW9uKGksIGVsKSB7XG5cdFx0XHR2YXIgZWwgPSAkKGVsKTtcblx0XHRcdGlmIChlbC52aXNpYmxlKHRydWUpKSB7XG5cdFx0XHQgIGVsLmFkZENsYXNzKFwiaW52aWV3XCIpOyBcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHQgIC8vZWwucmVtb3ZlQ2xhc3MoXCJpbnZpZXdcIik7XG5cdFx0XHR9XG4gICAgfSk7XG4gIH0pO1xuICAkKHdpbmRvdykub24oJ3Njcm9sbCcsZnVuY3Rpb24oKXtcbiAgICB2YXIgY291bnRzID0gJCgnLnBpbnRyby1jb3VudHMnKTtcbiAgICBpZihjb3VudHMubGVuZ3RoKXtcbiAgICAgIGlmIChjb3VudHMudmlzaWJsZSh0cnVlKSkge1xuICAgICAgICAkKCcuY291bnQnKS5lYWNoKGZ1bmN0aW9uKCkge1xuICAgICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyksXG4gICAgICAgICAgICAgIGNvdW50VG8gPSAkdGhpcy5hdHRyKCdkYXRhLWNvdW50Jyk7XG4gICAgICAgICAgXG4gICAgICAgICAgJCh7IGNvdW50TnVtOiAkdGhpcy50ZXh0KCl9KS5hbmltYXRlKHtcbiAgICAgICAgICAgIGNvdW50TnVtOiBjb3VudFRvXG4gICAgICAgICAgfSxcbiAgICAgICAgICB7XG4gICAgICAgICAgICBkdXJhdGlvbjogMTUwMCxcbiAgICAgICAgICAgIGVhc2luZzonc3dpbmcnLFxuICAgICAgICAgICAgc3RlcDogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICR0aGlzLnRleHQoTWF0aC5mbG9vcih0aGlzLmNvdW50TnVtKSk7XG4gICAgICAgICAgICB9LFxuICAgICAgICAgICAgY29tcGxldGU6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAkdGhpcy50ZXh0KHRoaXMuY291bnROdW0pO1xuICAgICAgICAgICAgICAvL2FsZXJ0KCdmaW5pc2hlZCcpO1xuICAgICAgICAgICAgfVxuICAgICAgICBcbiAgICAgICAgICB9KTsgIFxuICAgICAgICB9KTtcbiAgICAgIH1cbiAgICB9XG4gIH0pO1xuXG4gIC8vIFlvdXIgY3VzdG9tIEphdmFTY3JpcHQgZ29lcyBoZXJlXG4gICQoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCl7XG4gICAgJCgnLmhlcm8taG9tZScpLnNsaWNrKHtcbiAgICAgIGluZmluaXRlOiBmYWxzZSxcbiAgICAgIGZhZGU6IGZhbHNlLFxuICAgICAgZG90czogdHJ1ZSxcbiAgICAgIHNwZWVkOiAxMDAwLFxuICAgICAgYXJyb3dzOiBmYWxzZSxcbiAgICAgIC8vYXV0b3BsYXk6IHRydWUsXG4gICAgICBhdXRvcGxheVNwZWVkOiAyMDAwLFxuICAgIH0pO1xuXG4gICAgc2V0VGltZW91dChmdW5jdGlvbigpe1xuICAgICAgJCgnLm1haW4taGVhZGVyIC5hbmltYXRlZCcpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICB9LCAxMDAwKTtcblxuICAgIGlmICgkKCcuc2VjdGlvbi1oZXJvJykubGVuZ3RoKXtcblx0XHRcdHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcbiAgICAgICAgJCgnLmhlcm8tc2xpZGUuc2xpZGUwIC5hbmltYXRlZCcpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgICAgJCgnLm1haW4taGVhZGVyIC5hbmltYXRlZCcpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgICAgJCgnLnNlY3Rpb24taGVybyAuc2xpY2stZG90cycpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgICAgJCgnLnNlY3Rpb24taGVybyAuc2VjdGlvbi1uZXh0JykuYWRkQ2xhc3MoJ2ludmlldycpO1xuICAgICAgfSwgMTAwMCk7XG4gICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgICQoJy5oZXJvLXNsaWRlLnNsaWRlMCcpLmFkZENsYXNzKCdpbnZpZXcnKTtcblx0XHRcdH0sIDE1MDApO1xuICAgIH1cblxuICAgIGlmICgkKCcuYWJvdXQtcGFnZScpLmxlbmd0aCl7XG5cdFx0XHRzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgICQoJy5oZXJvLWFib3V0IC5hbmltYXRlZCcpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgICAgJCgnLnNlY3Rpb24tcHJpY2luZyAuYW5pbWF0ZWQtYXV0bycpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgIH0sIDEwMDApO1xuICAgIH1cbiAgICBpZiAoJCgnLmhlcm8tYXV0aCcpLmxlbmd0aCl7XG4gICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgICQoJy5oZXJvLWF1dGggLmFuaW1hdGVkJykuYWRkQ2xhc3MoJ2ludmlldycpO1xuICAgICAgfSwgMTAwMCk7XG4gICAgfVxuICAgIGlmICgkKCcuaGVyby1yZXF1ZXN0JykubGVuZ3RoKXtcbiAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcbiAgICAgICAgJCgnLmhlcm8tcmVxdWVzdCAuYW5pbWF0ZWQnKS5hZGRDbGFzcygnaW52aWV3Jyk7XG4gICAgICB9LCAxMDAwKTtcbiAgICB9XG4gICAgaWYgKCQoJy5pbmZvLXBhZ2UnKS5sZW5ndGgpe1xuICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpe1xuICAgICAgICAkKCcuaW5mby1wYWdlIC5hbmltYXRlZCcpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgIH0sIDEwMDApO1xuICAgIH1cblxuICAgIGlmICgkKCcuc2VjdGlvbi1wcmljZScpLmxlbmd0aCl7XG4gICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgICQoJy5zZWN0aW9uLXByaWNlID4gaDEuYW5pbWF0ZWQnKS5hZGRDbGFzcygnaW52aWV3Jyk7XG4gICAgICAgICQoJy5zZWN0aW9uLXByaWNlIC5jYXJkLmFuaW1hdGVkJykuYWRkQ2xhc3MoJ2ludmlldycpO1xuICAgICAgICAkKCcuc2VjdGlvbi1wcmljZSBoMiAuYW5pbWF0ZWQnKS5hZGRDbGFzcygnaW52aWV3Jyk7XG4gICAgICB9LCAxMDAwKTtcbiAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcbiAgICAgICAgJChcIi5zZWN0aW9uLXByaWNlIC5hY2NvcmRpb24uYW5pbWF0ZWRcIikuZWFjaChmdW5jdGlvbihpLCBlbCkge1xuICAgICAgICAgIHZhciBlbCA9ICQoZWwpO1xuICAgICAgICAgIGlmIChlbC52aXNpYmxlKHRydWUpKSB7XG4gICAgICAgICAgICBlbC5kZWxheSg1MDAgKiBpKS5hZGRDbGFzcyhcImludmlld1wiKTsgXG4gICAgICAgICAgfVxuICAgICAgICB9KTtcblx0XHRcdH0sIDMwMDApO1xuICAgIH1cblxuICAgIGlmICgkKCcuc2VjdGlvbi1mZWF0dXJlJykubGVuZ3RoKXtcbiAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcbiAgICAgICAgJCgnLnNlY3Rpb24tZmVhdHVyZSBoMS5hbmltYXRlZCcpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgICAgJCgnLnNlY3Rpb24tZmVhdHVyZSBwLmFuaW1hdGVkJykuYWRkQ2xhc3MoJ2ludmlldycpO1xuICAgICAgICAkKCcuc2VjdGlvbi1mZWF0dXJlIC5oZXJvLWltZy5hbmltYXRlZCcpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgIH0sIDEwMDApO1xuICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpe1xuICAgICAgICAkKFwiLnNlY3Rpb24tZmVhdHVyZSAuYWNjLWxpc3QuYW5pbWF0ZWRcIikuZWFjaChmdW5jdGlvbihpLCBlbCkge1xuICAgICAgICAgIHZhciBlbCA9ICQoZWwpO1xuICAgICAgICAgIGlmIChlbC52aXNpYmxlKHRydWUpKSB7XG4gICAgICAgICAgICBlbC5kZWxheSgxMDAwICogaSkuYWRkQ2xhc3MoXCJpbnZpZXdcIik7IFxuICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICB9LCA0MDAwKTtcbiAgICAgIFxuICAgICAgJCgnLnNwZWNpYWwtbGlua3MgYVtkYXRhLWxpbmtdJykuY2xpY2soZnVuY3Rpb24oZSl7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgdmFyIGN1cnJlbnRJdGVtID0gJCgnIycrJCh0aGlzKS5hdHRyKCdkYXRhLWxpbmsnKSk7XG4gICAgICAgIGN1cnJlbnRJdGVtLmFkZENsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgY3VycmVudEl0ZW0uZmluZCgndWwnKS5zbGlkZURvd24oKTtcbiAgICAgICAgJCgnLmFjYy1saXN0Jykubm90KGN1cnJlbnRJdGVtKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICQoJy5hY2MtbGlzdCB1bCcpLm5vdChjdXJyZW50SXRlbS5jaGlsZHJlbigndWwnKSkuc2xpZGVVcCgpO1xuICAgICAgfSk7XG4gICAgfVxuICAgIGlmICgkKCcuc2VjdGlvbi1zb2x1dGlvbnMnKS5sZW5ndGgpe1xuICAgICAgaWYod2luZG93LmxvY2F0aW9uLmhhc2gpe1xuICAgICAgICB3aW5kb3cuc2Nyb2xsVG8oMCwgMCk7IC8vIGV4ZWN1dGUgaXQgc3RyYWlnaHQgYXdheVxuICAgICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAgIHdpbmRvdy5zY3JvbGxUbygwLCAwKTsgLy8gcnVuIGl0IGEgYml0IGxhdGVyIGFsc28gZm9yIGJyb3dzZXIgY29tcGF0aWJpbGl0eVxuICAgICAgICB9LCAyKTtcbiAgICAgICAgXG4gICAgICAgICQoJ1tocmVmPVwiJyt3aW5kb3cubG9jYXRpb24uaGFzaCsnXCJdJykucGFyZW50KCkuYWRkQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgICAkKCcudGFicy1jb250ZW50ICcrIHdpbmRvdy5sb2NhdGlvbi5oYXNoKS5hZGRDbGFzcygndGFicy1hY3RpdmUnKTtcbiAgICAgICAgaWYoISQoJy50YWJzLWNvbnRlbnQgJysgd2luZG93LmxvY2F0aW9uLmhhc2gpLmhhc0NsYXNzKCd0YWJzLWRhcmsnKSl7XG4gICAgICAgICAgJCgnYm9keScpLmFkZENsYXNzKCdpcy1saWdodCcpO1xuICAgICAgICB9ZWxzZXtcbiAgICAgICAgICAkKCdib2R5JykucmVtb3ZlQ2xhc3MoJ2lzLWxpZ2h0Jyk7XG4gICAgICAgIH1cbiAgICAgIH1lbHNle1xuICAgICAgICAkKCcudGFicy10b2dnbGUgbGknKS5lcSgwKS5hZGRDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICQoJy50YWJzLWNvbnRlbnQgPiBkaXYnKS5lcSgwKS5hZGRDbGFzcygndGFicy1hY3RpdmUnKTtcbiAgICAgIH1cblxuICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpe1xuICAgICAgICAkKCcuc2VjdGlvbi1zb2x1dGlvbnMgaDEuYW5pbWF0ZWQnKS5hZGRDbGFzcygnaW52aWV3Jyk7XG4gICAgICAgICQoJy5zZWN0aW9uLXNvbHV0aW9ucyBwLmFuaW1hdGVkJykuYWRkQ2xhc3MoJ2ludmlldycpO1xuICAgICAgICAkKCcuc2VjdGlvbi1zb2x1dGlvbnMgaDMuYW5pbWF0ZWQnKS5hZGRDbGFzcygnaW52aWV3Jyk7XG4gICAgICAgICQoJy5zZWN0aW9uLXNvbHV0aW9ucyAudGFicy1hY3RpdmUgLnRhYnMtYmcnKS5mYWRlSW4oKTtcbiAgICAgIH0sIDEwMDApO1xuICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpe1xuICAgICAgICAkKFwiLnNlY3Rpb24tc29sdXRpb25zIC50YWJzLXRvZ2dsZSA+IGxpXCIpLmVhY2goZnVuY3Rpb24oaSwgZWwpIHtcbiAgICAgICAgICB2YXIgZWwgPSAkKGVsKTtcbiAgICAgICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICBlbC5hZGRDbGFzcygnaW52aWV3Jyk7XG4gICAgICAgICAgfSwoMTAwICogaSkpXG4gICAgICAgIH0pO1xuICAgICAgfSwgMzAwMCk7XG4gICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgICQoXCIuc2VjdGlvbi1zb2x1dGlvbnMgLnRhYnMtYWN0aXZlIHVsID4gbGlcIikuZWFjaChmdW5jdGlvbihpLCBlbCkge1xuICAgICAgICAgIHZhciBlbCA9ICQoZWwpO1xuICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcbiAgICAgICAgICAgIGVsLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgICAgICB9LCgxMDAgKiBpKSlcbiAgICAgICAgfSk7XG4gICAgICB9LCA0MDAwKTtcbiAgICB9XG4gICAgJCgnc2VsZWN0JykubmljZVNlbGVjdCgpO1xuXG4gICAgXG4gICAgJCgnLmhlcm8taG9tZScpLm9uKCdhZnRlckNoYW5nZScsIGZ1bmN0aW9uKGV2ZW50LCBzbGljaywgY3VycmVudFNsaWRlKXtcbiAgICAgIHZhciBjdXJyZW50U2hvdyA9ICQoJy5oZXJvLXNsaWRlLnNsaWRlJytjdXJyZW50U2xpZGUpO1xuICAgICAgY3VycmVudFNob3cuYWRkQ2xhc3MoJ2ludmlldycpO1xuICAgICAgJCgnLmhlcm8tc2xpZGUnKS5ub3QoY3VycmVudFNob3cpLnJlbW92ZUNsYXNzKCdpbnZpZXcnKTtcbiAgICB9KTtcbiAgICAvLyAkKCcuaGVyby1ob21lJykub24oJ2JlZm9yZUNoYW5nZScsIGZ1bmN0aW9uKGV2ZW50LCBzbGljaywgY3VycmVudFNsaWRlLCBuZXh0U2xpZGUpe1xuICAgIC8vICAgJCgnLmhlcm8tc2xpZGUuc2xpZGUnK2N1cnJlbnRTbGlkZSkucmVtb3ZlQ2xhc3MoJ2ludmlldycpO1xuICAgIC8vICAgJCgnLmhlcm8tc2xpZGUuc2xpZGUnK25leHRTbGlkZSkuYWRkQ2xhc3MoJ2ludmlldycpO1xuICAgIC8vIH0pO1xuXG5cbiAgICAkKCcuY3VzdG9tZXItc2xpZGVyJykuc2xpY2soe1xuICAgICAgZmFkZTogdHJ1ZSxcbiAgICAgIGRvdHM6IHRydWUsXG4gICAgICBzcGVlZDogNTAwLFxuICAgICAgYXJyb3dzOiBmYWxzZVxuICAgIH0pO1xuXG4gICAgJCgnLnRlYW0tc2xpZGVyJykuc2xpY2soe1xuICAgICAgZmFkZTogdHJ1ZSxcbiAgICAgIGRvdHM6IHRydWUsXG4gICAgICBzcGVlZDogNTAwLFxuICAgICAgYXJyb3dzOiBmYWxzZVxuICAgIH0pO1xuICAgICAgXG4gICAgJCgnLmJ0bi1zY3JvbGwnKS5jbGljayhmdW5jdGlvbihlKXtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgIHZhciBzY3JvbGxUYXJnZXQgPSAkKCQodGhpcykuYXR0cignaHJlZicpKTtcblx0XHRcdCQoJ2h0bWwsIGJvZHknKS5hbmltYXRlKHtcblx0XHRcdFx0c2Nyb2xsVG9wOiBzY3JvbGxUYXJnZXQub2Zmc2V0KCkudG9wXG5cdFx0XHR9LCAxNTAwKTtcbiAgICB9KTtcblxuICAgIGlmICgkKCcucGludHJvLXBvcHVwJykubGVuZ3RoKXtcbiAgICAgIHZhciBwbGF5ZXIgPSBuZXcgUGx5cignI3BpbnRyby12aWRlbycsIHtcbiAgICAgICAgYXV0b3BsYXk6IGZhbHNlXG4gICAgICB9KTtcbiAgICAgIHBsYXllci5zb3VyY2UgPSB7XG4gICAgICAgIHR5cGU6ICd2aWRlbycsXG4gICAgICAgIHRpdGxlOiAnUGFrYWkgUGludHJvIHNla2FyYW5nJyxcbiAgICAgICAgc291cmNlczogW1xuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHNyYzogJy4vYXNzZXRzL3ZpZGVvcy9waW50cm8tdmlkZW8ubXA0JyxcbiAgICAgICAgICAgICAgICB0eXBlOiAndmlkZW8vbXA0JyxcbiAgICAgICAgICAgICAgICBzaXplOiA3MjBcbiAgICAgICAgICAgIH1cbiAgICAgICAgXSxcbiAgICAgICAgcG9zdGVyOiAnLi9hc3NldHMvdmlkZW9zL3BpbnRyby1jb3Zlci5qcGcnXG4gICAgICB9O1xuXG4gICAgICAkKCcucGludHJvLXZpZGVvIC5idG4tcGxheScpLmNsaWNrKGZ1bmN0aW9uKCl7XG4gICAgICAgICQoJy5waW50cm8tcG9wdXAnKS5hZGRDbGFzcygnb3BlbicpO1xuICAgICAgICBwbGF5ZXIucGxheSgpO1xuICAgICAgfSk7XG5cbiAgICAgICQoJy5waW50cm8tcG9wdXAnKS5tb3VzZXVwKGZ1bmN0aW9uKGUpIFxuICAgICAge1xuICAgICAgICAgIHZhciB0YXJnZXREaXYgPSAkKFwiLnBpbnRyby12aWRlby13cmFwcGVyXCIpO1xuICAgICAgICAgIGlmICghdGFyZ2V0RGl2LmlzKGUudGFyZ2V0KSAmJiB0YXJnZXREaXYuaGFzKGUudGFyZ2V0KS5sZW5ndGggPT09IDApIFxuICAgICAgICAgIHtcbiAgICAgICAgICAgICQoJy5waW50cm8tcG9wdXAnKS5yZW1vdmVDbGFzcygnb3BlbicpO1xuICAgICAgICAgICAgcGxheWVyLnN0b3AoKTtcbiAgICAgICAgICB9XG4gICAgICB9KTtcbiAgICB9XG4gICAgXG4gICAgJCgnLnBvcC1idG4nKS5jbGljayhmdW5jdGlvbihlKXtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgIHZhciBjdXJyZW50UG9wID0gJCh0aGlzKS5jbG9zZXN0KCcucG9wLWdyb3VwJyk7XG4gICAgICBjdXJyZW50UG9wLnRvZ2dsZUNsYXNzKCdvcGVuJyk7XG4gICAgICAkKCcucG9wLWdyb3VwJykubm90KGN1cnJlbnRQb3ApLnJlbW92ZUNsYXNzKCdvcGVuJyk7XG4gICAgfSk7XG4gICAgXG5cbiAgICAkKCcuYnRuLXRvZ2dsZScpLmNsaWNrKGZ1bmN0aW9uKGUpe1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgdmFyIHRhcmdldElkID0gJCgnIycrJCh0aGlzKS5hdHRyKCdzaG93LWZvcicpKTtcbiAgICAgIHRhcmdldElkLnRvZ2dsZUNsYXNzKCdvcGVuJyk7XG4gICAgICAkKCcudG9nZ2xlZC1pdGVtJykubm90KHRhcmdldElkKS5yZW1vdmVDbGFzcygnb3BlbicpO1xuICAgICAgJCh0aGlzKS5hZGRDbGFzcygnYWN0aXZlJyk7XG4gICAgICAkKCcuYnRuLXRvZ2dsZScpLm5vdCh0aGlzKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgfSk7XG5cbiAgICAkKCdib2R5JykubW91c2V1cChmdW5jdGlvbihlKSBcbiAgICB7XG4gICAgICAgIHZhciB0YXJnZXREaXYgPSAkKFwiLmgtZHJvcGRvd25cIik7XG4gICAgICAgIGlmICghdGFyZ2V0RGl2LmlzKGUudGFyZ2V0KSAmJiB0YXJnZXREaXYuaGFzKGUudGFyZ2V0KS5sZW5ndGggPT09IDApIFxuICAgICAgICB7XG4gICAgICAgICAgdGFyZ2V0RGl2LnJlbW92ZUNsYXNzKCdzaG93Jyk7XG4gICAgICAgIH1cbiAgICB9KTtcblxuICAgICQoJy5jYXRlZ29yeS1vcHRpb25zPmxpJykuY2xpY2soZnVuY3Rpb24oKXtcbiAgICAgICQodGhpcykudG9nZ2xlQ2xhc3MoJ2NoZWNrZWQnKTtcbiAgICAgIHZhciBjdXJyZW50Q2hlY2tib3ggPSAkKHRoaXMpLmZpbmQoJ2lucHV0W3R5cGU9XCJjaGVja2JveFwiXScpO1xuICAgICAgJCgnI2J0bi1jaG9vc2UtY2F0ZWdvcnknKS5hZGRDbGFzcygnYnRuLXNvbGlkJykudGV4dCgnRG9uZScpO1xuICAgICAgaWYgKCQodGhpcykuaGFzQ2xhc3MoJ2NoZWNrZWQnKSl7XG4gICAgICAgIGN1cnJlbnRDaGVja2JveC5wcm9wKCdjaGVja2VkJywgdHJ1ZSk7XG4gICAgICB9XG4gICAgICBlbHNle1xuICAgICAgICBjdXJyZW50Q2hlY2tib3gucHJvcCgnY2hlY2tlZCcsIGZhbHNlKTtcbiAgICAgIH1cbiAgICB9KTtcblxuICAgICQoJy5idG4tc3RlcCcpLmNsaWNrKGZ1bmN0aW9uKCl7XG4gICAgICB2YXIgY3VycmVudFN0ZXAgPSAkKHRoaXMpLmF0dHIoJ2dvdG8tc3RlcCcpO1xuICAgICAgJCgnLnN0ZXBzLXdyYXBwZXInKS5hdHRyKCdjdXJyZW50LXN0ZXAnLCBjdXJyZW50U3RlcCk7XG4gICAgICAkKCcjJytjdXJyZW50U3RlcCkuYWRkQ2xhc3MoJ29wZW4nKTtcbiAgICAgICQoJy5zaWdudXAtc3RlcCcpLm5vdCgnIycrY3VycmVudFN0ZXApLnJlbW92ZUNsYXNzKCdvcGVuJyk7XG4gICAgICB2YXIgaW5kaWNhdG9yU3RlcCA9ICQoJy5zdGVwLWluZGljYXRvcj5saVtzdGVwLWZvcj1cIicrIGN1cnJlbnRTdGVwICsnXCJdJyk7XG4gICAgICBpbmRpY2F0b3JTdGVwLmFkZENsYXNzKCdjb21wbGV0ZScpO1xuICAgICAgJCgnLnN0ZXAtaW5kaWNhdG9yPmxpJykubm90KGluZGljYXRvclN0ZXApLnJlbW92ZUNsYXNzKCdjb21wbGV0ZScpO1xuICAgIH0pO1xuXG4gICAgJChcIi5maWVsZC1yYW5nZVwiKS5jaGFuZ2UoZnVuY3Rpb24oKXtcbiAgICAgIHZhciByYW5nZTEgPSAkKCcuZmllbGQtcmFuZ2U6Zmlyc3QnKS52YWwoKTtcbiAgICAgIHZhciByYW5nZTIgPSAkKCcuZmllbGQtcmFuZ2U6bGFzdCcpLnZhbCgpO1xuICAgICAgLy8gTmVpdGhlciBzbGlkZXIgd2lsbCBjbGlwIHRoZSBvdGhlciwgc28gbWFrZSBzdXJlIHdlIGRldGVybWluZSB3aGljaCBpcyBsYXJnZXJcbiAgICAgIGlmKCByYW5nZTEgPiByYW5nZTIgKXsgdmFyIHRtcCA9IHJhbmdlMjsgcmFuZ2UyID0gcmFuZ2UxOyByYW5nZTEgPSB0bXA7IH1cbiAgICAgICQoXCIucmFuZ2UtdmFsdWVzIC5taW5cIikudGV4dChcIiQgXCIgKyByYW5nZTEpO1xuICAgICAgJChcIi5yYW5nZS12YWx1ZXMgLm1heFwiKS50ZXh0KFwiJCBcIiArIHJhbmdlMik7XG4gICAgfSk7XG5cbiAgICAkKCcucmF0aW5nJykuY2xpY2soZnVuY3Rpb24oKXtcbiAgICAgICQodGhpcykuYWRkQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgJCgnLnJhdGluZycpLm5vdCh0aGlzKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgICB2YXIgY3VycmVudFN0YXIgPSAkKHRoaXMpLmZpbmQoJ2lucHV0W3R5cGU9XCJyYWRpb1wiXScpO1xuICAgICAgaWYoJCh0aGlzKS5oYXNDbGFzcygnYWN0aXZlJykpe1xuICAgICAgICBjdXJyZW50U3Rhci5wcm9wKCdjaGVja2VkJywgdHJ1ZSk7XG4gICAgICB9XG4gICAgICBlbHNle1xuICAgICAgICBjdXJyZW50U3Rhci5wcm9wKCdjaGVja2VkJywgZmFsc2UpO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgJCgnLmJ0bi1jaGFuZ2UtcGhvdG8nKS5jbGljayhmdW5jdGlvbigpe1xuICAgICAgXG4gICAgfSk7XG4gICAgXG4gICAgJCgnLnRhYnMgYScpLmNsaWNrKGZ1bmN0aW9uKGUpe1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgdmFyIHRhcmdldCA9ICQodGhpcykuYXR0cignaHJlZicpO1xuICAgICAgJCh0aGlzKS5wYXJlbnQoKS5zaWJsaW5ncygpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICQodGhpcykucGFyZW50KCkuYWRkQ2xhc3MoJ2FjdGl2ZScpOyAgICAgIFxuICAgICAgJCgnLnRhYnMtY29udGVudCBkaXYnKS5yZW1vdmVDbGFzcygndGFicy1hY3RpdmUnKTtcbiAgICAgICQoJy50YWJzLWNvbnRlbnQgZGl2IGxpJykucmVtb3ZlQ2xhc3MoJ2ludmlldycpO1xuICAgICAgJCgnLnRhYnMtY29udGVudCAuYW5pbWF0ZWQnKS5yZW1vdmVDbGFzcyhmdW5jdGlvbihpbmRleCwgY3NzKSB7XG4gICAgICAgIHJldHVybiAoY3NzLm1hdGNoKC8oZC1bMC05XVswLTldKS9nKSB8fCBbXSkuam9pbignICcpO1xuICAgICAgfSk7XG4gICAgICAkKCcudGFicy1jb250ZW50IC5hbmltYXRlZCcpLnJlbW92ZUNsYXNzKCdpbnZpZXcnKTtcbiAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcbiAgICAgICAgJCh0YXJnZXQpLmZpbmQoJ2gzJykuYWRkQ2xhc3MoJ2ludmlldycpO1xuICAgICAgICAkKHRhcmdldCkuZmluZCgncCcpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgICAgJCh0YXJnZXQpLmZpbmQoJy5pbWctZGV0YWlscycpLmFkZENsYXNzKCdpbnZpZXcnKTtcbiAgICAgIH0sIDEwMCk7XG4gICAgICAkKCcudGFicy1jb250ZW50JykuZmluZCh0YXJnZXQpLmFkZENsYXNzKCd0YWJzLWFjdGl2ZScpO1xuICAgICAgJCgnLnRhYnMtY29udGVudCcpLmZpbmQodGFyZ2V0KS5maW5kKCcudGFicy1iZycpLmZhZGVJbigxMDAwKTtcbiAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKXtcbiAgICAgICAgJCgnLnRhYnMtY29udGVudCcpLmZpbmQodGFyZ2V0KS5maW5kKCdsaScpLmVhY2goZnVuY3Rpb24oaSwgZWwpIHtcbiAgICAgICAgICB2YXIgZWwgPSAkKGVsKTtcbiAgICAgICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICBlbC5hZGRDbGFzcygnaW52aWV3Jyk7XG4gICAgICAgICAgfSwoMTAwICogaSkpXG4gICAgICAgIH0pO1xuICAgICAgfSwgMTAwMCk7XG4gICAgICBpZighJCgnLnRhYnMtY29udGVudCcpLmZpbmQodGFyZ2V0KS5oYXNDbGFzcygndGFicy1kYXJrJykpe1xuICAgICAgICAkKCdib2R5JykuYWRkQ2xhc3MoJ2lzLWxpZ2h0Jyk7XG4gICAgICB9ZWxzZXtcbiAgICAgICAgJCgnYm9keScpLnJlbW92ZUNsYXNzKCdpcy1saWdodCcpO1xuICAgICAgfVxuICAgIH0pO1xuICAgICQoJy5jb250ZW50LWxpc3QgbGknKS5jbGljayhmdW5jdGlvbigpe1xuICAgICAgdmFyIGN1cnJlbnRJbWcgPSAkKCcjJyArICQodGhpcykuYXR0cignc2hvdy1pbWcnKSk7XG4gICAgICAkKHRoaXMpLmFkZENsYXNzKCdhY3RpdmUnKTtcbiAgICAgICQodGhpcykuc2libGluZ3MoJ2xpJykucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuICAgICAgY3VycmVudEltZy5hZGRDbGFzcygnYWN0aXZlJyk7XG4gICAgICBjdXJyZW50SW1nLnNpYmxpbmdzKCdpbWcnKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgfSk7XG5cbiAgICAkKCcuY2FyZC10YWJzIGEnKS5jbGljayhmdW5jdGlvbihlKXtcbiAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgIHZhciB0YXJnZXQgPSAkKHRoaXMpLmF0dHIoJ2hyZWYnKTtcbiAgICAgICQodGhpcykucGFyZW50KCkuc2libGluZ3MoKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAkKHRoaXMpLnBhcmVudCgpLmFkZENsYXNzKCdhY3RpdmUnKTsgICAgICBcbiAgICAgICQoJy50YWJzLWNvbnRlbnRzJykucmVtb3ZlQ2xhc3MoJ3RhYnMtYWN0aXZlJyk7XG4gICAgICAkKCcudGFicy1jb250ZW50cyAuYW5pbWF0ZWQnKS5yZW1vdmVDbGFzcygnaW52aWV3Jyk7XG4gICAgICAkKCcudGFicy1jb250ZW50cyAuYW5pbWF0ZWQnKS5yZW1vdmVDbGFzcyhmdW5jdGlvbihpbmRleCwgY3NzKSB7XG4gICAgICAgIHJldHVybiAoY3NzLm1hdGNoKC8oZC1bMC05XVswLTldKS9nKSB8fCBbXSkuam9pbignICcpO1xuICAgICAgfSk7XG4gICAgICAkKHRhcmdldCkuYWRkQ2xhc3MoJ3RhYnMtYWN0aXZlJyk7XG4gICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCl7XG4gICAgICAgICQodGFyZ2V0KS5maW5kKCcuYW5pbWF0ZWQnKS5hZGRDbGFzcygnaW52aWV3IGRlbGF5MScpO1xuICAgICAgfSwgMTAwKVxuICAgICAgXG4gICAgfSk7XG5cbiAgICBpZigkKCcuYWNjb3JkaW9uJykubGVuZ3RoKXtcbiAgICAgICQoJy5hY2NvcmRpb24uYWN0aXZlJykuZmluZCgndWwnKS5kZWxheSg1MDAwKS5zbGlkZURvd24oKTtcbiAgICB9XG4gICAgXG4gICAgJCgnLmFjY29yZGlvbiAuYWNjb3JkaW9uLXRvZ2dsZScpLmNsaWNrKGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgdmFyIGRyb3BEb3duID0gJCh0aGlzKS5zaWJsaW5ncygnLmFjY29yZGlvbi1jb250ZW50JykuZmluZCgndWwnKTtcblxuICAgICAgICAkKHRoaXMpLnBhcmVudHMoJy5hY2NvcmRpb24td3JhcCcpLmZpbmQoJ3VsJykubm90KGRyb3BEb3duKS5zbGlkZVVwKDEwMDApO1xuXG4gICAgICAgIGlmICgkKHRoaXMpLnBhcmVudCgpLmhhc0NsYXNzKCdhY3RpdmUnKSkge1xuICAgICAgICAgICAgJCh0aGlzKS5wYXJlbnQoKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKHRoaXMpLnBhcmVudCgpLmNsb3Nlc3QoJy5hY3RpdmUnKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgICAgICAgICAkKHRoaXMpLnBhcmVudCgpLmFkZENsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgfVxuXG4gICAgICAgIGRyb3BEb3duLnN0b3AoZmFsc2UsIHRydWUpLnNsaWRlVG9nZ2xlKDUwMCk7XG5cbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgIH0pO1xuXG4gICAgaWYoJCgnLmFjYy1saXN0JykubGVuZ3RoKXtcbiAgICAgIGNvbnNvbGUubG9nKHdpbmRvdy5sb2NhdGlvbi5oYXNoKTtcbiAgICAgIGlmKHdpbmRvdy5sb2NhdGlvbi5oYXNoKXtcbiAgICAgICAgd2luZG93LnNjcm9sbFRvKDAsIDApOyAvLyBleGVjdXRlIGl0IHN0cmFpZ2h0IGF3YXlcbiAgICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgICB3aW5kb3cuc2Nyb2xsVG8oMCwgMCk7IC8vIHJ1biBpdCBhIGJpdCBsYXRlciBhbHNvIGZvciBicm93c2VyIGNvbXBhdGliaWxpdHlcbiAgICAgICAgfSwgMSk7XG4gICAgICAgICQoJy5hY2MtbGlzdCcrIHdpbmRvdy5sb2NhdGlvbi5oYXNoKS5hZGRDbGFzcygnYWN0aXZlJykuZmluZCgndWwnKS5kZWxheSg1MDAwKS5zbGlkZURvd24oKTtcbiAgICAgICAgJCgnLmFjYy1saXN0Jysgd2luZG93LmxvY2F0aW9uLmhhc2gpLmZpbmQoJ2EnKS50ZXh0KCdTaG93IExlc3MnKTtcbiAgICAgIH1lbHNle1xuICAgICAgICAkKCcuYWNjLWxpc3QnKS5lcSgwKS5hZGRDbGFzcygnYWN0aXZlJykuZmluZCgndWwnKS5kZWxheSg1MDAwKS5zbGlkZURvd24oKTtcbiAgICAgICAgJCgnLmFjYy1saXN0JykuZXEoMCkuZmluZCgnYScpLnRleHQoJ1Nob3cgTGVzcycpO1xuICAgICAgICBcbiAgICAgIH1cbiAgICB9XG4gICAgJCgnLmFjYy1saXN0IGEnKS5jbGljayhmdW5jdGlvbihlKSB7XG4gICAgICB2YXIgZHJvcERvd24gPSAkKHRoaXMpLnNpYmxpbmdzKCd1bCcpO1xuXG4gICAgICAkKCcuYWNjLWxpc3QgdWwnKS5ub3QoZHJvcERvd24pLnNsaWRlVXAoKTtcbiAgICAgIGlmICgkKHRoaXMpLnBhcmVudCgpLmhhc0NsYXNzKCdhY3RpdmUnKSkge1xuICAgICAgICAgICQodGhpcykudGV4dCgnU2hvdyBNb3JlJyk7XG4gICAgICAgICAgJCh0aGlzKS5wYXJlbnQoKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICAgICQodGhpcykucGFyZW50cygnLmhlcm8tY29udGVudCcpLmZpbmQoJy5hY3RpdmUnKS5maW5kKCdhJykudGV4dCgnU2hvdyBNb3JlJyk7XG4gICAgICAgICAgJCh0aGlzKS5wYXJlbnRzKCcuaGVyby1jb250ZW50JykuZmluZCgnLmFjdGl2ZScpLnJlbW92ZUNsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgICAkKHRoaXMpLnBhcmVudCgpLmFkZENsYXNzKCdhY3RpdmUnKTtcbiAgICAgICAgICAkKHRoaXMpLnRleHQoJ1Nob3cgTGVzcycpO1xuICAgICAgfVxuXG4gICAgICBkcm9wRG93bi5zdG9wKGZhbHNlLCB0cnVlKS5zbGlkZVRvZ2dsZSgpO1xuXG4gICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgfSk7XG5cbiAgICAkKCcuYnRuLW1lbnUnKS5jbGljayhmdW5jdGlvbigpe1xuICAgICAgJCh0aGlzKS50b2dnbGVDbGFzcygnb3BlbicpO1xuICAgICAgJCh0aGlzKS5wYXJlbnQoJy5tYWluLWhlYWRlcicpLnRvZ2dsZUNsYXNzKCdvcGVuJyk7XG4gICAgfSk7XG5cbiAgICAkKCcuYnRuLWRpYWxvZycpLmNsaWNrKGZ1bmN0aW9uKGUpe1xuICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgdmFyIGN1cnJlbnREaWFsb2cgPSAkKCcjJysgJCh0aGlzKS5hdHRyKCdzaG93LWRpYWxvZycpKTtcbiAgICAgIGN1cnJlbnREaWFsb2cuYWRkQ2xhc3MoJ29wZW4nKTtcbiAgICAgICQoJy5tZGwtZGlhbG9nLXdyYXAnKS5ub3QoY3VycmVudERpYWxvZykucmVtb3ZlQ2xhc3MoJ29wZW4nKTtcbiAgICB9KTtcbiAgICAkKCcuYnRuLWNsb3NlJykuY2xpY2soZnVuY3Rpb24oKXtcbiAgICAgICQodGhpcykuY2xvc2VzdCgnLm1kbC1kaWFsb2ctd3JhcCcpLnJlbW92ZUNsYXNzKCdvcGVuJyk7XG4gICAgfSk7XG5cblxuICAgICQoIGZ1bmN0aW9uKCkge1xuICAgICAgdmFyIHNjaG9vbE1hbGFuZyA9IFtcbiAgICAgICAgXCJTREkgU2FiaWxpbGxhaFwiLFxuICAgICAgICBcIk1JTiBNYWxhbmcgMVwiLFxuICAgICAgICBcIlNEIFBsdXMgQWwtS2F1dHNhclwiLFxuICAgICAgICBcIlNESSBBbC1BemhhclwiLFxuICAgICAgICBcIlNETiBQYW5kYW53YW5naSAxXCIsXG4gICAgICAgIFwiU0ROIEJsaW1iaW5nIDFcIlxuICAgICAgXTtcbiAgICAgICQoIFwiI2Nob29zZS1zY2hvb2xcIiApLmF1dG9jb21wbGV0ZSh7XG4gICAgICAgIHNvdXJjZTogc2Nob29sTWFsYW5nXG4gICAgICB9KTtcbiAgICB9KTtcbiAgfSk7XG4gIFxufSkoKTtcbiJdLCJmaWxlIjoibWFpbi5qcyJ9
  
  //# sourceMappingURL=main.min.js.map