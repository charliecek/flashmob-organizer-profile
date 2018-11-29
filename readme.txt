=== Flashmob Organizer Profile (with login/registration page) ===
Requires at least: 4.8
Tested up to: 4.9.8
Requires PHP: 5.6
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.html

Creates flashmob shortcodes, forms and maps

== Description ==

Creates shortcodes for flashmob organizer login / registration / profile editing form and for maps showing cities with videos of flashmobs for each year

**Version history**

= v4.6.10: Fixed when top bar (for login/logout) is shown =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.10)
- fixed when top bar (for login/logout) is shown

= v4.6.9: added youtu.be video link form, small profile form changes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.9)
- added youtu.be video link form
- small profile form changes

= v4.6.8: Participant CSV download buttons =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.8)
- Participant CSV download buttons

= v4.6.7: Submission history view, fixes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.7)
- fixed bug: flashmob organizer check on submission
- removed a couple of DEVEL comments, logs
- admin filter table count update on row removal
- admin js: callback fn with proper variable passing
- leader submission history
  - cookie saving, include admins
  - NF submission date offset fix, date format refactor
  - progress views for leader submission history
- fix in participant sort
- improvement: admin filter can search checkboxes (yes/no)

= v4.6.6: participant sorting, htaccess generation, static map fix =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.6)
- fixed "moved_from_user_id" (moving participants between leaders)
- improved htaccess generation and added call on subsite creation
- added participant sorting by registration date
- fix: region added also for static map api call (og image)
- new main form

= v4.6.5: dancer num check, geocoder region, fixes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.5)
- added dancer number check
  - form won't submit
  - marker won't show the field
- added region to geocoder so Slovak cities are preferred
- fixed hiding of before-flashmob fields
- fixed evaluating whether user is before flashmob
- fix: double line break when signup link is empty (after flashmob)
- fix: default value of organizer marker template

= v4.6.4: individual flashmob hide/unhide, bugfixes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.4)
- added possibility to hide/unhide individual users' flashmob fields
  - fix: do not show before-flashmob fields before flashmob if present
- raised admin ajax timeout
- fix: video link regex check
- form fix: video_link usermeta default
- form map js fixes:
  - draggable callback wasn't assigned correctly
  - lat, lng present caused address to be ignored
  - preview map refresh on organizer checkbox change

= v4.6.3: flashmob cancel, tshirt_disabled check, fixes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.3)
- added submission check for tshirt_disabled option
- added ajax call to cancel flashmob and/or move or delete participants
- added admin js to florp-option-changes screen
- added admin ajax button option to reload page
- fixed default field value setting on successful submission

= v4.6.2: option refactoring, logging =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.2)
- done some option refactoring
- added option change logging

= v4.6.1: form import bugfix, admin view improvements =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.1)
- small admin view improvements:
  - table filter count
  - participant count on leaders list
- bugfix: forms without version were imported in spite of no change

= v4.6.0: tshirt order date send dates =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.0)
- added tshirt order date send dates (adding, csv)
- some refactoring
- JS: admin datetime picker

= v4.5.7: payment deadlines, missed submissions, fixes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.7)
- css fix: gap after preferences
- added payment deadline options and related logic
- added missed submissions (visible by blog admin only)
- refactored maybe_unserialize_array method
- added missing option labels
- new flashmob form

= v4.5.6: Form check, 2017 reimport, leader history admin table =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.6)
- added check to prevent submission to archived forms (main, flashmob)
- reimport users from 2017 correctly
- added history view in admin for yearly map options (leaders)

= v4.5.5: admin table filter, readme =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.5)
- added admin table filter
- added readme.txt

= v4.5.4: form export versioning, refactoring =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.4)
- added participant registration date import
- added form export/import versioning
- added ninja form export on form save
- moved participant tshirt related options to flashmob options
- BEGIN/END blocks for better code folding
- added page/form/popup/site IDs to admin dropdowns

= v4.5.3: replacement of flashmobbers tab, profile success msg fadeOut =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.3)
- added replacement of flashmobbers tab (ajax)
- added fadeOut on profile success message

= v4.5.2: added tshirt order cancelling =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.2)
- added tshirt order cancelling

= v4.5.1: tshirt ordering disable, timed tshirt payment warning, bugfix =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.1)
- added admin css (and .button-warning)
- added disabling of tshirt ordering
  - posibility to hide or only disable the checkbox
- added timed showing of payment warning button where available
  - 7 days after registration
- fixed bug: organizer checkbox and flashmob city must be disabled if leader has participants
  - added warning icon for it in list of participants, tshirts
- added participant registration time to CSV

= v4.5.0: tshirt payment notifications, site cloning =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.5.0)
- site cloning: simple and with external plugin (MUCD)
- site cloning admin screen
- tshirt payment notifications
- admin ajax: added more possibilities, success actions

= v4.4.3: bugfix =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.4.3)
- fixed bug with forms when both forms have the same ID

= v4.4.2: map (pre)view bugfix =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.4.2)
- bugfix: map (pre)view didn't use flashmob_city for "vytvorit"

= v4.4.1: fixes, improvements =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.4.1)
- better get_tshirt logic (paid/unpaid/all)
- added leader and webpage to tshirt data
- fixed bug: tshirts only for non-pending participants
- fixed bug: leaders don't have to pay for tshirts
- refactored get_leader_webpage for multiple use
- fix: city webpage based on flashmob city, not user city

= v4.4.0: tshirt page with csv download, admin ajax, fixes =
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

= v4.3.6: Added check for participant t-shirt related fields =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.6)
Added check for participant t-shirt related fields

= v4.3.5: Fixes, improvements =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.5)
- extended jQuery jBox function to remember all instantiated jBoxes
- fixed jBox position on mobiles
- fixde multicolumn fields on mobiles
- added variations to site matching

= v4.3.4: fixed preview when shown on the right half of screen =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.4)
fixed preview when shown on the right half of screen

= v4.3.3: Responsive mobile css fixed, Matching own city website =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.3)
- Responsive mobile css fixed
- Matching own city website
- Trimming ending slash from website info labels
- Minor flashmob form change

= v4.3.2: Added possibility of different tshirt preview image, fixes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.2)
- Added possibility of different tshirt preview image
- changes to profile form, info windows, fields
- checking if email is subscribed to newsletter (via DB)
- fixed bug with radiobutton clearing on submit

= v4.3.1: Bugfixes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.1)
Bugfixes

= v4.3.0: T-shirt image preview, fixes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.3.0)
- tshirt image preview
- field checking, error messages with field label
- new tshirt images
- new form exports
- other fixes


[View the rest on Github](https://github.com/charliecek/flashmob-organizer-profile/releases?after=v4.3.0)