<?php
function detailsCardShortcode($atts) {
    $default = array(
        'data-icon' => '',
        'title' => '',
        'details' => '',
    );
    $args = shortcode_atts($default, $atts);
    return '
    <div class="detail-card" data-icon="'.$args['data-icon'].'">
        <div class="icon-place"></div>
        <p class="caption card-title">'.$args['title'].'</p>
        <p class="details body">'.html_entity_decode($args['details']).'</p>                    
    </div>
    ';
}
add_shortcode('details-card', 'detailsCardShortcode');

function contactsSectionShortcode() {
    $cards = array(
        'phone' => array(
            'data-icon' => get_theme_mod(MY_THEMESLUG . '_contacts_phone_icon'),
            'title' => 'Телефон',
            'description' => htmlentities('<a href="tel:'.get_theme_mod(MY_THEMESLUG . '_contacts_phone').'">'.get_theme_mod(MY_THEMESLUG . '_contacts_phone').'</a>')
        ),
        'email' => array(
            'data-icon' => get_theme_mod(MY_THEMESLUG . '_contacts_email_icon'),
            'title' => 'Електрона пошта',
            'description' => htmlentities("<a href=\"mailto:".get_theme_mod(MY_THEMESLUG . '_contacts_email')."\">".get_theme_mod(MY_THEMESLUG . '_contacts_email')."</a>")
        ),
        'location' => array(
            'data-icon' => get_theme_mod(MY_THEMESLUG . '_contacts_location_icon'),
            'title' => 'Адреса',
            'description' => get_theme_mod(MY_THEMESLUG . '_contacts_location'), 
        ),
        'hours' => array(
            'data-icon' => get_theme_mod(MY_THEMESLUG . '_contacts_works_icon'),
            'title' => 'Робочі години',
            'description' => get_theme_mod(MY_THEMESLUG . '_contacts_works'), 
        )
    );
    $result = '
    <div class="contact-section">
        <p class="top-caption caption">Звʼязок з нами</p>
        <h2 class="title-main display1">Контакти</h2>
        <div class="detail-cards-grid">
        '.implode("",array_map(function($v) {return do_shortcode('[details-card data-icon="'.$v['data-icon'].'" title="'.$v['title'].'" details="'.$v['description'].'"]');},$cards)).'
        </div>
    </div>
';
    return $result;
}
add_shortcode('contacts', 'contactsSectionShortcode');
?>