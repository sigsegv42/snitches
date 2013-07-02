Shopify API Tool
================


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

Updating ORM files:
```bash
php backend/vendor/tqf/bt-framework/tools/generate_tables.php Snitches
```