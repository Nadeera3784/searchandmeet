require('./bootstrap');
require('alpinejs');
require('./owl.carousel.min');
require('daterangepicker');
require('./jquery.timepicker.min.js');
require('./select2.min.js');
require('./vanilla-calendar.js');

import GLightbox from 'glightbox';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';

window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.timeGridPlugin = timeGridPlugin;
window.listPlugin = listPlugin;
window.interactionPlugin = interactionPlugin;
window.GLightbox = GLightbox;
window.AOS = require('aos');
window.Tagify  = require('@yaireo/tagify');

window.lottie = require('lottie-web');

window.AgoraRtm = require('agora-rtm-sdk');

$(function() {

    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('.select2').select2();

    $('input.timepicker').timepicker({
       scrollbar: true
    });

});


(function ( $ ) {

    $.fn.stickySidebar = function( options ) {

    var config = $.extend({
    headerSelector: 'header',
    navSelector: 'nav',
    contentSelector: '#content',
    footerSelector: 'footer',
    sidebarTopMargin: 20,
    footerThreshold: 40
    }, options);

    var fixSidebr = function() {

            var sidebarSelector = $(this);
            var viewportHeight = $(window).height();
            var viewportWidth = $(window).width();
            var documentHeight = $(document).height();
            var headerHeight = $(config.headerSelector).outerHeight();
            var navHeight = $(config.navSelector).outerHeight();
            var sidebarHeight = sidebarSelector.outerHeight();
            var contentHeight = $(config.contentSelector).outerHeight();
            var footerHeight = $(config.footerSelector).outerHeight();
            var scroll_top = $(window).scrollTop();
            var fixPosition = contentHeight - sidebarHeight;
            var breakingPoint1 = headerHeight + navHeight;
            var breakingPoint2 = documentHeight - (sidebarHeight + footerHeight + config.footerThreshold);

            // calculate
            if ( (contentHeight > sidebarHeight) && (viewportHeight > sidebarHeight) ) {

                    if (scroll_top < breakingPoint1) {

                    sidebarSelector.removeClass('sticky');

            } else if ((scroll_top >= breakingPoint1) && (scroll_top < breakingPoint2)) {

                    sidebarSelector.addClass('sticky').css('top', config.sidebarTopMargin);

            } else {

            var negative = breakingPoint2 - scroll_top;
            sidebarSelector.addClass('sticky').css('top',negative);

            }

        }
    };

    return this.each( function() {
        $(window).on('scroll', $.proxy(fixSidebr, this));
        $(window).on('resize', $.proxy(fixSidebr, this))
        $.proxy(fixSidebr, this)();
    });

    };

    }( jQuery ));


window.addEventListener('load',()=>{
    AOS.init();
    var lightbox = GLightbox();    
})

window.addEventListener("load", AOS.refresh);

window.addEventListener('load',()=>{
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        dots: true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1
            },
        }
    })
},true)

var prevScrollpos = window.pageYOffset;
window.addEventListener('scroll',()=>{
    var currentScrollPos = window.pageYOffset;
    const navbar=document.getElementById("navbar")
    if (navbar){
        if (prevScrollpos > currentScrollPos || currentScrollPos < 50) {
            navbar.style.top = "0";
            navbar.style.height = "80px";
        } else {
            navbar.style.top = "-80px";
            navbar.style.height = "80px";
        }
        prevScrollpos = currentScrollPos;
    }
})

window.addEventListener('load',()=>{
    const loadingDiv = document.getElementById('loading');
    if(loadingDiv)
        loadingDiv.remove();
},false);

//react components
require('../components/search');
require('../components/inquiry');
