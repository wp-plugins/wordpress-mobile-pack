=== WordPress Mobile Pack ===
Tags: mobile, wireless, pda, iphone, dotMobi, theme, blackberry, admob, mobile adsense
Requires at least: 2.5
Tested up to: 2.7.1
Stable tag: 1.0.8223

WordPress Mobile Pack is a complete toolkit to help mobilize your WordPress site. It has a mobile switcher, themes, widgets, and mobile admin panel.

== Description ==

The dotMobi WordPress Mobile Pack is a complete toolkit to help mobilize your WordPress site and blog.

It includes a mobile switcher to select themes based on the type of user that is visiting the site, a selection of mobile themes, extra widgets, device adaptation and a mobile administration panel to allow users to edit the site or write new posts when out and about.

The pack has been tested on WordPress 2.5, 2.6, and 2.7. It has been tested on WordPress MU 2.6 in the 'plugins', rather than 'mu_plugins', mode. PHP 5.x is also required.

Features highlights:

*  **mobile switcher**, i.e. the plug-in automatically suggests desktop or mobile presentation, but lets users switch to the other and remembers. Read more about "switching" on [mobiForge](http://mobiforge.com/designing/story/a-very-modern-mobile-switching-algorithm-part-i "A very modern switching algorithm Part I")
*  **base mobile theme**, crafted by a top UK mobile design team, the WordPress Mobile Pack comes with a base theme and 3 color variations that you can choose. All mark-up is valid XHTML-MP 1 and the site scores 5 on [mobiReady](http://mobiready.com "mobiReady")
*  **device adaptation**, the plug-in has basic recognition of mobile devices and is capable of rescaling images, splitting articles and posts in multiple pages, simplifying style and remove media. With the upcoming release of [DeviceAtlas Personal](http://deviceatlas.com/wordpress "DeviceAtlas Personal"), full adaptation will be implemented.
*  **mobile admin panel**, allows the blog managers to access the admin interface, specifically designed for mobile, with simplified access to the most common features such as editing a post or approving comments.
*  **mobile ad widget**, easily enable mobile ads with AdMob or mobile Adsense
*  **barcode widget**, add to your full site a nice barcode that devices with a barcode reader can use to quickly visit the mobile site



== Installation ==

On WordPress v2.7 and later, the installation is as follows:

Go to the 'Plugins' / 'Add new' menu
1.	Upload wordpress-mobile-pack.zip then press 'Install now'.
1.	Activate the switcher plugin. Change its settings as required.
1.	Select which desktop widgets are to appear on the mobile theme.
1.	Enjoy.


On WordPress v2.5 and v2.6, the installation is very slightly different:

1.	Locate your WordPress install on the file system
1.	Extract the contents of wordpress-mobile-pack.zip into wp-content/plugins
1.	Activate the switcher plugin. Change its settings as required.
1.	Select which desktop widgets are to appear on the mobile theme.
1.	Enjoy.


The Mobile Pack also uses a cache directory to improve performance, make sure the Web server has write permissions. The cache directory is, from the root of your WordPress install, in *wp-content/plugins/wordpress-mobile-pack/plugins/wpmp_transcoder/c*.

Also the themes need write permissions and they are in *wp-content/themes*.

The Pack comes with complete documentation in HTML format that you can read on your browser. Some of the most common permission issues are covered there.

== Frequently Asked Questions ==

= Are shrinked images cached? =

Yes, all images, once rescaled, are cached locally.


= Where is the cache directory? =

From your root directory of WordPress, go to:
*wp-content/plugins/wordpress-mobile-pack/plugins/wpmp_transcoder/c*


= I get a parse error in wpmp_switcher.php =

The plug-in uses references in foreach loops (this makes your loops much faster!), but the feature was added only in PHP 5. You can either upgrade (strongly recommended) or you might want to look into the code, we used it a few times, but if you just remove the & it should work.

= I need more help! =

You are welcome to comment about the pack, suggest new features and ask for help on our public forums, available on [mobiForge](http://mobiforge.com/forum/dotmobi/wordpress "mobiForge WordPress forum").

== Screenshots ==

1. This is an example of the homepage of a mobilised blog
2. See how the blog footer looks like once you enable ads and archives widget
3. Blog admin Overview
4. Edit a post

