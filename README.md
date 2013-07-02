Shopify API Tool
================

Dependencies
============

* [BT Framework](https://github.com/sigsegv42/bt-framework/)


Installation
============

Install dependencies:

```bash
make composer
make deps
```

Setup Apache virtual host (See Apache 2.4 example in conf/apache24.vhost).

Add dev host entry:

```bash
sudo sh -c "echo '127.0.0.1    www.snitches.dev' >> /etc/hosts"
```

Create database:

```bash
mysql -uroot < schema/snitches.sql
```

Developing
==========

Regenerating ORM files:
```bash
php backend/vendor/tqf/bt-framework/tools/generate_tables.php Snitches
```

Fetching placeholder images, e.g.:

```bash 
php tools/fetch_placeholder_image.php 160 160 willamette.gif Willamette
```

The resulting 160x160 image will be saved into tools/cache/willamette.gif

