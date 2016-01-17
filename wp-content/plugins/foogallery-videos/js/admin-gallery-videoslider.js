(function (FOOGALLERY_VIDEOSLIDER_TEMPLATE, $, undefined) {



    FOOGALLERY_VIDEOSLIDER_TEMPLATE.showHideRows = function() {

        var $theme_rows = $('.gallery_template_field-videoslider-theme_custom_bgcolor')

            .add('.gallery_template_field-videoslider-theme_custom_textcolor')

            .add('.gallery_template_field-videoslider-theme_custom_hovercolor')

            .add('.gallery_template_field-videoslider-theme_custom_dividercolor');



        if ( $('input[name="foogallery_settings[videoslider_theme]"]:checked').val() === 'rvs-custom' ) {

            $theme_rows.show();

        } else {

            $theme_rows.hide();

        }



        var $highlight_rows = $('.gallery_template_field-videoslider-highlight_custom_bgcolor')

            .add('.gallery_template_field-videoslider-highlight_custom_textcolor');



        if ( $('input[name="foogallery_settings[videoslider_highlight]"]:checked').val() === 'rvs-custom-highlight' ) {

            $highlight_rows.show();

        } else {

            $highlight_rows.hide();

        }

    };



    FOOGALLERY_VIDEOSLIDER_TEMPLATE.adminReady = function () {

        $('body').on('foogallery-gallery-template-changed-videoslider', function() {

            FOOGALLERY_VIDEOSLIDER_TEMPLATE.showHideRows();

        });



        $('input[name="foogallery_settings[videoslider_theme]"], input[name="foogallery_settings[videoslider_highlight]"]').change(function() {

            FOOGALLERY_VIDEOSLIDER_TEMPLATE.showHideRows();

        });

    };



}(window.FOOGALLERY_VIDEOSLIDER_TEMPLATE = window.FOOGALLERY_VIDEOSLIDER_TEMPLATE || {}, jQuery));



jQuery(function () {

    FOOGALLERY_VIDEOSLIDER_TEMPLATE.adminReady();

});