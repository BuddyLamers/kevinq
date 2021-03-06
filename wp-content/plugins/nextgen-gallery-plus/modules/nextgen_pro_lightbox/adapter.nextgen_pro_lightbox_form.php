<?php

class A_NextGen_Pro_Lightbox_Form extends Mixin
{
    function get_model()
    {
        $model = C_Lightbox_Library_Manager::get_instance()->get(NGG_PRO_LIGHTBOX);
        return $model;
    }

    function enqueue_static_resources()
    {
        wp_enqueue_script(
            'photocrati-nextgen_pro_lightbox_settings-js',
            $this->get_static_url('photocrati-nextgen_pro_lightbox#settings.js'),
            array('jquery.nextgen_radio_toggle')
        );
        wp_enqueue_style(
            'photocrati-nextgen_pro_lightbox_settings-css',
            $this->get_static_url('photocrati-nextgen_pro_lightbox#settings.css')
        );
    }

    /**
     * Returns a list of fields to render on the settings page
     */
    function _get_field_names()
    {
        return array(
            'nextgen_pro_lightbox_router_slug',
            'nextgen_pro_lightbox_icon_color',
            'nextgen_pro_lightbox_icon_background_enabled',
            'nextgen_pro_lightbox_icon_background_rounded',
            'nextgen_pro_lightbox_icon_background',
            'nextgen_pro_lightbox_overlay_icon_color',
            'nextgen_pro_lightbox_sidebar_button_color',
            'nextgen_pro_lightbox_sidebar_button_background',
            'nextgen_pro_lightbox_carousel_text_color',
            'nextgen_pro_lightbox_background_color',
            'nextgen_pro_lightbox_sidebar_background_color',
            'nextgen_pro_lightbox_carousel_background_color',
            'nextgen_pro_lightbox_image_pan',
            'nextgen_pro_lightbox_interaction_pause',
            'nextgen_pro_lightbox_enable_routing',
            'nextgen_pro_lightbox_enable_sharing',
            'nextgen_pro_lightbox_enable_comments',
            'nextgen_pro_lightbox_display_comments',
            'nextgen_pro_lightbox_display_captions',
            'nextgen_pro_lightbox_display_carousel',
            'nextgen_pro_lightbox_enable_twitter_cards',
            'nextgen_pro_lightbox_twitter_username',
            'nextgen_pro_lightbox_localize_limit',
            'nextgen_pro_lightbox_transition_speed',
            'nextgen_pro_lightbox_slideshow_speed',
            'nextgen_pro_lightbox_style',
            'nextgen_pro_lightbox_transition_effect',
            'nextgen_pro_lightbox_touch_transition_effect',
            'nextgen_pro_lightbox_image_crop'
        );
    }

    /**
     * Renders the 'slug' setting field
     *
     * @param $lightbox
     * @return mixed
     */
    function _render_nextgen_pro_lightbox_router_slug_field($lightbox)
    {
        return $this->_render_text_field(
            $lightbox,
            'router_slug',
            __('Router slug', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['router_slug'],
            __('Used to route JS actions to the URL', 'nextgen-gallery-pro')
        );
    }

    /**
     * Renders the lightbox 'icon color' setting field
     *
     * @param $lightbox
     * @return mixed
     */
    function _render_nextgen_pro_lightbox_icon_color_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'icon_color',
            __('Icon color', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['icon_color'],
            __('An empty setting here will use your style defaults', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_icon_background_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'icon_background',
            __('Icon background', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['icon_background'],
            __('An empty setting here will use your style defaults', 'nextgen-gallery-pro'),
            empty($lightbox->values['nplModalSettings']['icon_background_enabled']) ? TRUE : FALSE
        );
    }

    function _render_nextgen_pro_lightbox_icon_background_enabled_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'icon_background_enabled',
            __('Display background on carousel icons', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['icon_background_enabled']
        );
    }

    function _render_nextgen_pro_lightbox_icon_background_rounded_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'icon_background_rounded',
            __('Display rounded background on carousel icons', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['icon_background_rounded'],
            '',
            empty($lightbox->values['nplModalSettings']['icon_background_enabled']) ? TRUE : FALSE
        );
    }

    function _render_nextgen_pro_lightbox_overlay_icon_color_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'overlay_icon_color',
            __('Floating elements color', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['overlay_icon_color'],
            __('An empty setting here will use your style defaults', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_sidebar_button_color_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'sidebar_button_color',
            __('Sidebar button text color', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['sidebar_button_color'],
            __('An empty setting here will use your style defaults', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_sidebar_button_background_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'sidebar_button_background',
            __('Sidebar button background', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['sidebar_button_background'],
            __('An empty setting here will use your style defaults', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_carousel_text_color_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'carousel_text_color',
            __('Carousel text color', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['carousel_text_color'],
            __('An empty setting here will use your style defaults', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_background_color_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'background_color',
            __('Background color', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['background_color'],
            __('An empty setting here will use your style defaults', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_carousel_background_color_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'carousel_background_color',
            __('Carousel background color', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['carousel_background_color'],
            __('An empty setting here will use your style defaults', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_sidebar_background_color_field($lightbox)
    {
        return $this->_render_color_field(
            $lightbox,
            'sidebar_background_color',
            __('Sidebar background color', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['sidebar_background_color'],
            __('An empty setting here will use your style defaults', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_image_pan_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'image_pan',
            __('Pan cropped images', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['image_pan'],
            __('When enabled images can be panned with the mouse', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_interaction_pause_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'interaction_pause',
            __('Pause on interaction', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['interaction_pause'],
            __('When enabled image display will be paused if the user presses a thumbnail or any navigational link', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_enable_routing_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'enable_routing',
            __('Enable browser routing', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['enable_routing'],
            __('Necessary for commenting to be enabled', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_enable_sharing_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'enable_sharing',
            __('Enable sharing', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['enable_sharing'],
            __('When enabled social-media sharing icons will be displayed', 'nextgen-gallery-pro'),
            empty($lightbox->values['nplModalSettings']['enable_routing']) ? TRUE : FALSE
        );
    }

    function _render_nextgen_pro_lightbox_enable_comments_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'enable_comments',
            __('Enable comments', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['enable_comments'],
            '',
            empty($lightbox->values['nplModalSettings']['enable_routing']) ? TRUE : FALSE
        );
    }

    function _render_nextgen_pro_lightbox_display_comments_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'display_comments',
            __('Display comments', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['display_comments'],
            __('When on the commenting sidebar will be opened at startup', 'nextgen-gallery-pro'),
            empty($lightbox->values['nplModalSettings']['enable_comments']) ? TRUE : FALSE
        );
    }

    function _render_nextgen_pro_lightbox_display_captions_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'display_captions',
            __('Display captions', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['display_captions'],
            __('When on the captions toolbar will be opened at startup', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_display_carousel_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'display_carousel',
            __('Display carousel', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['display_carousel'],
            __('When disabled the navigation carousel will be docked and hidden offscreen at startup', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_enable_twitter_cards_field($lightbox)
    {
        return $this->_render_radio_field(
            $lightbox,
            'enable_twitter_cards',
            __('Enable Twitter Cards', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['enable_twitter_cards']
        );
    }

    function _render_nextgen_pro_lightbox_twitter_username_field($lightbox)
    {
        return $this->_render_text_field(
            $lightbox,
            'twitter_username',
            __('Twitter username', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['twitter_username'],
            __('Required by twitter for Twitter Card analytics', 'nextgen-gallery-pro'),
            empty($lightbox->values['nplModalSettings']['enable_twitter_cards']) ? TRUE : FALSE
        );
    }

    function _render_nextgen_pro_lightbox_localize_limit_field($lightbox)
    {
        return $this->_render_number_field(
            $lightbox,
            'localize_limit',
            __('Localize limit', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['localize_limit'],
            __('For performance gallery images are localized as javascript. Galleries with more images this limit will make an AJAX call to load the rest at startup. Set to 0 to include every image in displayed galleries.', 'nextgen-gallery-pro'),
            FALSE,
            '#',
            0
        );
    }

    function _render_nextgen_pro_lightbox_transition_speed_field($lightbox)
    {
        return $this->_render_number_field(
            $lightbox,
            'transition_speed',
            __('Transition speed', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['transition_speed'],
            __('Measured in seconds', 'nextgen-gallery-pro'),
            FALSE,
            __('seconds', 'nextgen-gallery-pro'),
            0
        );
    }

    function _render_nextgen_pro_lightbox_slideshow_speed_field($lightbox)
    {
        return $this->_render_number_field(
            $lightbox,
            'slideshow_speed',
            __('Slideshow speed', 'nextgen-gallery-pro'),
            $lightbox->values['nplModalSettings']['slideshow_speed'],
            __('Measured in seconds', 'nextgen-gallery-pro'),
            FALSE,
            __('seconds', 'nextgen-gallery-pro'),
            0
        );
    }

    function _render_nextgen_pro_lightbox_style_field($lightbox)
    {
        $available_styles = array(
            ''      => __('Default: a dark theme', 'nextgen-gallery-pro'),
            'black' => __('All black: Removes borders from the comments panel', 'nextgen-gallery-pro'),
            'white' => __('All white: A white based theme', 'nextgen-gallery-pro')
        );
        $lightbox->values['nplModalSettings']['style'] = str_replace('.css', '', $lightbox->values['nplModalSettings']['style']);
        return $this->_render_select_field(
            $lightbox,
            'style',
            __('Style', 'nextgen-gallery-pro'),
            $available_styles,
            $lightbox->values['nplModalSettings']['style'],
            __('Preset styles to customize the display. Selecting an option may reset some color fields.', 'nextgen-gallery-pro')
        );
    }

    function get_effect_options()
    {
        return array(
            'fade'      => __('Crossfade betweens images', 'nextgen-gallery-pro'),
            'flash'     => __('Fades into background color between images', 'nextgen-gallery-pro'),
            'pulse'     => __('Quickly removes the image into background color, then fades the next image', 'nextgen-gallery-pro'),
            'slide'     => __('Slides the images depending on image position', 'nextgen-gallery-pro'),
            'fadeslide' => __('Fade between images and slide slightly at the same time', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_transition_effect_field($lightbox)
    {
        return $this->_render_select_field(
            $lightbox,
            'transition_effect',
            __('Transition effect', 'nextgen-gallery-pro'),
            $this->get_effect_options(),
            $lightbox->values['nplModalSettings']['transition_effect']
        );
    }

    function _render_nextgen_pro_lightbox_touch_transition_effect_field($lightbox)
    {
        return $this->_render_select_field(
            $lightbox,
            'touch_transition_effect',
            __('Touch transition effect', 'nextgen-gallery-pro'),
            $this->get_effect_options(),
            $lightbox->values['nplModalSettings']['touch_transition_effect'],
            __('The transition to use on touch devices if the default transition is too intense', 'nextgen-gallery-pro')
        );
    }

    function _render_nextgen_pro_lightbox_image_crop_field($lightbox)
    {
        return $this->_render_select_field(
            $lightbox,
            'image_crop',
            __('Crop image display', 'nextgen-gallery-pro'),
            array(
                'true'      => __('Images will be scaled to fill the display, centered and cropped', 'nextgen-gallery-pro'),
                'false'     => __('Images will be scaled down until the entire image fits', 'nextgen-gallery-pro'),
                'height'    => __('Images will scale to fill the height of the display', 'nextgen-gallery-pro'),
                'width'     => __('Images will scale to fill the width of the display', 'nextgen-gallery-pro'),
                'landscape' => __('Landscape images will fill the display, but scale portraits to fit', 'nextgen-gallery-pro'),
                'portrait'  => __('Portrait images will fill the display, but scale landscapes to fit', 'nextgen-gallery-pro')
            ),
            $lightbox->values['nplModalSettings']['image_crop']
        );
    }

    function save_action()
    {
        // TODO: Add validation
        if (($updates = $this->object->param(NGG_PRO_LIGHTBOX))) {
            $settings = C_NextGen_Settings::get_instance();
            $settings->set('ngg_pro_lightbox', $updates);
            $settings->save();

            // There's some sort of caching going on that requires all lightboxes
            // to be flushed after we make changes to the Pro Lightbox
            C_Lightbox_Library_Manager::get_instance()->deregister_all();
        }
    }
}
