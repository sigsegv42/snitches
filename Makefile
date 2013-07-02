composer:
	curl -sS https://getcomposer.org/installer | php

deps:
	if test -d backend/vendor; \
	then php composer.phar update; \
	else php composer.phar install; \
	fi

.PHONY: deps composer
