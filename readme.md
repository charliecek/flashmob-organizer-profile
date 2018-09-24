# Flashmob Organizer Profile (with login/registration page)
**Requires at least**: 4.8
**Tested up to**: 4.9.8
**Requires PHP**: 5.6
**License**: GPLv3
**License URI**: https://www.gnu.org/licenses/gpl.html

## Description

Creates shortcodes for flashmob organizer login / registration / profile editing form and for maps showing cities with videos of flashmobs for each year

## Version history

### v4.6.2: option refactoring, logging
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.2)
- done some option refactoring
- added option change logging

### v4.6.1: form import bugfix, admin view improvements
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.1)
- small admin view improvements:
  - table filter count
  - participant count on leaders list
- bugfix: forms without version were imported in spite of no change

### v4.6.0: tshirt order date send dates
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.0)
- added tshirt order date send dates (adding, csv)
- some refactoring
- JS: admin datetime picker

### v4.5.7: payment deadlines, missed submissions, fixes
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.7)
- css fix: gap after preferences
- added payment deadline options and related logic
- added missed submissions (visible by blog admin only)
- refactored maybe_unserialize_array method
- added missing option labels
- new flashmob form

### v4.5.6: Form check, 2017 reimport, leader history admin table
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.6)
- added check to prevent submission to archived forms (main, flashmob)
- reimport users from 2017 correctly
- added history view in admin for yearly map options (leaders)

### v4.5.5: admin table filter, readme
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.5)
- added admin table filter
- added readme.txt

### v4.5.4: form export versioning, refactoring
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.4)
- added participant registration date import
- added form export/import versioning
- added ninja form export on form save
- moved participant tshirt related options to flashmob options
- BEGIN/END blocks for better code folding
- added page/form/popup/site IDs to admin dropdowns

### v4.5.3: replacement of flashmobbers tab, profile success msg fadeOut
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.3)
- added replacement of flashmobbers tab (ajax)
- added fadeOut on profile success message

### v4.5.2: added tshirt order cancelling
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.2)
- added tshirt order cancelling

### v4.5.1: tshirt ordering disable, timed tshirt payment warning, bugfix
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.1)
- added admin css (and .button-warning)
- added disabling of tshirt ordering
  - posibility to hide or only disable the checkbox
- added timed showing of payment warning button where available
  - 7 days after registration
- fixed bug: organizer checkbox and flashmob city must be disabled if leader has participants
  - added warning icon for it in list of participants, tshirts
- added participant registration time to CSV

### v4.5.0: tshirt payment notifications, site cloning
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.0)
- site cloning: simple and with external plugin (MUCD)
- site cloning admin screen
- tshirt payment notifications
- admin ajax: added more possibilities, success actions

### v4.4.3: bugfix
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.4.3)
- fixed bug with forms when both forms have the same ID

### v4.4.2: map (pre)view bugfix
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.4.2)
- bugfix: map (pre)view didn't use flashmob_city for "vytvorit"

### v4.4.1: fixes, improvements
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.4.1)
- better get_tshirt logic (paid/unpaid/all)
- added leader and webpage to tshirt data
- fixed bug: tshirts only for non-pending participants
- fixed bug: leaders don't have to pay for tshirts
- refactored get_leader_webpage for multiple use
- fix: city webpage based on flashmob city, not user city

### v4.4.0: tshirt page with csv download, admin ajax, fixes
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.4.0)
- fixed validation on registration form
- added admin view for ordered tshirts
  - with button "paid"
  - with buttons "download CSV - all/unpaid"
- added button "delete" to admin participant list
- added possibility of purging info about paid tshirts (DEVEL)
- added ajax for florp admin pages
- fixed leader tshirt preview change to flashmob city
  - instead of user city

### v4.3.6: Added check for participant t-shirt related fields
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.6)
Added check for participant t-shirt related fields

### v4.3.5: Fixes, improvements
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.5)
- extended jQuery jBox function to remember all instantiated jBoxes
- fixed jBox position on mobiles
- fixde multicolumn fields on mobiles
- added variations to site matching

### v4.3.4: fixed preview when shown on the right half of screen
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.4)
fixed preview when shown on the right half of screen

### v4.3.3: Responsive mobile css fixed, Matching own city website
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.3)
- Responsive mobile css fixed
- Matching own city website
- Trimming ending slash from website info labels
- Minor flashmob form change

### v4.3.2: Added possibility of different tshirt preview image, fixes
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.2)
- Added possibility of different tshirt preview image
- changes to profile form, info windows, fields
- checking if email is subscribed to newsletter (via DB)
- fixed bug with radiobutton clearing on submit

### v4.3.1: Bugfixes
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.1)
Bugfixes

### v4.3.0: T-shirt image preview, fixes
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.0)
- tshirt image preview
- field checking, error messages with field label
- new tshirt images
- new form exports
- other fixes

### v4.2.1: Bugfix - rewriting of version to old value
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.2.1)
Bugfix - rewriting of version to old value

### v4.2.0: New registration forms and related changes
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.2.0)
New registration forms and related changes

### Map info window templates as options
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.1.0)
- added map info window templates as options
  - improved separation of optional placeholders by line breaks
- added styling for form trigger link

### v4.0.3: LWA default template evaluation fix, Admin leaders table fix
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.0.3)
- LWA: default template evaluation fix
- Fixed leaders table in admin
  - table was missing participants if leader was pending

### v4.0.2: LWA: new FLORP template, template path fix; login links
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.0.2)
- LWA
  - new FLORP template (SVK)
  - template path fix
- New options for login bar links
- Added separate option for GM Static Key
- Fixed saving of 'use static map' option (flashmob)

### v4.0.1: Fixes for pending leaders - shown in admin
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.0.1)
- Fixed bug with static activation/deactivation methods
- Pending leaders shown in admin
- Removed users' participants are deleted

### v4.0.0: New profile
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.0.0)
- separated options for main and flashmob site + related refactoring
- improved deprecated keys removal

- migrate subscribers to main blog

- JS: use the right main/flashmob variables
  - bReloadAfterSuccessfulSubmission
  - iProfileFormPopupID
  - iProfileFormNinjaFormIDMain

- added lwa option to hide floating info box
- added setting for profile page (both main and flashmob)
- created stub for teachers map
- created shortcode for profile (on main blog) with blog check
- fixed loading of NF based on blog we're on


- content filter for dedicated profile page
  - only on the dedicated page(s)
    - if user is not logged in, the [florp-profile] shortcode is used
    - elseif there is no shortcode, the whole content is replaced
    - else the original content is used
- added PLL language to page dropdown (if available)

- florp scroll ID added
- marking popupLinks as deprecated
- fixing bug with NF localize field filter
- CSS changes to accomodate form without PUM Popup
- duplicate lang ID fix in LWA

- Pending user role and approval settings
- LWA fixes, approval messages, HTML text before login form
- Teacher map preview, JS refactoring, form changes

- More profile form changes
  - added placeholder to course info fields
  - flashmob date/time replacement
  - localize fields: show/hide, default values for new fields
- Teacher map generation from shortcode
- New settings: google maps key, fb app id, successful login msg
- Added possibility to cleanup only specific values in list fields
- Fixed showing/hiding of 'courses_city_2'

- Preparing NF submit check for flashmob profile
- Added header links for profile
- Fixed login after successful registration

- Login message fixes
- Email notification fixes

- Option to prevent direct media downloads via .htaccess
- Admin notices - refactoring
- Other small changes

- API subscribing/unsubscribing newsletter subscribers

- Flashmob form, validation, participant signup

- Fixed map reloading on pum close for both main and flashmob
- Started clearing of form on Flashmob blog

- Marker reload on successful form submission
- Clearing flashmob form on successful form submission
- Fixed togglable events for flashmob form
- attr() -> prop()
- iHasParticipants florp js var
- flashmob form changes

- Improved flashmob map archivation
  - only archiving flashmob related fields
  - purging participants when archiving
  - improved logic on when to archive

- Fixed help NF jBox tooltips on popups
- Messages to participants (registered, removed)
- Added DB logging
- Added new_user_notification fallback function
- Change of new user admin emails in case approval is needed
- Removed password and email change emails when updating via NF
- Added placeholder info to setting screens
- Fixed JS bug when getting tab divID
- Disabled Flashmob Organizer checkbox if leader has participants
- Reviewed and fixed logged_in logic in JS and PHP
  - a user is shown as logged in even if they have no role on site
- GDPR info tooltips in NF forms

- Leader notification cron
- Leader profile list of participants
- Admin leader and participant list tables
- Refactoring

### v3.0.0: Registration form (shorter than profile form) for non-organizers, NF import, own Recaptcha, other improvements and fixes
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v3.0.0)
Registration form not only for organizers
- Automatic generation of user name
- Login via email after registration
- introducing subscriber types
- fix: only flashmob organizers' city should be checked

Registering custom recaptcha field (only for logged out users)
- enqueuing JS for Recaptcha_logged-out-only
- hiding Recaptcha_logged-out-only field if logged in
- cleaning up: class.florp.actions and Recaptcha_logged-out-only
- recaptcha JS callback - without this the form couldn't be sent

Ninja Forms
- unifying NF form field manipupation (preview, real)
- import/export functionality (for easy upgrades)
- NF form:
  - empty calc values on list checkboxes caused warnings
  - Organizator -> Instruktor
  - adding warning about checking flashmob_organizer
  - adding class to distinguish the map preview wrapper div

Maps
- show map preview:
  - on form load based on location if location is present
  - on form load based on city if location is not present
  - on city change based on city if location is not present
  - based on city if location is removed
  - when location is not present, coordinates are not updated
  - when location is not present, marker is not draggable
- version bump to 3.0.0
- for logged in users, always showing their own marker(s) on load
- fixing marker positioning bug (when updating with no coordinates)
- fixing bug: mapInfo call returned non-organizer info with city
  - this caused their info to show up on the map without a marker

Imported LWA into plugin, added hook to disable original LWA

Devel exceptions
- FLORP_DEVEL: exception on mail sending, admin notice when on
- FLORP_DEVEL_PREVENT_ORGANIZER_ARCHIVATION constant

Other
- adding plugin uri
- introducing upgrade method
  - upgrade routine for subscribers->organizers prior to v3.0.0
- hiding/unhiding fields based on subscriber type (PHP and JS)
- hide/unhide JS animation
- settings page fix: added wrapper div
- fixing/improving toggling logic for warnings


[View the rest on Github](https://github.com/charliecek/flashmob-organizer-profile/releases?after=v3.0.0)