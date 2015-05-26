=== Tractis Identity Verifications plugin for Wordpress ===
Contributors: Tractis
Donate link: https://www.tratis.com/pricing
Tags: identity verification, identity, verification, certified comments, comments, certified profile, profile, electronic certificates, certificates, dni electrónico, dnie, 
Author URI: https://www.tractis.com/home/identity/verifications
Plugin URI: https://www.tractis.com/wordpress
Requires at least: 2.0.2
Tested up to: 4.2.2
Version: 1.4.3
Stable tag: 1.4.3
License: MIT License
License URI: http://opensource.org/licenses/mit-license.php

Allow your users to use their e-IDs to prove their true identity.

== Description ==

= What is an e-ID? =

[Governments around the world are issuing e-ID](https://www.tractis.com/countries) to their citizens. 

An e-ID is an electronic certificate that exists as a standalone software file or inside the chip of an electronic identity card.

= What is this plugin for? =

The Tractis Identity Verifications plugin for Wordpress gives your users the option to user their e-ID in order to verify their true identity before posting comments in your blog.

Currently, the plugin supports [79 electronic certificates from 33 Certification Authorities in 14 countries](https://www.tractis.com/certificates)

= How does the identity verification process work from the user perspective? =

1. The user clicks on the identity verification button to initiate the identity verification process (see screenshot 1).
2. The user verifies her identity at the Tractis Identity Verification Gateway (see screenshot 2). You can [customize the gateway with your logo and colors](https://www.tractis.com/home/identity/verifications/tour#customized-gateway). 
3. Once the user has verified her identity and posted a comment, that comment will show and identity verification banner (see screenshot 3).
4. If another user clicks on the identity verification banner, he will be redirected to an identity verification proof that makes possible to check the commenter’s true identity.

Here you have a video of an actual identity verification process: 
https://vimeo.com/7576389

= How much does it cost to use this plugin? =

You can use the plugin for free. There is no cost per identity verification performed.

= Translations =

The Tractis Identity Verifications plugin for Wordpress is currently available in English, Spanish, Catalan and Italian.

If yow want to collaborate to translate the plugin to other languages, send us an email to <translations@tractis.com>.

= Additional information =

Please, visit the [Tractis Identity Verifications Plugin Help](https://www.tractis.com/wordpress).

If you need additional information, send us an email to <verifications@tractis.com>.

== Installation ==

This plugin requires php_openssl module working on your php installation in order to comunicate with tractis services via https.

Please, visit the [Tractis Identity Verifications Plugin Help](https://www.tractis.com/wordpress) for full installation and setup instructions.

Any doubts or comments, send us an email to <verifications@tractis.com>.

== Frequently Asked Questions ==

Please, visit the [Tractis Identity Verifications Plugin Help](https://www.tractis.com/wordpress) for Frequently Asked Questions about the plugin.

Any doubts or comments, send us an email to <verifications@tractis.com>.

== Screenshots ==
1. Identity verification button.
2. Identity verification gateway.
3. Identity verification banner.
4. Identity verification proof.

== Changelog ==

= 1.4.3 =
* Support for Wordpress version 4.2.2 and updates to the plugin Wordpress page

= 1.4.2 =
* Support tested for tested Wordpress 2.9 (2.9 RC1). No need to update from 1.4.1, 

= 1.4.1 =
* Plugin settings now detect if PHP openssl is enabled

= 1.4 =
* Capitalization of cert name (display_name) and several documentation updates

= 1.3.1 =
* Alert blog admin if default rol on user creation is different to susbcriber (read only)

= 1.3 =
* Fixed path on symlink plugins directory

= 1.2 =
* Fixed bug that caused Tractis Isologo to appear in comments from normal Worpress users

= 1.1 =
* Updates to the plugin Wordpress page

= 1.0.2 =
* Plugin translation into Catalan

= 1.0.1 =
* Plugin translation into Italian [thanks to etms51 vianello]

= 1.0 =
* First release
