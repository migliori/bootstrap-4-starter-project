/* global define, console, $, jQuery, lazyload, loadjs */
'use strict';

var tokens = document.domain.split('.');
var extension = tokens[tokens.length - 1];// com|fr
var lang = 'fr';
if (extension === 'com') {
    lang = 'en';
}

var resizeTimer;

// main core events
var coreFunctions = function() {

    /*===============================
    =            Sidebar            =
    ===============================*/

    if ($('.sidebar')[0]) {
        if ($(window).width() > 768) {
            $('.sidebar').removeClass('collapse');
        }
        $(window)
            .on('resize', function() {
                setTimeout(function() {
                    if ($(window).width() > 768) {
                        $('.sidebar')
                            .removeClass('collapse')
                            .addClass('show');
                        $('.sidebar-toggler')
                            .removeClass('collapsed')
                            .attr('aria-expanded', 'true');
                    } else {
                        $('.sidebar')
                            .addClass('collapse')
                            .removeClass('show');
                        $('.sidebar-toggler')
                            .addClass('collapsed')
                            .attr('aria-expanded', 'false');
                    }
                }, 100);
            })
            .resize();

        // sidebar mini toggle
        if ($('.sidebar-mini-toggler')[0]) {
            $('.sidebar-mini-toggler').on('click', function() {
                $(this)
                    .closest('.sidebar')
                    .toggleClass('sidebar-mini')
                    .find('a.dropdown-toggle:not(.collapsed)')
                    .trigger('click');
            });
        }
    }
};

// main nav mobile dropdowns
var toggleMobileDropdown = function(e) {
    var _d, _m, _d_others, _m_others, _mobileLink, shouldOpen;
    _d = $(e.target).closest('.dropdown');console.log(_d);
    _m = $('.dropdown-menu', _d);
    _d_others = $('.dropdown').not(_d);
    _m_others = $('.dropdown-menu').not(_m);
    _mobileLink = $(e.target).closest('.nav-mobile-dropdown-link');
    shouldOpen = !_d.hasClass('show');

    // close others
    _m_others.toggleClass('show', false);
    _d_others.toggleClass('show', false);
    _d_others.find('.icon-plus').toggleClass('d-none', false);
    _d_others.find('.icon-minus').toggleClass('d-none', true);
    $('.dropdown-toggle', _d_others)
        .attr('aria-expanded', false)
        .toggleClass('collapsed', true);
    _mobileLink.find('.icon-plus').toggleClass('d-none', shouldOpen);
    _mobileLink.find('.icon-minus').toggleClass('d-none', !shouldOpen);
    _m.toggleClass('show', shouldOpen);
    _d.toggleClass('show', shouldOpen);
    $('.dropdown-toggle', _d)
        .attr('aria-expanded', shouldOpen)
        .toggleClass('collapsed', !shouldOpen);

    return false;
};

// main nav dropdowns
var toggleDropdown = function(e) {
    if (window.innerWidth < 768) {
        return false;
    }
    var _d, _m, _d_others, _m_others, shouldOpen;
    if ($(e.target).hasClass('nav-link')) {
        _d = $(e.target).closest('.dropdown');
        _m = $('.dropdown-menu', _d);
        _d_others = $('.dropdown').not(_d);
        _m_others = $('.dropdown-menu').not(_m);
        shouldOpen = e.type !== 'click' && _d.is(':hover');

        // close others
        _m_others.toggleClass('show', false);
        _d_others.toggleClass('show', false);
        $('.dropdown-toggle', _d_others)
            .attr('aria-expanded', false)
            .toggleClass('collapsed', true);
    } else {
        _d = $('.dropdown-toggle[aria-expanded="true"]').closest('.dropdown');
        _m = $('.dropdown-menu', _d);
        shouldOpen = false;
    }
    _m.toggleClass('show', shouldOpen);
    _d.toggleClass('show', shouldOpen);
    $('.dropdown-toggle', _d)
        .attr('aria-expanded', shouldOpen)
        .toggleClass('collapsed', !shouldOpen);

    return false;
};

// position dropdowns - https://codepen.io/migli/pen/RELPPj
var positionDropdowns = function(parentElementSelector) {
    $(parentElementSelector).each(function() {
        var maxWidth = $(this).width();
        $(this).find('.dropdown-menu').each(function() {
            $(this).removeClass('dropdown-menu-right');
            var $navItem = $(this).closest('.dropdown'),
                dropdownWidth = $(this).outerWidth(),
                dropdownOffsetLeft = $navItem.offset().left,
                dropdownOffsetRight = maxWidth - (dropdownOffsetLeft + dropdownWidth),
                linkCenterOffsetLeft = dropdownOffsetLeft + $navItem.outerWidth() / 2,
                outputCss = {
                    left: 0,
                    right: '',
                    width: ''
                };

            if ((linkCenterOffsetLeft - dropdownWidth / 2 > 0) & (linkCenterOffsetLeft + dropdownWidth / 2 < maxWidth)) {
                // center the dropdown menu if possible
                outputCss.left = -(dropdownWidth / 2 - $navItem.outerWidth() / 2);
            } else if ((dropdownOffsetRight < 0) & (dropdownWidth < dropdownOffsetLeft + $navItem.outerWidth())) {
                // set the dropdown menu to left if it exceeds the viewport on the right
                $(this).addClass('dropdown-menu-right');
                outputCss.left = '';
            } else if (dropdownOffsetLeft + dropdownWidth > maxWidth) {
                // full width if the dropdown is too large to fit on the right
                outputCss.left = 0;
                outputCss.right = 0;
                outputCss.width = maxWidth + 'px';
            }
            $(this).css({
                left: outputCss.left,
                right: outputCss.right,
                width: outputCss.width
            });
        });
    });
};

loadjs([
    '/assets/javascripts/jquery-3.3.1.min.js',
    '/assets/javascripts/popper.min.js',
    '/assets/javascripts/bootstrap.min.js',
    '/assets/javascripts/plugins/loaders/pace.min.js'
    ], 'core',
    {
        async: false
    }
);

loadjs.ready('core', function() {
    coreFunctions();
    loadjs([
        '/assets/javascripts/plugins/misc/jquery.hoverIntent.min.js'
    ], function() {
        loadjs.done('bundleB');
    });
    loadjs([
        '/assets/javascripts/plugins/loaders/lazyload.min.js'
    ], function() {
        loadjs.done('bundleC');
    });
});

// core + hoverIntent loaded
loadjs.ready(['bundleB'], function() {
    if ($('#main-nav')[0]) {

        /* navbar main links
        -------------------------------------------------- */

        $('#main-nav .nav > li.dropdown')
            .hoverIntent(toggleDropdown);

        positionDropdowns('#main-nav');

        $(window).on("resize", function(e) {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                positionDropdowns('#main-nav');
            }, 250);
        });

        /* mobile dropdown links (+)
        -------------------------------------------------- */

        $('#main-nav .nav-mobile-dropdown-link').click(toggleMobileDropdown);
    }

});

// core + lazyload loaded
loadjs.ready(['bundleC'], function() {
    lazyload();
});
