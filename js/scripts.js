(function ($) {
    $(document).ready(function () {
        $('.entry-content table').each(function () {
            if ($(this).find('tr').length >= 8) {
                $(this).find('tr:odd').addClass('table-row-odd');
            }
        });
        $('#access .menu > ul > li').each(function () {
            $(this).find('a').append('<span class="top-menu-tail"></span>');
            if ($(this).find('ul.children').length) {
                $(this).addClass('submn');
                $(this).find('a').append('<span class="menu-arrow-down"></span>')
            }
        });
    });
})(jQuery);