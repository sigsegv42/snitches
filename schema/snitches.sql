CREATE DATABASE IF NOT EXISTS snitches CHARACTER SET utf8;
use snitches;


CREATE TABLE IF NOT EXISTS product (
	product_uuid varchar(36) not null,
	shopify_id int(10) unsigned not null,
	body_html text default null, 
	date_created_timestamp int(11) unsigned not null,
	date_updated_timestamp int(11) unsigned not null,
	handle varchar(50) not null,
	product_type varchar(50) default null,
	published_scope varchar(50) default null,
	tags varchar(100) default null,
	template_suffix varchar(50) default null,
	title varchar(50) not null,
	vendor varchar(50) default null,
	dirty tinyint(1) default 0,
	PRIMARY KEY (product_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS variant (
	variant_uuid varchar(36) not null,
	product_uuid varchar(36) not null,
	shopify_id int(10) unsigned not null,
	date_created_timestamp int(11) unsigned not null,
	date_updated_timestamp int(11) unsigned not null,
	compare_at_price decimal(9,2) unsigned,
	fulfillment_service varchar(50) default 'manual',
	grams int(10) default 0,
	inventory_management tinyint(1) default 0,
	inventory_policy varchar(20) not null,
	inventory_quantity int(10) unsigned default 1,
	position int(10) unsigned not null,
	price decimal(9, 2) unsigned,
	requires_shipping tinyint(1) default 1,
	sku varchar(100) not null,
	taxable tinyint(1) default 1,
	title varchar(150),
	dirty tinyint(1) default 0,
	PRIMARY KEY (variant_uuid),
	FOREIGN KEY (product_uuid) REFERENCES product (product_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS product_option (
	product_option_uuid varchar(36) not null,
	product_uuid varchar(36) not null,
	name varchar(50) not null,
	title varchar(50) default null,
	position int(10) unsigned not null,
	PRIMARY KEY (product_option_uuid),
	FOREIGN KEY (product_uuid) REFERENCES product (product_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS variant_option (
	variant_option_uuid varchar(36) not null,
	variant_uuid varchar(36) not null,
	name varchar(50) not null,
	position int(10) unsigned not null,
	PRIMARY KEY (variant_option_uuid),
	FOREIGN KEY (variant_uuid) REFERENCES variant (variant_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS image (
	image_uuid varchar(36) not null,
	product_uuid varchar(36) not null,
	shopify_id int(10) unsigned not null,
	date_created_timestamp int(11) unsigned not null,
	date_updated_timestamp int(11) unsigned not null,
	position int(10) unsigned not null,
	src varchar(150) not null,
	PRIMARY KEY (image_uuid), 
	FOREIGN KEY (product_uuid) REFERENCES product (product_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS combo (
	combo_uuid varchar(36) not null,
	variant_uuid varchar(36) default null,
	PRIMARY KEY (combo_uuid),
	FOREIGN KEY (variant_uuid) REFERENCES variant (variant_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS combo_option (
	combo_option_uuid varchar(36) not null,
	combo_uuid varchar(36) not null,
	product_option_uuid varchar(36) not null,
	PRIMARY KEY (combo_option_uuid),
	FOREIGN KEY (combo_uuid) REFERENCES combo (combo_uuid),
	FOREIGN KEY (product_option_uuid) REFERENCES product_option (product_option_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- a generic attribute descriptor.
CREATE TABLE IF NOT EXISTS attribute_kind (
	attribute_kind_uuid varchar(36) not null,
	abbreviation varchar(10) default null,
	description varchar(255) not null,
	value_type enum ('string', 'integer', 'boolean', 'float') not null,
	PRIMARY KEY(attribute_kind_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- a single attribute value as it applies to a particular product
CREATE TABLE IF NOT EXISTS attribute_value (
	attribute_value_uuid varchar(36) not null,
	attribute_kind_uuid varchar(36) not null,
	t_value varchar(2000) default null,
	n_value int(10) default null,
	b_value tinyint(1) default null,
	f_value decimal(19,4) default null,
	PRIMARY KEY(attribute_value_uuid),
	FOREIGN KEY (attribute_kind_uuid) REFERENCES attribute_kind (attribute_kind_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
