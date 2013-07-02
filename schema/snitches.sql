CREATE DATABASE IF NOT EXISTS snitches CHARACTER SET utf8;
use snitches;


CREATE TABLE IF NOT EXISTS product (
	product_uuid varchar(36) NOT NULL,
	PRIMARY KEY (product_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS variant (
	variant_uuid varchar(36) NOT NULL,
	PRIMARY KEY (variant_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS image (
	image_uuid varchar(36) NOT NULL,
	PRIMARY KEY (image_uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
