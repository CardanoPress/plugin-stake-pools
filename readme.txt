=== CardanoPress - Stake Pools ===
Contributors: pbwebdev
Donate link: https://www.paypal.com/donate/?hosted_button_id=T8MR6AMVWWGK8
Tags: cardano, blockchain, web3, metamask, nami, eternl, ada
Requires at least: 4.9
Tested up to: 6.1.1
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv3
License URI: https://www.gnu.org/licenses/licenses.html

Integrate the Cardano blockchain with your WordPress website. Merging Web2 and Web3.

== Description ==

The Stake Pools plugin allows stake pool operators or projects to list their stake pools for users to delegate their wallets to.

If you're a single stake pool operator, you can simply use the plugin to display your stake pool details and have a connect button that will allow users to use a Cardano based Web3 wallet and delegate to your pool, directly from your website.

As a mulit stake pool operator owner or a projects that is using a collection of stake pools that you may or may not own, you can list the various stake pools by pool ID, have the statistics and data displayed accordingly and allow users to delegate to these stake pools.

This can be used in conjuction with the ISPO plugin that we have created that will provide rewards calculators for those that want to use a group of stake pools for multi rewards distribution, similar to how SundaeSwap ran their ISO in early 2021.

This plugin requires the parent plugin [CardanoPress](https://wordpress.org/plugins/cardanopress/) and a free account with [Blockfrost](http://bit.ly/3W90KDd) to be able to talk to the Cardano blockchain.

The plugin is created by the team at [PB Web Development](https://pbwebdev.com).

You can find out more information about CardanoPress and our blockchain integrations at [CardanoPress.io](https://cardanopress.io).

= Example Use Cases =

There are many sites that have multiple stake pools listed on a site and allowing users to delegate their wallets from that list. Websites such as, [PoolPeek](https://poolpeek.com/), allow you to view these collection of stake pools and delegate your wallet. Our Stake Pools plugin allows you to create a similar site to PoolPeek without any coding knowledge (but of course it will help).


== Screenshots ==
1. Stake Pool configuration screen
2. Adding a stake pool to the list
3. Frontend example


== Follow Us ==

Follow us on [Twitter](https://twitter.com/cardanopress)
View all of our repos on [GitHub](https://github.com/CardanoPress/)
View all of our documentation and resources on our [website](https://cardanopress.io)

== Installation ==

The Stake Pools Plugin requires the parent plugin [CardanoPress](https://wordpress.org/plugins/cardanopress/). The CardanoPress plugin manages the communication with the Cardano blockchain and wallet integrations. Please ensure you install and configure the core CardanoPress plugin before installing the Stake Pools plugin.

This plugin requires your own standalone WordPress installation and access to the web server to add a line of code to your htaccess file.

1. Installing the plugin

Find the plugin in the list at the backend and click to install it. Or, upload the ZIP file through the admin backend. Or, upload the unzipped tag-groups folder to the /wp-content/plugins/ directory.

2. Activate the plugin

Navigate to Plugins from the WordPress admin area and activate the CardanoPress plugin.

The plugin will create the base pages for all that you need.

3. Adding a Stake Pool

From the admin dashboard, navigate to the new Stake Pools area.
From here you can choose ADD to add a new stake pool to your list of pools.
Fill in the required information from name, description and poolID.

4. Add a menu link
Now that you have data, you can link to the Stake Pools page from the menu area in the dashboard allowing users to
navigate to the area on your website.

For more detailed documentation and tutorials on how to use the plugin, please visit the [CardanoPress documentation website](https://cardanopress.io).

== Get Support ==

We have community support available on our website under the [CardanoPress forums](https://cardanopress.io/community/). We also have an online chat support via our [Discord server](https://discord.gg/CEX4aSfkXF). We encourage you to use the forums first though as it will help others that read through the forums for support.


== Frequently Asked Questions ==

= Can I Run This on My WordPress.com Website? =

No you can not. You need full access to your web server to be able to allow for the WASM file type to load. Without this access you will not be able to run the plugin.

= Can I Get Paid Support? =

Yes you can, we offer subscription to support for our plugins and consultation to help get your project started and to a professional level.

= Where Can I See Other Projects That Are Using CardanoPress? =

If you visit our main website, [CardanoPress.io](https://cardanopress.io), there will be a section dedicated to all the websites and projects that have built using CardanoPress.

= Can I customise the look and feel of the plugin? =

Yes, we've built the plugin and sub plugins with hooks and template layouts that can over overridden in a child theme. We've followed the same methods as WooCommerce where you simply need to copy the template files into your child theme to start overriding the layouts.

We've also taking into account page builders and created short codes for all the template parts of the theme. This will allow builders such as Divi, Elementor, WPBakery to be used with CardanoPress.



== Privacy ==

This plugin does not collect or process any personal user data unless you expressively opt-in.

== Changelog ==

You can follow our [GitHub release](https://github.com/CardanoPress/plugin-stake-pools/releases) for full details on
updates to the plugins.

= v0.4.0 =
Update all dependencies

= v0.3.0 =
Escape echoed outputs
Include bootstrap assets locally

= v0.2.0 =
Rebuild corrupt assets
Always return usable pool data

= v0.1.0 =
Initial release; full working concept

== Upgrade Notice ==

Please ensure that you back up your website before upgrading or modifying any of the code.
