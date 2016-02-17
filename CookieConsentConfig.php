<?php

class CookieConsentConfig extends ModuleConfig {
    public function getDefaults() {
        return array(
        'injectFiles' => 1,
        'useCloudFlare' => 1,
        'injectOptions' => 1,
        'messageText' => $this->_('This website uses cookies to ensure you get the best experience on our website'),
        'dismiss' => $this->_('Got it!'),
        'learnMore' => $this->_('More info'),
        'link' => null,
        'container' => null,
        'theme' => 'light-floating',
        'path' => '/',
        'domain' => null,
        'expiryDays' => 365,
        'target' => '_self'
        );
    }

    public function __construct() {
        $this->add(array(
            array(
                'type' => 'checkbox',
                'name' => 'injectFiles',
                'label' => $this->_('Inject dependencies?'),
                'value' => 1,
                'notes' => $this->_('This will automagically insert the needed files into your site'),
                'columnWidth' => 34
            ),
            array(
                'type' => 'checkbox',
                'name' => 'useCloudFlare',
                'label' => $this->_('Get js from cloudflare'),
                'value' => 1,
                'notes' => $this->_('Either get the files from cloudflare or localy'),
                'columnWidth' => 33,
                'showIf' => 'injectFiles=1'
            ),
            array(
                'type' => 'checkbox',
                'name' => 'injectOptions',
                'label' => $this->_('Shall we inject options?'),
                'value' => 1,
                'notes' => $this->_("If you want to include the settings yourself"),
                'columnWidth' => 33
            ),
            array(
                'type' => 'markup',
                'name' => 'customFiles',
                'label' => $this->_('How to manually place files'),
                'description' => $this->_('desc'),
                'value' => "<pre style='padding:10px;border:1px dashed #ccc'>".$this->_('Value')."</pre>",
                'showIf' => 'injectFiles=0'
            ),
            array(
                'type' => 'fieldset',
                'name' => 'options',
                'label' => $this->_('Options'),
                'showIf' => 'injectOptions=1',
                'children' => array(
                    array(
                        'type' => 'select',
                        'name' => 'theme',
                        'label' => $this->_('Choose Style'),
                        'options' => array(
                            'dark-bottom',
                            'dark-floating-tada',
                            'dark-floating',
                            'dark-inline',
                            'dark-top',
                            'light-bottom',
                            'light-floating',
                            'light-top',
                            'custom' => 'custom theme',
                            'false' => 'no theme'
                        ),
                        'notes' => $this->_('If you want'),
                        'value' => 'light-floating',
                        'columnWidth' => 50
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'themePath',
                        'label' => $this->_('Path to your custom theme css file'),
                        'notes' => $this->_('/site/styles/customCookieConsent.css'),
                        'showIf' => 'theme=custom',
                        'columnWidth' => 50
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'messageText',
                        'label' => $this->_('The message shown by the plugin'),
                        'notes' => sprintf($this->_('Default: "%s"'), $this->messageText),
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'dismiss',
                        'label' => $this->_('The text used on the dismiss button'),
                        'notes' => sprintf($this->_('Default: "%s"'), $this->dismiss),
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'link',
                        'label' => $this->_("Policy link"),
                        'description' => $this->_('The url of your cookie policy. If it’s set to null, the link is hidden'),
                        'columnWidth' => 50
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'learnMore',
                        'label' => $this->_("Policy link text"),
                        'description' => $this->_('The text shown on the link to the cookie policy'),
                        // 'notes' => sprintf($this->_('Default: "%s"'), $this->learnMore),
                        'notes' => $this->_('requires the link option to also be set'),
                        'columnWidth' => 50
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'container',
                        'label' => $this->_("Where to append"),
                        'description' => $this->_('The element you want the Cookie Consent notification to be appended to. If null, the Cookie Consent plugin is appended to the body'),
                        'notes' => $this->_('The majority of the built in themes are designed around the plugin being a child of the body'),
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'path',
                        'label' => $this->_("Cookie path"),
                        'description' => $this->_('The path for the consent cookie that Cookie Consent uses, to remember that users have consented to cookies'),
                        'notes' => $this->_('Use to limit consent to a specific path within your website'),
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'domain',
                        'label' => $this->_("Domain"),
                        'description' => $this->_('The domain for the consent cookie that Cookie Consent uses, to remember that users have consented to cookies. Useful if your website uses multiple subdomains, e.g. if your script is hosted at www.example.com you might override this to example.com, thereby allowing the same consent cookie to be read by subdomains like foo.example.com'),
                        'notes' => $this->_('Default: The current subdomain'),
                    ),
                    array(
                        'type' => 'integer',
                        'name' => 'expiryDays',
                        'label' => $this->_("Days to expire"),
                        'description' => $this->_('The number of days Cookie Consent should store the user’s consent information for'),
                        'notes' => $this->_('Default: 365'),
                        'columnWidth' => 50
                    ),
                    array(
                        'type' => 'fieldset',
                        'name' => 'targetOptions',
                        'label' => $this->_("Target"),
                        'description' => $this->_('The target of the link to your cookie policy. Use to open a link in a new window, or specific frame, if you wish'),
                        'children' => array(
                            array(
                                'type' => 'select',
                                'name' => 'target',
                                'label' => $this->_('Select one of the defaults or custom'),
                                'options' => array(
                                    '_self' => '_self',
                                    '_blank' => '_blank',
                                    '_parent' => '_parent',
                                    '_top' => '_top',
                                    'custom' => $this->_('Custom selector')
                                ),
                                'value' => '_self',
                                'columnWidth' => 50
                            ),
                            array(
                                'type' => 'text',
                                'name' => 'target',
                                'label' => $this->_('Enter your selector'),
                                'showIf' => 'target=custom',
                                'columnWidth' => 50
                            )
                        )
                    )
                )
            )
        ));
    }
}