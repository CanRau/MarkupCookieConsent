# MarkupCookieConsent

## [unmaintained]
looking for new maintainers

## Requires
ProcessWire >= 2.8.15
Haven't tested it myself on pw 2.8, and actually don't even know if there is 2.8.15. Thing is, it depends on [this fix](https://github.com/ryancramerdesign/ProcessWire/commit/2fe134b7b059fff023f0f37c7f172a9853c88af2) which was applied right before pw 3.0.16.

## NOTE!
This repo now includes a devns branch. Which is not a development version of this module, but rather meant to be used with Processwire 3.x devns as the only difference is the added namespace and therefore the requires flag in module info.

## Still considered Beta
Not widely tested, and config inputs already look like they're translatable but they're actually not yet saving!
**Thanks to Ryan the newest PW 3.0.15 devns fixes this issue**

## Problems with cookies not being set?
**Make sure to remember any settings!**
Please remove module and then install fresh copy of newest version.
Or update to latest version, then disable and enable module.

## Info about non-minified CSS & JS
The module only checks for minified style and script so if you make any changes either minify yourself and name file MarkupCookieConsent.min.css / MarkupCookieConsent.min.js or disable auto injection in settings and include them yourself
So the non-minified versions are only for development.
Minified CSS & JS have been added in version 0.1.2.

## What it does
This module is intended to add a little cookie notice to your front-end. It's doing this by hooking into page render and altering the output to include the form at the end of the page (right before &lt;/body&gt;).

## Features
* AJAX (deactivatable, JS disabled users will fall back to normal form submit with page reload, so fully functional without JS)
* 2 themes (dark/light)
* 2 positions (top/bottom)
* customizable texts, message and button label
* prepend / append custom text/markup to the button e.g. Font Awesome Icon like in the screenshot
* selector field to limit banner to certain pages
* customizable privacy policy - select page from your page tree or provide custom url (optional), change link text and target
* fully customizable cookie settings (name, lifetime, domain, path, secure, HTTPonly)
* you wanna roll your own design? Just disable default stylesheet

## Installation
You can enter the class name *MarkupCookieConsent* in your back-ends module configs and it will download automatically
or get from [Processwires module directory](http://modules.processwire.com/modules/markup-cookie-consent/) or [Github](https://github.com/CanRau/MarkupCookieConsent/) and install it by unzipping and moving into your /site/modules/ folder or selecting the zip from your back-ends modules page.

## Changelog
* 0.3.2 - fix banner not showing on front end if no page selector provided
* 0.3.0 - add display limit selector field to define limit the banner to certain pages, added "remove cookie" button, removed cookie path setting
* 0.2.0 - fixed version issue and misleading cookie expiration setting
* 0.1.6 - added custom privacy url as requested by kixe, fixed custom link target, appended query string "accept=cookies" to form action for cached non ajax requests
* 0.1.5 - fixed issue on single language installations
* 0.1.4 - Cookie notification now completely translatable in front-end
* 0.1.2 - Added minified CSS & JS files
* 0.1.1 - Fixed issue with cookie not being set, two strings wouldn't recognize translation, default cookie expire now 1 year, updated readme, removed deprecated branch
* 0.1.0 - Missing strings now translatable
* 0.0.9 - Changed style injection, now prepends to first <link> in head makes it easier to add custom css tweaks without the need for !important because of the cascading order
