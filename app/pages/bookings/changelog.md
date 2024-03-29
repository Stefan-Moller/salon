# Bookings Page - Changelog

## 08 Jul 2022 - Ver 1.0.0
  - Initial commit

## 14 Nov 2022 - Ver 1.1.0
  - Move shared includes to vendors/f1js and vendors/f1css.
	- Rename $response to $aptData

## 17 Nov 2022 - Ver 2.0.0
 - Change the way times-slots are rendered. Change from rows to columns!
 - Render bookings over multiple time-slots
 - Better styles for booked time slots (color)
 - Add an event handler to make the TODAY button work
 - Add an indicator showing the number of bookings for the day
 - Get VIEW and EDIT booking working again.

## 18 Nov 2022 - Ver 2.1.0
 - Change the date NAV date display to LONG format.
 - Standardize log() and err() statement formatting.
 - Fix "Edit Booking Modal Form". Fix initialization logic.
 - Fix / improve "Duration" field validation + Initialization
 - Add an "ID" field to "Edit Booking Form" to fix the "duplicate on save" issue.
 - Add ValidatorTypes and multiple validators per field to Form JS
 - Add "Click on time-slot" to add a new booking.
 - Clean-up Edit Modal initialization code.
 - Reduce font size slightly in "Date Nav" and "New Button"

## 22 Nov 2022 - Ver 2.2.0
 - SAVE, EDIT and DELETE using AJAX! No more slow page reloads.
 - Fix getting and setting the page state between page reloads. No more `date resets` on reload.
 - Improve DB Service: insertOrUpdate(). Now return the ids of newly inserted records!
 - Add HTTP service functions: getUrlParam() and getPostValue().
 - Add ajax POST request support.
 - Add delete button

## 24 Nov 2022 - FT - Ver 2.3.0
 - Beautify booking summary and detail views.
 - Create a user with a lesser role, e.g. admin and validate against that to prevent unauthorized updates.
 - MRP - Click on date in Date Nav to open a calendar modal to select the current date.
 - Add an event handler for selecting the date from the calendar modal.
 - Fix issue with unwanted REQUEST params making SAVE fail!
 - Make top part of calendar view sticky!
 - Server side validation and feedback system.
 - MRP - Check if time-slot is booked - Validate.
 - MRP - Only creator can edit. Role system.
 - Use the current user's actual ID as created_by an updated_by

## 25 Nov 2022 - FT - Ver 2.4.0
 - Totally refactor F1JS.Modal from Static Object to Class Type Service + Update code to reflect changes.
 - Fix issue booking.model.verifyPermissions
 - Fix Delete not closing the view modal.
 - Fix bug where we keep on adding controllers to the debug array..
 - Add error support to ajax Delete functions.

## 25 Nov 2022 - FIX - Ver 2.4.1
 - Fix issues around F1.Modal and the ENTITY prop. bookingFormModalCtrl.ENTITY vs. elBookingFormModal.ENTITY

## 27 Nov 2022 - DEV - Ver 2.5.0
 - Convert F1JS to ES6 modules.
 - Replace old script includes with ES6 import statements.
 - Rename vars and update F1JS module usage in bookings.html.js
 - Remove unused code

## 28 Nov 2022 - DEV - Ver 2.5.1
 - Re-factor AJAX handling code in bookings.php
 - Update code to reflect changes to the F1::Http service
 - Update code to reflect changes to the F1:View service
 - Move `bookings.view.sql` to `app/` folder
 - Fix bug where the nav calendar's date does not alays match the currently selected day's date.

## 29 Nov 2022 - FIX - Ver 2.5.2
 - Fix inline CSS regression causing the day-view grid to overflow on mobile.

## 13 Dec 2022 - FT - Ver 3.0.0
 - Major Update!
 - Totally refactor the application and bookings page HTML and CSS.
 - Change instances of `<img src="caret.svg">` to `<svg>`.
 - Re-arrange HTML elements to allow `position: sticky` to work properly.
 - Rename `Modal Dialog, Header and Footer templates` to a more consistent standard.
 - Update views affected by Template and base HTML structure changes accross all pages.
 - Re-design the `Bookings Day View Grid` and CSS according to reasearch done on another test project.
 - Greatly improve the `Responsive Behaviour` of the bookings page header. Make the loading indicator `position:absolute` etc.
 - Update bookings page inline JS to reflect changes in class names and HTML structure.
 - `Create new F1CSS modules` where required and `move common CSS elements to F1CSS`.
 - `Rename existing and Add more CSS vars` + Use CSS vars in more places.

## 13 Dec 2022 - DEV - Ver 3.1.0
 - Change `CalendarModel` to `DayViewModel` and move it to content/bookings.
 - Change all model files' `namespace` to `Models`.
 - Update affected code.

## 15 Dec 2022 - DEV - Ver 3.2.0
 - Change the brand Google Font from `Passions Conflict` to `Cookie`
 - Try out and test `CSS Grid` on headers, but eventually revert to flexbox again.
 - `Test and perfect` all headers's `responsive behaviour` using only flexbox.
 - Get the `date select` and `add new button` to `shrink` with text ellipsis!
 - Prevent the `page header` from stacking to `3 rows` on any size screen!
 - Hide the `main menu home link` on smaller screens.
 - Reduce the `header logo size` on smaller screens.
 - Improve the FieldValidator class. Change from `array args` to `object args`!
 - Improve the built-in Required validation to use a 'zeroIsBad' option.
 - `Drop the GreaterThan validator` on Duration Fields in favour of the 
   newly updated Required validator.

## 16 Dec 2022 - FT - Ver 3.3.0
 - Implement a basic `mobile menu` with `hamburger button` toggle.
 - Further improve the responsive behaviour of the site header.
 - Shorten home page header title to "Welcome" only.
 - Change 404 page back link to use `app->baseUri` instead of `/`
 - Use `body.window` to identify a 100vh layout view.

## 16 Dec 2022 - DEV - Ver 3.4.0
 - Refactor the `booking form` HTML and styles to be more responsive.
  * Make form rows more prominent and stand-alone.
 - Shorten the `brand title text` even more on small screens.
 - Change CSS `@media` breakpoints

## 17 Dec 2022 - DEV - Ver 3.4.1
 - Remove `two column selects` row from the booking form.
 - Set tabindex="0" in some inputs to see if it fixes tab order on mobile.

## 17 Dec 2022 - DEV - Ver 3.4.2
 - Fix booking form HTML indentation.
 - Update other pages (like the Login page) that use form HTML layout and CSS.


## 29 Dec 2022 - DEV - Ver 4.0.0
 - Add `Client CRUD` support and icons to the Booking Form!
 - Add `user-select:none` CSS to most labels on the booking page.
 - Add memory and speed `performace tracking` to debug logs.
 - Add new ClientModel class to models dir!
 - Improve / change the PHP View Service...
  * Fetch `Include Files` from both `Theme` and `View` dirs,
  * Rename view methods `includeS...File()` to `addS...File()`.
 - Move bookings page modals from the themes dir into content/bookings.
 - Rename the `dayview.model.php` to `day-view.model.php`.
 - Refactor bookings.php controller while adding client model actions.
 - Improve `SelectJS` to accept an `onchange` event handler via HTML attribute.
 - Improve `FormJS`...
  * add an `afterInit` event handler,
  * improve the `showErrors()` method.
 - Change the `Vendor Libs` structure and some vendor lib file names.
 - Drop menu.js script from the `main-menu` template.
 - Fix a mojar bug in the PHP Auth Service.
 - Re-factor the `doc-head template`.
  * All style includes must now be specified in code.
  * Modify doc-head scripts and script includes.
 - Update views affected by changes.

## 07 Jan 2023 - FT - Ver 5.0.0
 - New multi-level menu system (i.e. sub-menus)
 - New file and styles naming convention (update all affected)
 - Remove unused files.
 - Change menu content.

## 08 Jan 2023 - FT - Ver 5.1.0
 - Remove all `<?php` tags from the main view file, making it more
   "Stupid IDE" friendly. Use special HTML tags `<include>`,`<foreach>`,
   `<if>` and the NEW `<eval>` tag, to make the main view file HTML only.

## 09 Jan 2023 - FT - Ver 5.2.0
 - Add a new group of admin pages.
 - Rename content/setup to content/admin

## 15 Jan 2023 - FT - Ver 8.0.0
 - Rename app/content to app/pages!
 - Remove Google Font header includes.
 - Add new favicon.ico with the correct image.
 - Change real text logo back to image text logos.
 - Fix CSS and responsive styles related to new logo structure.
 - Change the `<body>` tag class name from `window` to `max-height-100`.
 - Jump a few version numbers to sync with the project's GIT commit version.

## 18 Jan 2023 - FT - Ver 9.0.0
 - Improve F1 VIEW PHP compile function. 
  * Can now `<include>` components with `props` and `data`.
 - Change many file names again! (New convention)
 - Update Edit/Create dialog title and button text dynamically.
 - Get admin/stations 80% complete.
