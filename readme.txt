=== Add Plain-Text Email ===
Contributors: DvanKooten, Ibericode
Donate link: https://dannyvankooten.com/donate/
Tags: email, text email, html email, spam, spamassassin
Requires at least: 3.1
Tested up to: 6.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a text/plain email to text/html emails to decrease the chance of emails being tagged as spam.

== Description ==

= Add Plain-Text Email =

This plugin will add a `plain/text` version of your HTML emails to your WordPress emails. This decreases the chance of your legit emails being marked as spam by tools as SpamAssassin.

This plugin comes without any settings. When activated, it will automatically look for HTML emails being sent using the `wp_mail()` function and when necessary add the plain text version.

If you have more question about the why's of this plugin, take a look at the FAQ.

**More information**

- More [WordPress plugins](https://dannyvankooten.com/wordpress-plugins/) by Danny van Kooten.
- Source code of this plugin on SourceHut: [~dvko/wp-add-plaintext-email](https://git.sr.ht/~dvko/wp-add-plaintext-email)

== Installation ==

= Installing the plugin =
1. In your WordPress admin panel, go to *Plugins > New Plugin*, search for *Add Plain Text Email* and click "Install now"
1. Alternatively, download the plugin and upload the contents of `add-plain-text-email.zip` to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the plugin. Your HTML emails will now automatically have a plain text version attached.
1. *(Optional)* Test your new mail score using [http://mail-tester.com/](mail-tester.com)

== Frequently Asked Questions ==

= Why add a plain text version? =
Because it decreases the chance of your *legit* email being marked as being spam and thus disappearing in spam folders.

http://wiki.apache.org/spamassassin/Rules/MIME_HTML_ONLY

= Will this mess up my HTML email? =
No, the plugin does not affect the HTML message of emails.

= Will the people I send email to notice? =
No, 99% of all email clients will just show the HTML version of the email.

The other 1% can't properly display HTML and will show the plain text email. Without this plugin, they would have had nothing to show.

= Where can I check my SpamAssassin score? =
You can use the following online tools to test the *spammyness* of your WordPress emails.

http://mail-tester.com/
http://isnotspam.com/
http://spamscorechecker.com/
http://www.port25.com/support/authentication-center/email-verification/

== Changelog ==

= 1.2 - Nov 20, 2023 =

- Preserve href attribute from `<a>` elements. Thanks Benjamin Danon!
- Remove `PHPMailer` parameter type as it somehow isn't working on some set-ups...


= 1.1.3 - Dec 23, 2022 =

- Remove incorrectly working check to prevent running more than once.
- Update tested WP version.
- Add license information to source code.

= 1.1.2 - September 1, 2015 =

Remove faulty debugging statement.

= 1.1.1 - August 31, 2015 =

**Improvements**: The plugin is now a lot smarter when it comes to adding line-breaks.

= 1.1 - August 24, 2015 =

- Fixed: WordPress's "lost password" emails were stripped of links.
- Improvement: Now only running on `text/html` emails with no text version.

= 1.0 - October 21, 2013 =
* Initial release

