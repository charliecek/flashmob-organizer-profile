=== Flashmob Organizer Profile (with login/registration page) ===
Requires at least: 4.8
Tested up to: 5.2.4
Requires PHP: 5.6
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.html

Creates flashmob shortcodes, forms and maps

== Description ==

Creates shortcodes for flashmob organizer login / registration / profile editing form and for maps showing cities with videos of flashmobs for each year

**Version history**

= v5.8.1: Added possibility to list all intf participants =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.8.1)
- Added possibility to list all intf participants via a GET parameter.
- Increased tested wp version.

= v5.8.0: Chart color ranges, new intf t-shirts =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.8.0)
- Added color ranges to charts.
- Fixed intf_participant_exists() method to ignore past years by default.
- Added new international flashmob t-shirts. Made sure old tshirt images are not shown from cache.

= v5.7.0: Showing chart on international florp chart submission =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.7.0)
- Added possibility to show chart(s) on intf form submit.
- Fixed multiple typos, bugs in code.
- Limited default intf tshirts list to current year's ones (table, csv).
- Fixed setting of tshirt ordering to checked in cleared form on submit (intf).
- Fixed chart reload bug.
- Fixed missing cities in all-years-map.
- Fixed getting city-based webpage and school webpage.
- Added new SVK flashmob t-shirt images.
- Removed outdated svk flashmob t-shirts.
- Bugfix: intf year admin dropdown.

= v5.6.0: All-years-map video override, YT playlists. =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.6.0)
- Added option to override a city's video shown on the flashmob map of all years.
- Added YT playlist embedding support.
- Removed reCaptcha fields from participant forms.

= v5.5.0: Participant check-in QR code. =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.5.0)
- Added QR code generator that adds participants' check-in url as attachment to their confirmation mail.
- Added hashed check-in url generation.
- Refactored admin table creation so buttons can be reused.
- Added check-in pages (svk/international, with/-out tshirt).
- Fixed some bugs.

= v5.4.1: Checked option archiving =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.4.1)
- Checked SVK and international flashmob archiving.
- New main profile form export.
- Removed a few extra comments.

= v5.4.0: Admin table column toggling. Payment OK notification toggling. =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.4.0)
- Added admin table column toggling (for mobile usability).
- Added possibility to enable / disable payment OK notifications.

= v5.3.1: Added payment OK notification result to CSVs =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.3.1)
- Added payment OK notification result to CSVs.

= v5.3.0: Payment OK notifications =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.3.0)
- Payment OK notifications.
- Option changes saving bugfix.

= v5.2.0: Attendance removal button. Adding danger button class =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.2.0)
- Added attendance removal button.
- Added danger button class for removal/cancel buttons.
- Minor refactoring.

= v5.1.0: added both payment info to both CSV types =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.1.0)
- Added both payment info to both CSV types.
- Removed webpage header from INTF tshirt CSV.
- Fixed date evaluation for non-int timestamps.

= v5.0.0: Participant form submission editing =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v5.0.0)
- Participant form submission editing.

= v4.9.0: Flashmob Admin user roles =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.9.0)
- Added Flashmob Administrator user roles and capabilities

= v4.8.0: International flashmob tshirt list =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.8.0)
- Fixes and improvements in existing admin screens.
- Added international flashmob tshirt list.
- Added admin button hiding.
- Added ajax buttons to both existing and new participant related admin screens.

= v4.7.9: Intf buttons: participant fee payment, attendance =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.9)
- Added international flashmob list admin buttons (and callbacks):
  - participant fee payment
  - set attendance

= v4.7.8: Chart reload and responsiveness fixes. Int. participant CSV export =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.8)
- Chart reload and responsiveness fixes
- International participant CSV export

= v4.7.7: Charts: attribute/option fixes, bug fixes. =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.7)
- Added chart shortcode attributes (some were removed by `shortcode_atts()`)
- Fixed multiple chart display
- Fixed percentage-style chart value counting
- Added responsiveness to charts (redraw on window size change)

= v4.7.6: international flashmob participants admin list =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.6)
- Added International Flashmob participants admin list

= v4.7.5: fix LWA error message on failed login =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.5)
- Fixed empty LWA error message span on failed login

=  v4.7.4: chart reload on intf form submission =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.4)
- Added chart reload on international flashmob NF submission (before PUM close)

= v4.7.3: small visual intf form fixes =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.3)
- small visual intf form fixes

= v4.7.2: charts, intf tshirt imgs, new form =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.2)
- Charts class, chart shortcode for international flashmob city poll
- New international flashmob tshirt images
- Changes to international flashmob participant signup NF form

= v4.7.1: info circle position bugfix =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.1)
- Bugfix: wrong info circle position and popup when multiple forms are on the same page

= v4.7.0: International flashmob signup form =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.7.0)
- Added international flashmob signup form
  - city poll
  - with relevant options like deadlines, selection of cities etc.
  - exporting of the NF form
  - email notifications, tshirt images, newsletter subscription

= v4.6.12: course preview bug, course city number =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.12)
- fixed bug where course preview map wouldn't show additional cities
- added option to configure number of allowed course cities

= v4.6.11: Fixing teacher map, new forms, flashmob city check fix =
[View on Github](https://github.com/charliecek/flashmob-organizer-profile/releases/tag/v4.6.11)
- fixing teacher map (showing flashmob city if coordinates were present)
- adding teacher header in options and markers
- new forms
  - with NL link on banner,
  - fix for hidden non-text description
  - fixed default value for fields of type 'number' (main)
- limiting flashmob city check to users on given blog only

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


[View the rest on Github](https://github.com/charliecek/flashmob-organizer-profile/releases?after=v4.6.7)