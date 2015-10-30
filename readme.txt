=== WP Smart Link ===
Contributors: carlomanf
Tags: widget, shortcode, link, button, custom field
Tested up to: 4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

An intelligent and powerful widget and shortcode that create links with amazingly little input.

== Description ==

WP Smart Link comprises an intelligent and powerful widget and shortcode that create links with amazingly little input.

= The Widget =

Use the widget to place links in your widget areas (e.g. header, sidebars, footer). The supported fields:

- The name of a custom field that contains the link (only for singular Posts or Pages)
- The ID or the slug of a Post or Page you want to link to.
- The exact URL that you want to link to. It can be on your own website or an external link.
- Your desired anchor text for the link.
- An HTML class you want to apply to the link.

All the fields are optional; just enter the necessary information and WP Smart Link will figure out what kind of link you want to create.

= The Shortcode =

The shortcode is designed to be used within the content of a Post or Page. The supported attributes are the same as the widget fields:

**field**: The name of a custom field that contains the link.

`[smart_link field="related_url"]`

**post**: The ID or the slug of a Post or Page you want to link to.

`[smart_link post="200"]`

`[smart_link post="hello-world"]`

**url**: The exact URL that you want to link to. It can be on your own website or an external link.

`[smart_link url="https://wordpress.org/plugins/wp-smart-link/"]`

**text**: Your desired anchor text for the link.

`[smart_link text="Click Here"]`

**class**: An HTML class you want to apply to the link.

`[smart_link class="button"]`

You can mix and match the attributes and WP Smart Link will figure out what kind of link you want to create. Examples:

`[smart_link post="hello-world" text="Click Here" class="button"]`

== Screenshots ==

1. WP Smart Link widget

== Changelog ==

= 1.0.0 =
* Initial release

= 1.0.1 =
* Fixes a bug

= 1.0.2 =
* Add compatibility for older PHP versions
