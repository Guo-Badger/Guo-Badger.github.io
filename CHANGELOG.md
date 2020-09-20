# Change Log

## [1.11.0] - 2019-09-17

### Fixed

- Refined targeting of accordion headers so styles do not affect headings inside accordion panel (!508)
- Fixed ACF Image figcaption font color on dark backgrounds (!509)
- Fix multibyte character breaking sourcemaps (!510)
- Fixed accessibility issues on Faculty/Staff pages (!512)

### Added

- Added breadcrumb support for Events Calendar; fixed general tag breadcrumb linking (!507)

## [1.10.1] - 2020-07-13

### Fixed

- Initializes heading level value within page elements (!504)

## [1.10.0] - 2020-07-09

### Fixed

- Fixed hero headline and inset positioning in mobile so that it no longer overlaps the image (!474)
- Fixed issue causing non-published posts to show up in search results (!480)
- Fixed issues in image alt text when using quotes or other special characters (!481)
- Fixed height calculation on accordion panels with floated content (!486)
- Fixed main nav and subnav focus styles to match hover styles (!487)
- Fixed issue in `latest_posts` ACF population of child theme custom post types (!488)
- Fixed `z-index` issue causing lightbox to be under cookie consent form (!491)
- Header level hierarchy errors caused when a content layout heading is set (!492)

### Added

- Added the ability to reset custom fac/staff slug to default (!476)
- Added styling for filterable dropdowns in Gravity Forms (!484)
- Add support for the `wp_body_open` action (!485)
- Added `do_faviconico` hook to restore university-branded crest "W" favicon (!494)
- Added error handling in uw_rss_feed shortcode (!496)
- Added filter for custom post type arguments (!497)

### Updates

- Updated size of images used for Open Graph tags (!464)
- Updated breadcrumbs schema to fix issue from Google Console, improve breadcrumbs accessibility, and move breadcrumbs outside of the `<main>` element (!473)
- Refactored the deprecated use of `contextual_help` to current WordPress standards (!490)
- Replace node-sass with sass for preprocessing styles (!495)
- Updated NVM version to `lts/erbium`

## [1.9.0] - 2020-03-05

### Fixed

- Handle link list orphans that end in special characters (!454)
- Remove top-level SCSS ampersand to fix an issue with compiling the UW Theme stylesheet on newer versions of SASS (!458)
- Fixed “Back to Top” accessibility and display issues (!465)
- Fixed issue with image carousel images getting jumbled in mobile views/narrowed screen sizes (!467)
- Fixed how manual excerpts are evaluated for pages and posts (!468)
- Added functions_exists check to prevent fatal PHP error (!469)
- Fixed issue with accordion panels not expanding to full size for certain types of content (!470)
- Increased specificity of background_image field selector (!471)
- Fixed a 1px gap in mobile menu handling logic (!472)
- Fixed issue with the background for content layouts resizing when accordions or tabbed content are used (!475)

### Added

- The excerpt field on a post or page is now shown in the editing view by default so that users no longer need to toggle this on (!456)
- Upon activation of the UW Theme site search will be turned on automatically (if a site previously had the UW Theme active this will not overwrite any configured settings) (!457)

### Updates

- Updated jQuery2 to the latest jQuery3, added the jQuery3 Migrate plugin to console.log deprecation warnings, and patched both Slick and MagnificPopup for a couple minor deprecation warnings (!429)
- Updated ACF auto excerpt to save in separate post meta field (!447)
- Improved accessibility of the hero carousel by setting hero container’s aria landmark to “region” and adding aria label (!455)
- Changed the function used to format content for the excerpt field of pages and posts (!466)

## [1.8.2] - 2020-01-16

### Fixed

- Fixed bug with post/page excerpts in the social_media_meta_tags() function. (Also removes social meta tags from search results pages) (!460)

## [1.8.1] - 2020-01-09

### Fixed

- Fixed bug in the new Faculty/staff admin settings menu affecting standalone Wordpress sites (!451)

## [1.8.0] - 2020-01-09

### Fixed

- Removed background color on accordion internal elements to ensure background is white regardless of content layout background. (!439)
- Fixed an issue where hero carousel images were being miscounted when certain images were set to be hidden. (!440)

### Added

- Option to customize the slug of the Fac/Staff pages (!444)
- Added the ability to hyperlink the tagline in the header with HTML. (!446)
- ‘Back to Top’ option added to the text editor (!448)
- Added support for “Reduce Motion” browser-defined accessibility setting (!352)

### Updates

- Changed hover behavior of focused tab in a Tabbed Grouping to have a white background, in order to better-differentiate from an active/selected tab. (!441)
- Updated the styles for the `<code>` element to more closely match the `<pre>` element. (!435)
- Removes the conditional logic that determines if the Page Converter and Theme Helper are included in the admin menu. (!422)
- Updated the mobile menu button font to Verlag (!442)
- Updated the social media icons (!443)
- Refactor the `uw_acf_excerpt()` function to save the page builder auto-generated excerpt into a new post meta field rather than outputting it to the normal WordPress excerpt field. (!447)

### Removed

- Removed emoji support on very old browsers. (!406)

## [1.7.0] - 2019-11-07

### Fixed

- Corrects the image size used in several page elements — Image, Image Gallery, Alternating Content Boxes.. This will prevent extremely large images from being displayed when smaller images suffice. (!418) (!419) (!421) (!426)

### Added

- Create new stylesheet to override styles in the wpDataTables plugin (!430)

### Updates

- Updates to the way the theme version is set on enqueued files and fixes version bump scripts. (!416)
- Update node-sass to 4.12 (!423)
- Removed styleguide files (!424)
- Small change to make the height of page title minibars 6px (!425)
- Update cookie consent to latest version (!431)

## [1.6.0] - 2019-09-05

### Fixed

- Group of links page element
  - Adds filter function to prevent the “more link” icon from begin orphaned on a line by itself. (!402)
  - Replaces flexbox with the CSS property [column-count](https://developer.mozilla.org/en-US/docs/Web/CSS/column-count) for the group of links page element to prevent large gaps of white space in the layout. Note: List items do not display in logical order from left to right; column-count simply breaks an element’s content into the specific number of columns. (!405)
- Centers Linkedin icon in faculty/staff listing within two-column and ensures bio content outputs within proper HTML tags.
- Updates the Today’s Events page element to group events only by month, so that events in the same month but different years do not get grouped together. (!397)
- Increases CSS specificity to ensure links inside of an accordion panel are blue regardless of whether the parent container has a background color. (!401) (!411)

### Added

- Adds a function to enqueue cookie consent script if the domain ends in wisc.edu. The function can be overwritten in the child theme. (!407)

### Updates

- Replaces hard-coded instances of the Verlag and Georgia font to use the UW Theme Sass variables to reduce duplicate code and allow developers to override variables, rather than specific CSS targets. (!394)

## [1.5.0] - 2019-06-07

### Fixed

- Filter hero slides server side (!385)
  - Filters out disabled heroes in PHP instead of SlickJS's Filter feature
  - Leaves the uw-hero-enabled CSS class in place in case child themes are styling off it.
  - Changes Windows line endings back to Linux line endings (they got messed up at some point).

### Added

Add action that allows child themes to render custom page builder blocks (!386)

### Updates

- Removed privacy from customizer (!382)
  - Removed privacy policy section from the customizer Added filter to uwmadison_footer_privacy template tag so that privacy policy link can be changed by child theme developers.
- Updated privacy notice URL and link text to reflect change from privacy notice…(!387)
  - Updated privacy notice URL and link text to reflect change from privacy notice to privacy statement on wisc.edu website
- Improved accessibility for accordion elements (!383)

## [1.4.1] - 2019-05-02

### Fixed

- Fixes Apple touch icons and adds additional favicon meta
  - Based on best practices per both https://realfavicongenerator.net/ and https://github.com/h5bp/html5-boilerplate
  - These changes have been recently added to the official UW web templates and to the favicon download on brand.wisc.edu (!363)
- Fixes HTML validation error on fac-staff single page
  - Removes p tag from inside h2 tag wrapping title
  - Updates css so new markup matches old in appearance
  - Adds if statement to bio block so empty div not rendered if no bio present (!371)
- Fixes redirecting links and minor spelling and Markdown issues in README and CONTRIBUTING
  - Removes some extraneous whitespace at the end of a few lines (!378 - thanks @james-skemp)
- Pagination a11y update
  - Updates uwmadison_posts_pagination filter to wrap navigation ul in a nav element; removed role="navigation" and aria-label from ul (!372)
- Fixes invalid use of `aside` HTML elements in sidebar
  - Replaces aside with div in before_widget and after_widget arguments to register_sidebar for Blog and Archive sidebars so that there are no nested aside elements in sidebars; updated CSS so that sidebar appearance remains the same as it was before change was made (!370)
- Fixes duplicate IDs in SVGs
  - Updates get_svg function to force new id to be generated for title and description elements each time svg is generated to avoid duplicate ids when the same svg is rendered more than once on a page (!346)
- Fixes Featured Content page element
  - Moves/updates if statements in content-parts/page-elements/featured-content.php so that empty a tags are not rendered when no image is included in the featured content.
  - In a minor, but unrelated update, added uw-footer-header class to h2 in footer to fix a11y contrast error (!368)

### Added

- Adds Google Console Verification option to theme customizer
  - Adds a Google Console Verification option to theme customizer
  - When a value has been added, a meta tag containing the site verification ID will be added to the page
  - This also renames the "Analytics" Customizer menu option to "Google Services" (!362)
- Adds default privacy statement to footer
  - Gives site administrators option of entering a custom url in customizer that will be used in footer in place of the default (!377)
- Used uw_favicon action for applying new favicons
  - Moved the earlier favicons change into this action hook, which means the UW default favicons will be set if a site has not uploaded a site icon in the Customizer (!366)

### Updates

- Update the ACF JSON to allow the use of the embed element in the page builder's three column layout (!361)
- Style 'group of links' submenu links in accordance with brand standards (!353) (!365)
  - Adds additional padding to the nested menus in the link list component based on feedback.
- Fixes heading color on page elements with white background (!354)
- Display the archive page for the UW Staff Type taxonomy in alphabetical order
  - Sets the sort order of the archive page for the UW Staff Type taxonomy to alphabetical order. The archive was previously sorted by the date in which the posts were added (!373)
- Underline links by default in page content
  - Updates styles of anchor tags to display with underlines (!374)
- Updates the Google Analytics snippet to the latest version and move to the top of the head tag (!375)

## [1.4.0] - 2019-02-07

### Updates

- Update ACF version to 5.7.9 (!335)

## [1.3.1] - 2019-01-16

### Fixed

- Places h2 header within div wrapper to ensure UW logo in footer is center aligned (!349)
- Allows UW Theme Helper Tool to support multi-site environments (!348)

## [1.3.0] - 2018-12-18

### Fixed

- Accessibility improvements to utility menu (!315)
  - Adds aria-label to callout university name in utility menu
  - Adds role attribute of `navigation` to utility menu
  - Removes UW Crest logo from the tab order
  - Adds h2 header in footer only viewable to screen readers to improve semantic hierarchy of footer content
- Accessibility improvements to decorative images (!316):
  - Sets focus to false for SVGs to remove them for the tab order in IE11
  - Sets aria-hidden to true for caret symbols to hide them from screen readers
- Fixes error caused when trying to render social media icons on a site with no posts (!341)

### Added

- Adds `Theme Helper Tool` to project as admin page that provides option to remove ACF fields stored in the database and reset page templates to use the default UW Theme template (!319)
- Adds Wordpress action hook immediately after opening `<head>` element

### Updates

- Updates UW Events plugin to version 1.2.4 which secures the API by using HTTPS (!343)
- Updates Ruby version to 2.5.1 (!336)

### Tests

Includes the addition and removal of test code in order for team to test automation processes (!324) (!325) (!326) (!327) (!328)

### Changed

Moves tag manager code snippet immediately after opening `<head>` element per Google’s recommendation (!339)

### Removed

- Removes extraneous code from ACF json file (!321) (!329)
- Removes extraneous span tags from social meta tags (!349)
- Removes unclosed PHP tags from `lib/theme-helper-tool.php` (!340)
- Removes unused Jekyll framework from project build tools (!336)

### Hotfix

Adds code from hotfix that allows users to hide featured images from posts into the project (!318)

## [1.2.2] - 2018-05-15

### Fixed

- Refactor the functionality that hides the featured image (!306)

## [1.2.1] - 2018-05-15

### Fixed

- Remove filter that adds feature image checkbox on archive pages (!300)

## [1.2.0] - 2018-05-09

### Changed

- Add touch icons for both apple and android mobile devices (!259)
- Add filter to RSS Feed to allow the RSS Feed shortcode to be overridden by a child theme (!260)
- Add option to include Google Tag Manager via the Customizer (!262)
- Make "View More" and "News" link consistent with UW styles (!268)
- Add stylesheet for Gravity Forms plugin with minor style adjustments (!266)
- Add checkbox to show or hide featured image within posts (!272)
- Add additional sub-title field to Faculty/Staff post type (!271)
- Update hero area language to match the lower content area (!273)
- Allow faculty staff list biography field to be displayed as an excerpt (!277)
- Update post listing to allow a custom "More" link for all types of posts (!281)
- Give Editors the ability to randomize images within the hero carousel (!280)
- Add social media meta tags to header for Twitter, Google+, Facebook, and Linkedin (!283)
- Replace `grunt-version` with `bump-regex` and corresponding npm script changes (!294)

### Removed

- Remove FormHack.io styles in favor of Foundation's form styles (!263)
- Remove placeholder text from Website Issues Contact within the Customizer (!288)
- Fix cell misalignment in calendar view for those using Events Calendar Pro (!285)

### Fixed

- If hero images are hidden an empty space will no longer display (!269)
- Header colors and font weight inconsistencies for all row background options (!270)
- Replace deprecated function in UW Events plugin to be compatible with PHP 7.2 (!275)
- Allow changes to the Website Issues Email in the Customizer to refresh the page preview (!276)
- Firefox and Android formatting issues for the Faculty/Staff list element (!278)
- Add extra escaping to search variable (!274)

## [1.1.3] - 2018-02-07

### Fixed

- Fixed bug in faculty/staff listing page element when selecting staff by type

## [1.1.2] - 2018-02-01

### Changed

- Adds action hook to footer (!243)
- Change the max-width of .uw-pe.uw-pe-latest_posts to 100% (!242)
- Allow Dashicons on Front End (!241)
- Turn on data deep linking for tabbed element (!220)
- Allow site title and description in header to be filtered (!238)

### Removed

- Remove Old Hero content (!236)

### Fixed

- Exclude event queries from ordering by title (!240)
- Add Alt-Text to Bucky Head in Faculty/Staff Lists (!234)
- Underline links in list items (!237)
- Fix carousel “Learn More” links from wrapping on iPad’s (!235)
- Adjust Language on Fac/Staff to "By Type" not "By Category" (!231)
- Update to 1.2.2 of UW events plugin (!230)
- A simpler fix for the SVG issue (!226)
- Edit Hero Content Area ACF (!225)
- Resize utility links submenu if it is closest to window edge (!221)
- Change KB Doc reference in customizer admin view (!222)
- Add image specs to custom fields (!224)

## [1.1.1] - 2017-10-16

### Fixed

- Removed the maximum height on the hero area, which fixes issues where headline text was getting cut off at some sizes (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/210)
- Header element is now available on the Group of Links element in a 1-column layout (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/206)
- Display issues for images with captions (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/189 and https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/209)
- Fixes a bug for sites using foreign accents in tab titles (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/211)
- Fixes display issues with the hero image inset in Internet Explorer (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/213)
- Fixes display issues with mobile menu on Internet Explorer (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/215)
- Adds a little more space between the main page title and the first row (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/216)
- Adjusts the line spacing in the top/utility menu (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/214)

## [1.1.0] - 2017-08-30

### Deprecated

- Attachment pages (the standalone pages for media files) no longer allow comments (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/186)

### Changed

- Custom Post Type archive setting now defaults to `false` (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/172)
- Custom Post Types are now sorted alphabetically in archives. Applies to Faculty/Staff, Documents, or custom post types added to child themes. (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/169)
- UW Crest updated (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/173)
- Moves Hero overlay (Headline option) to bottom left (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/178)

### Fixed

- Improves filtering for Documents Listing when filtering by category or type. (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/157)
- Fixes breadcrumb issue when WooCommerce is being used. (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/174)
- Color contrast fixes (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/166)
- npm-shrinkwrap.json file added to be skipped in build rake task (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/167/diffs)
- Admin interface search issues resolved (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/168)
- Removes dead link in Faculty/Staff breadcrumbs (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/176/)
- Display issues with lower content area (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/182)
- Properly sets aria-hidden to true on nav menu dropdown caret icons (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/194)
- Formatting/display issues with numbered lists (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/181)
- Formatting for bulleted lists in Faculty/Staff listings (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/179)
- Formatting issue for text blocks with inline images (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/190)
- Formatting issue for images with captions on pages where there is a sidebar (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/189)
- Formatting issue for centered lists (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/193)
- Removes space in styling for `.uw-outer-row` (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/191)
- Issues with today.wisc.edu events feeds (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/183)
- Updates deprecated `sanitize_url` to `esc_url_raw` (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/198)
- Adjust default Foundation table background color to adhere with WCAG AA color contrast specs (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/197)

### Added

- Add Media button added to Faculty/Staff pages to allow media to be added to bio section (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/180)
- New, expanded character set for fonts (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/177)
- A shortcode for displaying RSS feeds (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/187)
- A default, official UW favicon (https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/201)

## [1.0.0] - 2017-05-17

### Deprecated

- A new hero content element has been added to the theme. The original hero element will continue to work but will be removed from the theme with version 1.1.0, which will not release before July 1, 2017. A very noticeable _ALERT_ box and message will appear when editing pages with the legacy hero content fields. Use the new hero content fields as instructed to reset your pages' hero content.

### Fixed

- Rewrote auto excerpt function to work in PHP 5.4
- All hero images will now be 100% width of the browser window
- Fixed bug with URL field in factuly/staff extra fields

## [1.0.0-beta.4] - 2017-05-05

### Deprecated

- A new hero content element has been added to the theme. The original hero element will continue to work but will be removed from the theme with version 1.1.0, which will not release before July 1, 2017. A very noticeable _ALERT_ box and message will appear when editing pages with the legacy hero content fields. Use the new hero content fields as instructed to reset your pages' hero content.
- Removed content-parts/content-search.php, which was not being used. ([!127](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/127))
- Removed faculty/staff permalink. This was named '/staff' (e.g. yoursite.wisc.edu/staff). Sites must flush permalinks for this to take effect ([!135](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/135))

### Development process changes

- After beta-v3 releases, we switched to making all merge requests against the upstream dev branch. Going forward, all new changes (except bug fixes/hotfixes) will be merged into dev instead of master. New version releases will occur when we merge the dev branch into master. This will mean dev is always the most bleeding edge version of the theme, while master is the latest stable release.

### Added

- New hero carousel options: ([!106](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/106))
  - The hero can include one or more content panels. If more than one panel is entered, the hero area will become a carousel.
  - Each panel can contain either a:
    - standalone image
    - an image with a headline set manually that can optionally link to a URL
    - an image with a headline fed from a page or post that will link to the page or post
    - an image with an inset box that features an optional image and excerpt text that can link to a page or post or ad hoc URL
- New faculty/staff post type options:
  - Added _LinkedIn_ field to Faculty/staff post type ([!107](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/107))
  - Added an _Extra fields_ feature to faculty/staff custom posts that allows you to enter an unlimited number of arbitrary data elements, each of which has a label, value and optional URL that the value will link to. ([!140](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/140))
  - Added ability to control size of photos in faculty/staff listings, or to not use photos at all ([!119](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/119))
- Added feedback email link to footer for accessibility and other questions. This address can be set in the Customizer or, otherwise, will use the site admin email address as set in _Dashboard > Settings > General_ ([!109](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/109))
- Added ability to define a custom 404 error page in the Customizer. Also added a `[uw-search-input]` shortcode that can be used in a custom 404 page to render your site's search form. ([!126](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/126))
- Added support for oEmbed Kaltura videos ([!88](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/88))
- Added ability to set class name and/or id on a page layout row ([!86](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/86))
- Added option to add caption when using the Image page element ([!96](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/96) [!101](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/101))
- Added action hooks in to allow greater flexibility for child themes to customize the header and footer areas. ([!105](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/105)) Specifically:
  - `uw_after_body_open_tag`
  - `uw_after_header`
  - `uw_after_menus_inside`
  - `uw_after_menus_outside`
  - `uw_before_footer`
  - `uw_inside_footer`
  - `uw_after_footer`
- `content-search-wp.php` now supports adding a custom search template partial in child themes ([!123](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/123))

### Changed

- _Latest Posts_ element is now labeled _Posts Listing_ to better reflect its function ([!137](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/137))
- Restyled _Posts Listing_ element ([!87](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/87))
- Posts Listing individual posts option can now add any kind of post or page ([!151](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/151))
- Link styling now uses _text-decoration: underline_ instead of _border-bottom_ ([!77](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/77))
- Removed author bylines from post index lists and single views ([!90](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/90))
- Improved ARIA attribute implementation in menus and footer elements ([!78](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/78) [!99](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/99) [!132](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/132))
- Updated Advanced Custom Fields Pro plugin that is embedded in theme to 5.5.7 ([!92](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/92))
- Removed video title/info from embedded Youtube videos ([!93](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/93))
- Improved whitespace padding around UW content box element ([!118](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/118))
- `<button>` elements now take on same style as `.uw-button` class ([!120](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/120))
- The Page Builder custom fields now only apply to pages that use the default template or no template. This change allows child themes to define custom templates. ([!98](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/98))
- Foundation front-end framework was upgraded to 6.3.1. Developers who have previously cloned the project should run `npm update foundation-sites` to update Foundation. ([!100](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/100))
- Moved the Google Analytics code to the `<head>` ([!136](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/136))

### Fixed

- Fixed sort order for Latest Posts element (now named _Posts Listing_). ([!87](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/87))
- IE11 dynamic mobile menu breakpoint javascript error ([!80](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/80))
- Removed stray whitespace margin between page body and footer ([!102](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/102))
- Fixed error in breacrumbs markup ([!83](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/83))
- Fixed duplicate HTML IDs bug in SVG con implementation ([!81](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/81))
- Fixed various color contrast issues ([!84](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/84) [!104](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/104) [!124](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/124) [!150](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/150))
- Fixed clearing layout issues with various page elements ([!89](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/89))
- Fixed header white space styling bug ([!94](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/94))
- Don't exclude `package.json` from git archive ([!95](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/95))
- Fixed page converter tool bulk convert bug ([!97](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/97))
- The events element now uses PHP's `date()` function instead of `strftime()` to provide better support in Windows ([!122](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/122))
- Added support for password-protected pages ([!146](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/146))
- Fixed issue that was preventing gravity forms with conditional logic from displaying ([!113](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/113))
- Fixed spacing issue between inline images and buleted lists ([!134](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/134))
- Fixed minibar alignment issue in three-column layouts ([!148](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/148))
- New print styling now wraps long URLs ([!147](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/147))

## [1.0.0-beta.3] - 2017-01-05

### Added

- Added option to include bio in the staff listing page element
- Added option to specify a header field when using Group of Links page element in 2- and 3-column layout boxes
- Added new options Latest Posts page element
  - Display post featured image
  - Choose custom post types
  - Select individual posts
  - Select multiple post categories
- Adds function that sets _UW-Madison_ at end of page title; can be overridden in child theme
- Added meta tag which forces browsers out of Internet Explorer compatibility mode ([!132](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/132))

### Changed

- Unbundles jQuery2 from main.js and properly registers it in place of the default Wordpress jQuery1. jQuery is also now loaded in No Conflict mode in line with Wordpress conventions. (Note: sites with custom JS code that assumed jQuery was _not_ in No Conflict mode will have breaking JS. This is likely rare since properly written JS for Wordpress should always assume No Conflict mode.) Child themes can deregister the theme's jQuery and register the default one.
- Now includes post types in archive queries
- No longer applies -webkit-font-smoothing: antialised to serif fonts
- Strips _Archive_, _Tag_, _Category_ etc from archive titles
- Displays featured image on single post if there is not a custom content template
- Sets a max-width on single posts without sidebars
- Locks theme on 6.2.x version of Foundation
- Removes h1 format option from the WYSIWYG editor
- Wraps additional theme functions in if !function_exists() checks so child themes can override them as needed
- Updates Slick JS carousel code to improve accessibility
- Add accessibility improvements to image carousel page element
- Add various other accessibility improvements to theme
- Add various minor styling adjustments
- Page Builder pages will now auto-generate a page excerpt unless an excerpt already exists ([!143](https://git.doit.wisc.edu/uw-madison-digital-strategy/uw-theme/merge_requests/143))

### Fixed

- Display logic for quote page element
- Applies ACF Pro patch that fixes bug with preserving the collapsed/uncollapsed state of ACF panels
- Add child theme acf-json directory to ACF load paths
- Fixes Windows incompatible date format in event page lement (thanks Isaac Evavold!)
- Fixes some color contrast issues where color combinations fell below recommended rations for WCAG AA standards
- Fixes bug in native Wordpress search that caused searches to fail if a site was using non-default table prefixes
- Adds IE9 and under polyfill for classList
- Fixes some bugs in the dynamic mobile menu behavior

## [1.0.0-beta.2] - 2016-10-31

### Added

- Added empty partial template at end of footer to allow child theme to add additional footer content
- Added the Group of Links page element to all Page Builder layout areas with proper styling according to layout area
- Added ability to include excerpt in Latest Posts page element
- Added option in Text Block page element to style the content in a "uw-content-box" (i.e. with red bottom border and white background)
- Enhanced theme documentation in README, CONTRIBUTING and CHANGELOG docs, as well as some starter Wiki pages
- Added URL custom field to Wordpress posts that allows pulling in/linking to external URLs
- Adds Pinterst and Flickr as social media options in the Customizer

### Changed

- Updated ACF Pro to 5.4.8
- The crest in the header is in its own template partial allowing a child theme to override
- Dropdown menus in main menus will now only show two levels deep; deeper child menus will not render
- Page Builder page element choices are now arranged alphabetically
- Refactored JS for main menu such that the mobile collapse breakpoint is now set dynamicaly based on the number of main menu items
- improved presentation of Documents

### Fixed

- Test and warn for existence of ACF Pro and UW events plugins installed separate from theme
- Add ability to unset a footer menu
- Fixed menu dropdown bug where dropdowns did not clear correctly when selecting new dropdown
- Fixed mismatch between Customizer default colors and header.php default colors that caused confusion upon initial theme configuration
- fixed various color styling issues
- fixed various accessibility issues identified when running the AMP tool
- fixed layout issue on smaller screen sizes when using the Image Carousel page element on a page
- fixed issues with long text in the hero inset box

## [1.0.0-beta.1] - 2016-10-17

- First tagged release
