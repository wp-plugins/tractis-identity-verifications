=== Tractis Identity Verifications ===
Contributors: tractis
Tags: tractis, comments, certified profiles, verified identities, identity, dni, dnie, certificates
Author URI: https://www.tractis.com
Plugin URI: https://www.tractis.com/identity_verifications
Requires at least: 2.0.2
Tested up to: 2.8
Stable tag: 1.1

Your users will be able to identify in your blog using their electronic ID and they will show their verified identity in their comments.

== Description ==

Allow your users to proof their real identity in your blog. Your users will be able to identify in your blog using their electronic ID and they will show their verified identity in their comments.

This plugin requires php_openssl module working on your php installation in order to comunicate with tractis services in https.

== Installation ==

1. Upload the installation zip file to the `/wp-content/plugins/` directory
1. Unzip the file
1. Activate the plugin through the 'Plugins' menu in WordPress
1. [Obtain your API Key on Tractis](https://www.tractis.com/identity_verifications)
1. Configure your plugin through 'Tractis Identity Verifications' in the 'Settigns' menu in WordPress: paste your API Key and choose the button for your blog.
1. Place `<?php widget_TractisAuth(); ?>`

If your theme supports widgets you can enable the Tractis Identity Verifications widget to show the button.

== Frequently Asked Questions ==

= I activated the plugin and nothings happen =

You need to integrate the plugin in your theme, see install document for more info.

= I get PHP errors when the user comes back from Tractis =

If you see error messages like this:

> Warning: fsockopen() [function.fsockopen]: unable to connect to ssl://www.tractis.com:443 (Unable to find the socket transport "ssl" - did you forget to enable it when you configured PHP?)

You need php_openssl module working on your php installation in order to comunicate with tractis services in https.

= Does the plugin change the database model of Wordpress? =

Yes, in order to store the user information the plugin makes the next database changes:

> ALTER TABLE $prefix+comments ADD `tractis_auth_user` varchar(50) NOT NULL DEFAULT '0'
>
> ALTER TABLE $prefix+users ADD `tractis_auth_lastlogin` int(14) NOT NULL DEFAULT '0'
>
> ALTER TABLE $prefix+users ADD `tractis_auth_userid` varchar(250) NOT NULL DEFAULT '0'

== Changelog ==

= 1.1 =
* Changed plugin name and copy

= 1.0.2 =
* Catalan translation

= 1.0.1 =
* Italian translation [etms51 vianello]

= 1.0 =
* First release
