<?php

class MarkupCookieConsentConfig extends ModuleConfig {
    public function getDefaults() {
        return array(
        'useAjax' => 1,
        'moduleStyles' => 1,
        'colorTheme' => 'dark',
        'position' => 'bottom',
        'buttonText' => __("Accept cookies"),
        'messageText' => __("This website uses cookies to ensure you get the best experience on our website"),
        'buttonPrepend' => '',
        'buttonAppend' => '',
        'privacyText' => '',
        'privacyPage' => 1,
        'privacyPageUrl' => '',
        'privacyTarget' => '_self',
        'privacyTargetCustom' => '',
        'cookieName' => 'eu-cookie',
        'cookieExpire' => 60*60*24*365,
        'cookieDomain' => null,
        'cookieSSL' => false,
        'cookieHttp' => true,
        'classPrefix' => 'mCCF',
        );
    }

    public function __construct() {
        $mcc = $this->wire('modules')->get('MarkupCookieConsent');
        $this->add(array(
            array(
                'type' => 'fieldset',
                'label' => __("Settings"),
                'children' => array(
                    array(
                        'type' => 'checkbox',
                        'name' => 'useAjax',
                        'label' => __('Enable Ajax'),
                        'notes' => __('No dependencies (vanilla js), prevents confirmation from reloading page'),
                        'columnWidth' => 20
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'moduleStyles',
                        'label' => __('Inject modules stylesheet?'),
                        'notes' => __('Automagically appends the stylesheet to your <head>'),
                        'columnWidth' => 20
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'colorTheme',
                        'label' => __('Select theme'),
                        'columnWidth' => 20,
                        'options' => array(
                            'dark' => __('dark (Default)'),
                            'light' => __('light')
                        ),
                        'notes' => __("Adds CSS class '{$mcc->classPrefix}--{$mcc->colorTheme}' to the <form> tag."),
                        // 'showIf' => 'moduleStyles=1',
                        'requiredIf' => 'moduleStyles=1'
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'position',
                        'label' => __('Select position'),
                        'columnWidth' => 20,
                        'options' => array(
                            'top' => __('top'),
                            'bottom' => __('bottom (Default)')
                        ),
                        'notes' => __("Adds CSS class '{$mcc->classPrefix}--{$mcc->position}' to the <form> tag."),
                        // 'showIf' => 'moduleStyles=1',
                        'requiredIf' => 'moduleStyles=1'
                    ),
                    array(
                        'type' => 'markup',
                        'label' => __('Cookie control'),
                        'description' => $mcc->cookieExists(),
                        'columnWidth' => 20,
                        'children' => array(
                            array(
                                'type' => 'button',
                                'name' => 'removeCookie',
                                'href' => "edit?name={$this->wire('input')->get->name}&cookie=remove",
                                'value' => __('Remove cookie'),
                                'notes' => __('Remove cookie from this computer')
                                )
                            )
                        )
                )
            ),
            // array(
            //     'type' => 'markup',
            //     'name' => 'customFiles',
            //     'label' => __('How to manually place styles'),
            //     'description' => __('desc'),
            //     'value' => "<pre style='padding:10px;border:1px dashed #ccc'>".__('Value')."</pre>",
            //     'showIf' => 'moduleStyles=0'
            // ),
            array(
                'type' => 'fieldset',
                'name' => 'buttonOptions',
                'label' => __("Message & Accept Button Settings"),
                'children' => array(
                    array(
                        'type' => 'text',
                        'name' => 'messageText',
                        'label' => __('The message shown by the plugin'),
                        'useLanguages' => true,
                        'columnWidth' => 70
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'buttonText',
                        'label' => __('The text used on the accept button'),
                        'useLanguages' => true,
                        'columnWidth' => 30
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'buttonPrepend',
                        'label' => __('Prepend Text or HTML to the button text'),
                        'icon' => 'fa-check',
                        'notes' => sprintf(__('For example Font Awesome checkmark icon e.g. %s (You need to include Font Awesome on your own)'), "<i class='fa fa-check'></i>"),
                        'columnWidth' => 50,
                        'useLanguages' => true
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'buttonAppend',
                        'label' => __('Append Text or HTML to the button text'),
                        'notes' => __('Default empty'),
                        'columnWidth' => 50,
                        'useLanguages' => true
                    )
                )
            ),
            array(
                'type' => 'Selector',
                'name' => 'pageSelector',
                'label' => __('Banner display limit'),
                'description' => __('Define selectors, which limits the display of the banner to selected pages.'),
                'notes' => __('To include parent of page tree define name=NameOfParent then has_parent=NameOfParent (both need to be equal), then select checkbox next to second selector to switch to OR group'),
                'columnWidth' => 100
            ),
            array(
                'type' => 'fieldset',
                'name' => 'linkOptions',
                'label' => __("Privacy Page Settings"),
                'children' => array(
                    array(
                        'type' => 'pageListSelect',
                        'name' => 'privacyPage',
                        'description' => __('Select privacy policy page'),
                        'notes' => __('Selection reveals more options'),
                        'label' => __("Policy page"),
                        'columnWidth' => 33
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'privacyPageUrl',
                        'description' => __('Alternatively provide a custom url to your policy page'),
                        'label' => __("Custom policy link"),
                        'notes' => __('overrides previous page selection'),
                        'columnWidth' => 34,
                        'useLanguages' => true
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'privacyText',
                        'description' => __('The text shown on the link to the cookie policy'),
                        'label' => __("Policy link text"),
                        'notes' => __('requires the link option to also be set'),
                        'columnWidth' => 33,
                        'useLanguages' => true
                    ),
                    array(
                        'type' => 'select',
                        'name' => 'privacyTarget',
                        'label' => __('Link target'),
                        'description' => __('The target of the link to your cookie policy'),
                        'notes' => __('Use to open a link in a new window, or specific frame, if you wish'),
                        'options' => array(
                            '_self' => '_self',
                            '_blank' => '_blank',
                            '_parent' => '_parent',
                            '_top' => '_top',
                            'custom' => __('Custom selector')
                        ),
                        'columnWidth' => 50,
                        'showIf' => 'privacyPage!=0'
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'privacyTargetCustom',
                        'label' => __('Enter your selector'),
                        'columnWidth' => 50,
                        'showIf' => 'privacyPage!=0, privacyTarget=custom'
                    )
                )
            ),
            array(
                'type' => 'fieldset',
                'name' => 'cookieOptions',
                'label' => __("Cookie options"),
                'collapsed' => true,
                'children' => array(
                    array(
                        'type' => 'text',
                        'name' => 'cookieName',
                        'label' => __("Cookie name"),
                        'description' => __('The name for the consent cookie'),
                        'notes' => sprintf(__('Default: %s'), 'eu-cookie'),
                        'columnWidth' => 33
                    ),
                    array(
                        'type' => 'integer',
                        'name' => 'cookieExpire',
                        'label' => __("Seconds to expire"),
                        'description' => __('Seconds the cookie should last'),
                        'notes' => __('Default: 31536000 (seconds) = 1 year'),
                        'size' => 100,
                        'columnWidth' => 33
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'cookieDomain',
                        'label' => __("Cookie domain"),
                        'description' => __('The domain for the consent cookie that Cookie Consent uses, to remember that users have consented to cookies.'),
                        'notes' => __('Useful if your website uses multiple subdomains, e.g. if your script is hosted at www.example.com you might override this to example.com, thereby allowing the same consent cookie to be read by subdomains like foo.example.com'),
                        'columnWidth' => 34
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'cookieSSL',
                        'label' => __("Cookie only via SSL"),
                        'description' => __('Send cookie only via SSL from the client?'),
                        'notes' => __('Default false'),
                        'columnWidth' => 50
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'cookieHttp',
                        'label' => __("Cookie only via HTTP"),
                        'description' => __('Cookie will be accessible only through HTTP protocol (Default true)'),
                        'notes' => __("It has been suggested that this setting can effectively help to reduce identity theft through XSS attacks"),
                        'columnWidth' => 50
                    )
                )
            ), // cookieOptions fieldset
            // array(
            //     'type' => 'button',
            //     'name' => 'resetSettings',
            //     'value' => __("Default settings"),
            // )
        ));
    }


}