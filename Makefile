.PHONY: theme.zip gumbo-millennium.zip

theme.zip: gumbo-millennium.zip
	cp gumbo-millennium.zip theme.zip

gumbo-millennium.zip:
	# Install / update Yarn
	yarn install \
		--non-interactive

	# Build production output
	yarn run production

	# Build temporary directory
	test -d temp || mkdir temp

	# Zip files
	zip -r \
		temp/new.zip \
		dist/ \
		README.md \
		LICENSE.md \
		functions.php \
		index.php \
		screenshot.png

	# Copy built stylesheet to temporary dir
	cp style.css temp/style.css

	# Update version in temporary stylesheet
	sed -i -r \
		"s/^( \* Version:\s+).+$$/\1$(shell git log -n1 --pretty='%h')/" \
		temp/style.css

	# Add versioned stylesheet
	zip --freshen --junk-paths \
		temp/new.zip \
		temp/style.css

	# Delete temporary stylesheet
	rm temp/style.css

	# Move file over old theme zip
	mv temp/new.zip gumbo-millennium.zip

	# Delete temporary directory (if empty)
	rmdir --ignore-fail-on-non-empty temp/
