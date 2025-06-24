=== Webmetic ===
Contributors: webmetic
Tags: analytics, webmetic, statistics, visitor tracking, performance
Requires at least: 5.2
Tested up to: 6.8
Stable tag: 1.0.0
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Easily integrate Webmetic into your WordPress website by adding your Account ID.

== Description ==

Webmetic is a simple and lightweight plugin that allows you to add the Webmetic script to your WordPress website. Simply enter your Webmetic Account ID in the settings, and the script will be automatically added to all pages of your website.

= Features =

* Easy setup - just enter your Account ID
* Lightweight and optimized for performance
* Script loads asynchronously
* Choose between header or footer placement
* Admin-friendly settings page
* Secure data handling
* Compatible with all WordPress themes

= How it works =

1. Install and activate the plugin
2. Go to Settings > Webmetic
3. Enter your Webmetic Account ID
4. Save the settings
5. The script will now be active on your website

The plugin adds the following script to your website:
`<script src="https://t.webmetic.de/iav.js?id=YOUR_ACCOUNT_ID" async></script>`

You can choose to place the script in either the header or footer (recommended for better performance).

== Installation ==

1. Upload the `webmetic` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > Webmetic to configure the plugin
4. Enter your Webmetic Account ID and save

= Manual Installation =

1. Download the plugin zip file
2. Log in to your WordPress admin panel
3. Go to Plugins > Add New > Upload Plugin
4. Choose the downloaded zip file and click "Install Now"
5. Activate the plugin after installation

== Frequently Asked Questions ==

= Where do I get my Webmetic Account ID? =

You can find your Account ID in your Webmetic dashboard. If you don't have an account yet, visit https://webmetic.de to sign up.

= Is the script loaded on admin pages? =

No, the script is only loaded on the public-facing pages of your website, not in the WordPress admin area.

= Can I choose where to place the script? =

Yes, you can choose to place the script in either the header or footer. Footer placement is recommended for better performance.

= Can I use this plugin on multiple websites? =

Yes, but you'll need to use a different Account ID for each website, or the same Account ID if you want to track all websites together.

= Is the plugin GDPR compliant? =

The plugin itself only adds the script to your website. Please ensure you comply with GDPR and other privacy regulations by informing your users about data collection and obtaining necessary consents as required by law.

== Screenshots ==

1. Webmetic settings page
2. Settings page with Account ID entered

== Changelog ==

= 1.0.0 =
* Initial release
* Basic functionality
* Script placement option (header/footer)
* Admin settings page
* Account ID validation

== Upgrade Notice ==

= 1.0.0 =
First release of Webmetic plugin.