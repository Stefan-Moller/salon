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
