# Login Page - Changelog

## 23 Sep 2022 - INIT - Ver 1.0.0
  - Initial commit

## 28 Nov 2022 - UPD - Ver 1.0.1
 - Update code to reflect changes to F1PHP VIEW and HTTP services.

## 29 Nov 2022 - REL - Ver 2.0.0
 - Update code to use ES6 module notation.
  * Re-factor form.html.js to import F1JS Form via ES6 loader and
    change format to be more consistent with the standard set by booking.html.js.

## 13 Dec 2022 - DEV - Ver 3.0.0
 - Refactor HTML according to the new bookings page look and layout.
 - Fix broken CSS styles. e.g. The submit button color...
 - Add more CSS vars to CSS

## 17 Dec 2022 - DEV - Ver 4.0.0 
 - Completely re-factor HTML and CSS again.
 - Use new form CSS classes and HTML markup.
   e.g `.form-rows` and `.form-row`

## 29 Dec 2022 - DEV - Ver 4.1.0
 - Update JS ES6 imports to refelct the new JS vendors structure.
 - Update login.php controller...
  * Move `$goto` and `$error` globals in under `$response`.
  * Add more css file includes.
