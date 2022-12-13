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
