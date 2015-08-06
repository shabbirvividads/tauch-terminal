(function ($) {
    var activateSlider = function (current) {
        var rel = current.data('rel');
        var scope = $('.slider-photo');

        current.addClass('active');
        $('.background-image', scope).hide();
        $('.background-image.image-' + rel, scope).show();
        $('.container .more', scope).css({'visibility':'hidden'});
        $('.container .more-' + rel, scope).css({'visibility':'visible'});
    };

    $(document).ready(function () {
        $('.sites-slider').on('click', function (e) {
            e.preventDefault();
            $('.sites-slider').removeClass('active');
            activateSlider($(this));
        });

        // Preload Images for Conferences
        var preload = function (images) {
            $(images).each(function (i, img) {
                $('<img/>')[0].src = img;
            });
        };
        // Usage:
        var preloadItems = [];
        $('[data-preload="true"]').each(function () {
            preloadItems.push($(this).data('preload-item'));
        });
        if (preloadItems !== []) {
            setTimeout(function () {
                preload(preloadItems);
            }, 5000);
        }
    });
})(jQuery);
