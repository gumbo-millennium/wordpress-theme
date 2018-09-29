# Gumbo Millennium

**Theme Name**: Gumbo Millennium  \
**Theme URI**: https://www.gumbo-millennium.nl/  \
**Author**: Digitale Commissie  \
**Author URI**: https://www.gumbo-millennium.nl/commissions/dc  \
**Version**: 1.0  \
**License**: Mozilla Public License v2.0  \
**License URI**: https://www.mozilla.org/en-US/MPL/2.0/  \

## Description

Gumbo Millennium theme for integration with Corcel.
Does NOT contain actual theme contents.

## Developing

To work on the plugin, run the following commands

```
composer install
yarn install
```

Lastly, to automatically build the Javascript and Sass files, run the following command:

```
yarn start
```

If you added, renamed or removed PHP files, make sure to update the Composer autoloader!

```
composer dump-autoload
```

## Deployment

The files should be auto-deployed by the Continuous Integration, but if you want to build
your own, you can!

```
make theme.zip
```

or

```
make gumbo-millennium.zip
```

