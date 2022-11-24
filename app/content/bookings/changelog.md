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

## 24 Nov 2022 - Ver 2.3.0
 - Beautify booking summary and detail views - DONE
 - Create a user with a lesser role, e.g. admin and validate against that to prevent unauthorized updates - DONE
 - MRP - Click on date in Date Nav to open a calendar modal to select the current date - DONE
 - Add an event handler for selecting the date from the calendar modal - DONE
 - Fix issue with unwanted REQUEST params making SAVE fail! - DONE
 - Make top part of calendar view sticky! Rrrr... - DONE
 - Server side validation and feedback system - DONE
 - MRP - Check if time-slot is booked - Validate - DONE
 - MRP - Only creator can edit. Role system - DONE
 - Use the current user's actual ID as created_by an updated_by - DONE