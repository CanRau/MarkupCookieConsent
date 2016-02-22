# MarkupCookieConsent
## Still considered Beta
Not widely tested, and config inputs already look like they're translatable but they're actually **not** yet saving!


## What it does
This module is intended to add a little cookie notice to your front-end. It's doing this by hooking into page render and altering the output to include the form at the end of the page (right before </body>).

## Features
* AJAX (deactivatable)
* 2 themes (dark/light)
* 2 positions (top/bottom)
* customizable texts, message and button label
* prepend / append custom text/markup to the button e.g. Font Awesome Icon like in the screenshot
* customizable privacy policy - select page from your page tree (optional), change link text and target
* fully customizable cookie settings (name, lifetime, domain, path, secure, HTTPonly)
* you wanna roll your own design? Just disable default stylesheet

## Installation
You can enter the class name *MarkupCookieConsent* in your back-ends module configs and it will download ist automatically
or get from [Processwires module directory](http://modules.processwire.com/modules/markup-cookie-consent/) or [Github](https://github.com/CanRau/MarkupCookieConsent/) and install it by unzipping and moving into your /site/modules/ folder or selecting the zip from your back-ends modules page.