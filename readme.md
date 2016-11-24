[![PayPal donate button](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=MVDJTX9FRBCAA "Donate once-off to this project using Paypal")

# WordPress Term Taxonomy Meta

Requires at least: 3.4
Tested up to: 4.6.1

## Description

Term Taxonomy Meta allows you to create meta fields attached to Term Taxonomy for all custom taxonomies.

## Installation

With composer using [WordPress Packagist](https://wpackagist.org)

```
{
    "require": {
        "vincekruger/wp-term-taxonomy-meta": "dev-master"
    }
}
```
[Download](https://github.com/vincekruger/wp-term-taxonomy-meta/tags "Download") the package and unzip to your plugins folder.

## Known Issues

> There is no administration panel to manage the meta.  This is all managed via
> the database directory in the 'posts' table as a custom post type.

```
INSERT INTO `wp_posts` (`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `post_modified`, `post_modified_gmt`, `menu_order`, `post_type`) VALUES
(1, NOW(), NOW(), 'JSON_OBJECT', 'Meta Name', '', 'publish', NOW(), NOW(), 0, 'tt-meta');
```

#### Field Reference

Field Name                       | Description
-------------------------------- | -----------
post_author                      | User ID of the author
post_date, post_date_gmt         | Date Created
post_modified, post_modified_gmt | Date Modified
post_content						   | JSON Object *see below
post_title						   | Meta Title displayed in WP-Admin
post_excerpt						   | Description of meta, displayed below the field
post_status						   | Draft, Publish
menu_order						   | Will order the meta fields in WP-Admin
post_type							   | always "tt-meta"

### JSON Object

#### Example

```{"type":"field_text","taxonomy":"taxonomy_name","meta_key":"meta_key_name"}```

#### Values

Key      | Description   					   | Values
-------- | ------------------------------- | ------
type     | What type of field to use       | Field Type
taxonomy | Name of the taxonomy to be used | String
meta_key | Name of the meta key            | String

#### Field Types

Key              | Description
---------------- | -----------
field_attachment | Single file media uploadeder
field_switch     | Switch with Yes/No with options
field_text       | Single line text field
field_textarea   | Multi-line text area