# MarkupCookieConsent

## Problems with cookies not being set?
**Make sure to remember any settings!**
Please remove module and then install fresh copy of newest version.
Or update to latest version, then disable and enable module.

## Still considered Beta
Not widely tested, and config inputs already look like they're translatable but they're actually not yet saving!
**Thanks to Ryan the newest PW 3.0.15 devns fixes this issue**


## What it does
This module is intended to add a little cookie notice to your front-end. It's doing this by hooking into page render and altering the output to include the form at the end of the page (right before &lt;/body&gt;).

## Features
* AJAX (deactivatable, JS disabled users will fall back to normal form submit with page reload, so fully functional without JS)
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

## Changelog
* 0.1.1 - Fixed issue with cookie not being set, two strings wouldn't recognize translation, default cookie expire now 1 year, updated readme, removed deprecated branch
* 0.1.0 - Missing strings now translatable
* 0.0.9 - Changed style injection, now prepends to first <link> in head makes it easier to add custom css tweaks without the need for !important because of the cascading order
