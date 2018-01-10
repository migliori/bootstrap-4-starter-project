'use strict';

// use window.onload instead of $(document).ready because it waits for the defered scripts to load
window.onload = function() {
    /* global define, console */
    // domready
    console.log('Document Loaded!');

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
