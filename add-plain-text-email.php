<?php
/*
Plugin Name: Add Plain Text Email
Plugin URI: http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/
Description: Adds a text/plain email to text/html emails to decrease the chance of emails being tagged as spam.
Version: 1.2.0
Author: Danny van Kooten
Author URI: http://dannyvanKooten.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

defined( 'ABSPATH' ) OR exit;

class APTE {

	/**
	 * Add hooks
	 */
	public function add_hooks() {
		add_action('phpmailer_init', array( $this, 'set_plaintext_body' ) );
	}

	/**
	 * @param PHPMailer $phpmailer
     *
     * Note: somehow we can not type-hint the parameter here as PHPMailer...
	 */
	public function set_plaintext_body( $phpmailer ) {

		// don't run if sending plain text email already
		if( $phpmailer->ContentType === 'text/plain' ) {
			return;
		}

		// don't run if AltBody is set (by other plugin)
		if( ! empty( $phpmailer->AltBody ) ) {
			return;
		}

		// set AltBody
		$phpmailer->AltBody = $this->strip_html_tags( $phpmailer->Body );
	}

	/**
	 * Remove HTML tags, including invisible text such as style and
	 * script code, and embedded objects.  Add line breaks around
	 * block-level tags to prevent word joining after tag removal.
	 */
	private function strip_html_tags( $text ) {
	    $text = preg_replace(
	        array(
	          // Remove invisible content
	            '@<head[^>]*?>.*?</head>@siu',
	            '@<style[^>]*?>.*?</style>@siu',
	            '@<script[^>]*?.*?</script>@siu',
	            '@<object[^>]*?.*?</object>@siu',
	            '@<embed[^>]*?.*?</embed>@siu',
	            '@<noscript[^>]*?.*?</noscript>@siu',
	            '@<noembed[^>]*?.*?</noembed>@siu',
		        '@\t+@siu',
		        '@\n+@siu'
	        ),
	        '',
	        $text );

		// replace certain elements with a line-break
		$text = preg_replace(
			array(
				'@</?((div)|(h[1-9])|(/tr)|(p)|(pre))@iu'
			),
			"\n\$0",
			$text );

		// replace other elements with a space
		$text = preg_replace(
			array(
				'@</((td)|(th))@iu'
			),
			" \$0",
			$text );

        // preserve the href attribute from <a> elements
        $text = preg_replace( '@<a[^>]+href=["\']([^"\']+)[^>]+>(.+)</a>@iu', "\$2 (\$1)", $text );

		// strip all remaining HTML tags
	    $text = strip_tags( $text );

		return  trim( $text );
	}

}

$apte = new APTE;
$apte->add_hooks();
