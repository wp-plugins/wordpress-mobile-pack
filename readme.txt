=== WordPress Mobile Pack ===
Contributors: jamesgpearce, andreatrasatti
Tags: mobile, mobile web, mobile internet, wireless, pda, iphone, android, webkit, wap, dotMobi, theme, blackberry, admob, mobile adsense, qr-code, device, switcher, cellular
Requires at least: 2.5
Tested up to: 2.8.6
Stable tag: 1.1.9

The WordPress Mobile Pack is a complete toolkit to help mobilize your WordPress site. It has a mobile switcher, themes, widgets, and mobile admin panel.

== Description ==

The WordPress Mobile Pack is a complete toolkit to help mobilize your WordPress site and blog.

It includes a mobile switcher to select themes based on the type of user that is visiting the site, a selection of mobile themes, extra widgets, device adaptation and a mobile administration panel to allow users to edit the site or write new posts when out and about.

The pack has been tested on WordPress 2.5.1, 2.6.5, 2.7.1 and 2.8.1 to 2.8.6. It has been tested on WordPress MU 2.6 in the 'plugins', rather than 'mu_plugins', mode. PHP 5.x is also highly recommended, although the plugin will tolerate PHP4.x.

Features highlights:

*  **mobile switcher**, i.e. the plug-in automatically suggests desktop or mobile presentation, but lets users switch to the other and remembers. Read more about "switching" on [mobiForge](http://mobiforge.com/designing/story/a-very-modern-mobile-switching-algorithm-part-i "A very modern switching algorithm Part I")
*  **base mobile theme**, crafted by [ribot](http://ribot.co.uk "ribot"), a top UK mobile design team, the WordPress Mobile Pack comes with a base theme and 3 color variations that you can choose. All mark-up is valid XHTML-MP 1 and the site scores 5 on [mobiReady](http://mobiready.com "mobiReady")
*  **device adaptation**, the plug-in has basic recognition of mobile devices and is capable of rescaling images, splitting articles and posts in multiple pages, simplifying style and remove media. Theme variations are provided for major families of devices.
*  **mobile admin panel**, allows the blog managers to access the admin interface, specifically designed for mobile, with simplified access to the most common features such as editing a post or approving comments.
*  **mobile ad widget**, easily enable mobile ads with AdMob or mobile Adsense
*  **barcode widget**, add to your full site a barcode that devices with a suitable reader can use to quickly visit the front page of the mobile site, or deep link within it

**Note: this 1.1.9 release features beta provision of special Nokia device themes. Your feedback on these themes is very welcome. They will be fully released (and enabled by default) on 18th December 2009.**


== Installation ==

On WordPress v2.7 and later, the installation is as follows:

1.  Go to the 'Plugins' / 'Add new' menu
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

Also, to complete the installation, the web server needs to have write permissions to the themes directory in *wp-content/themes*.

The Pack comes with complete documentation in HTML format that you can read on your browser. Some of the most common permission issues are covered there.

== Frequently Asked Questions ==

= Where are my widgets? =

You need to select which of your desktop widgets you want to have appear on the mobile theme. Go to the 'Mobile Widgets' admin page to do so.

= Are shrinked images cached? =

Yes, all images, once rescaled, are cached locally.

= Where is the cache directory? =

From your root directory of WordPress, go to:
*wp-content/plugins/wordpress-mobile-pack/plugins/wpmp_transcoder/c*

= What version of PHP do I need? =
Although most of the functionality of the pack does in fact work with PHP4, we only theoretically support and warrant running it with PHP5. If you must use PHP4, give it a test drive and make sure it works for your environment before going live. The plugin will be (deliberately) disabled if you try to use it with PHP6.

= I need more help! =

You are welcome to comment about the pack, suggest new features and ask for help on our public forums, available on [mobiForge](http://mobiforge.com/forum/dotmobi/wordpress "mobiForge WordPress forum").

= How can I help on the project? =

We run the development of the plugin over at [Assembla](http://www.assembla.com/spaces/wordpress-mobile-pack). You can track issues and development progress there. Feel free to volunteer too!


== Changelog ==

= 1.1.9 =
* Multi-device theming engine
* Metadata in post lists can be hidden
* More tolerance of installs on Windows servers
* Changes to comment status now generate emails
* Shortcodes filtered from teasers
* *Beta*: Nokia themes: low, mid, and high templates (http://tinyurl.com/ykc4ear)
* *Beta*: Support for other WebKit devices (iPhone, Android, Palm, etc)
* **NB1**: beta themes are disabled by default in 1.1.9, but will be *enabled* by default in 1.2.0; see the 'Mobile theme' settings
* **NB2**: the base theme patterns have been reworked a little, and any derived themes may need to be updated
* **NB3**: 1.2.0 will be launched on the 18th December
* **NB4**: *Feedback on the Nokia themes is very welcome, nay encouraged!*

= 1.1.3 =
* Ensure subdirectoried blogs work correctly with switcher
* Support object-oriented widgets in WP2.8
* Fixed empty and pre WP2.8 widgets causing invalid XHTML
* Switcher link now always appears in footer on admin pages
* Nokia N97 checkbox rendering fixed

= 1.1.2 =
* Tested to support WP v2.8.4
* Minor typos & theme credits
* Preparation for I18N

= 1.1.1 =
* Tested support for WP v2.8.1
* Improved tolerance of permissions issues at install
* Ability to force the upgrade of themes at install
* Deep-link QR-codes to the page you're on
* User can override detection-only switching
* Switcher race conditions avoided
* Mobile teaser now overrules 'more' break
* Support for Nintendo and Novarra mobile user agents
* PHP4 support
* Numerous minor bug fixes

[Full ticket list](http://www.assembla.com/spaces/wordpress-mobile-pack/milestones/95962)


= 1.0.8223 =
* Initial release


== Screenshots ==

1. This is an example of the homepage of a mobilised blog
2. See how the blog footer looks like once you enable ads and archives widget
3. Blog admin Overview
4. Edit a post
