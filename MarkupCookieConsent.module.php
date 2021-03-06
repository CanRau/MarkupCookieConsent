<?php

/**
 * MarkupCookieConsent
 *
 * This module is intended to add a little cookie notice to your front-end.
 * It's doing this by hooking into page render and altering the output
 * to include the form at the end of the page (right before </body>).
 * 
 * more infos in readme.md
 * 
 */
class MarkupCookieConsent extends WireData implements Module {

    /**
     * getModuleInfo is a module required by all modules to tell ProcessWire about them
     *
     * @return array
     */
    public static function getModuleInfo() {
        return array(
            'title'    => 'Markup Cookie Consent',
            'summary'  => __('Renders cookie consent information for EU-Cookie-Law'),
            'author'   => 'Can Rau',
            'href'     => 'https://processwire.com/talk/topic/12253-markupcookieconsent/',
            'version'  => 35,
            'autoload' => true,
            'singular' => true,
            'requires' => 'ProcessWire>=2.8.15'
        );
    }


    public function init() {
        $input      = $this->wire('input');
        $config     = $this->wire('config');
        $session    = $this->wire('session');
        $requestUri = $this->wire('sanitizer')->pagePathName($_SERVER['REQUEST_URI']);

        // if already accepted and not module edit screen return, to stop module
        if ($input->cookie($this->cookieName) && strpos($requestUri, "$this") === false) return;

        // set cookie if accept cookie button pressed
        if ($input->post->action === 'acceptCookies') {
            setcookie($this->cookieName, 1, time() + $this->cookieExpire, '/', $this->cookieDomain, $this->cookieSSL, $this->cookieHttp);
            
            // start a ProcessWire session and set the wire/s cookie
            if ($config->sessionAllow && !$session->hasCookie()) $session->init();

            // if it's ajax request we just exit here
            if ($config->ajax) exit;

            // reload page to prevent duplicate form submissions
            $session->redirect('./');
        }

        if ($input->get->cookie === 'remove') {
            setcookie($this->cookieName, 1, time() -3600, '/', $this->cookieDomain, $this->cookieSSL, $this->cookieHttp);
            $session->redirect("edit?name=$this");
        }

        // no cookie present and no submission, let's invoke the hook to render everything
        $this->addHookAfter('Page::render', $this, 'renderCookieForm');
    }


    public function renderCookieForm($event) {
        $page  = $event->object;
        $pages = $this->wire('pages');
        $debug = $this->wire('config')->debug;

        // we stop here when on admin pages except this modules config page (for demonstration) or out of pageSelector
        if(($page->template != 'admin' && $this->pageSelector &&  $pages->find($this->pageSelector)->has($page) == false)
         || ($page->template == 'admin' && $this->wire('input')->get->name != $this))
            return;

        $classPrefix    = empty($this->classPrefix) ? 'mCCF' : $this->classPrefix;
        $position       = empty($this->position) ? 'bottom' : $this->position;
        $colorTheme     = empty($this->colorTheme) ? 'dark' : $this->colorTheme;
        $classContainer = "$classPrefix {$classPrefix}--{$position} {$classPrefix}--{$colorTheme}";
        $classButton    = "{$classPrefix}__accept";
        $classPrivacy   = "{$classPrefix}__link";

        if($this->wire('languages')) {
            $userLanguage = $this->wire('user')->language;
            $lang         = $userLanguage->isDefault() ? '' : "__$userLanguage->id";
        }
        else {
            $lang = '';
        }
        
        $target = $this->privacyTarget === 'custom' ? $this->privacyTargetCustom : $this->privacyTarget;

        $cookieConsentForm  = "<form id='mCCForm' class='$classContainer' action='./?accept=cookies' method='post'>";
        $cookieConsentForm .= "<button id='mCCButton' class='$classButton' name='action' value='acceptCookies'>";
        // additional markup like an icon can easily be prepended
        if ($this->buttonPrepend) $cookieConsentForm .= $this->get("buttonPrepend$lang|buttonPrepend");
        $cookieConsentForm .= $this->get("buttonText$lang|buttonText");
        // or appended to the button
        if ($this->buttonAppend) $cookieConsentForm .= $this->get("buttonAppend$lang|buttonAppend");
        $cookieConsentForm .= "</button>";
        $cookieConsentForm .= "<p class='{$classPrefix}__message'>";
        // message text markdown supported
        $t = $this->wire('modules')->get('TextformatterMarkdownExtra');
        $str = $t->markdown($this->get("messageText$lang|messageText"), 2); 
        $cookieConsentForm .= trim(str_ireplace(array('<p>', '</p>'), '', $str)); 

        // if privacyText and privacyUrl provided append to cookieMessage
        if ($this->privacyText && ($this->privacyPage || $this->{"privacyPageUrl$lang"})) {
            $privacyUrl = $this->{"privacyPageUrl$lang"} ?: $pages->get($this->privacyPage)->url;
            $cookieConsentForm .= "<a class='$classPrivacy' href='$privacyUrl' target='$target'>" . $this->get("privacyText$lang|privacyText") . "</a>";
        }
        $cookieConsentForm .= "</p>";
        $cookieConsentForm .= "</form>";
        $folder = $this->wire('config')->urls->$this;
        $min = $debug? '':'.min';
        if ($this->moduleStyles) $event->return = $this->str_replace_once("<link ", "<link rel='stylesheet' type='text/css' href='{$folder}{$this}{$min}.css' /><link ", $event->return); 

        $jsFile = $this->useAjax ? "<script src='{$folder}{$this}{$min}.js'></script>" : '';

        $event->return = str_replace("</body>", "{$jsFile}{$cookieConsentForm}</body>", $event->return);
    }


    /**
     * helper function
     */
    function str_replace_once($str_pattern, $str_replacement, $string) {
        if (strpos($string, $str_pattern) !== false){
            $occurrence = strpos($string, $str_pattern);
            return substr_replace($string, $str_replacement, strpos($string, $str_pattern), strlen($str_pattern));
        }
        return $string;
    }


    public function cookieExists() {
        if ($this->wire('input')->cookie($this->cookieName)) {
            return __('Cookie is set');
        } else {
            return __('No cookie set');
        }
    }

}
