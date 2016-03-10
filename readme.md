# hyn/lets-encrypt

[![Latest Stable Version](https://poser.pugx.org/hyn/lets-encrypt/v/stable)][2]
[![License](https://poser.pugx.org/hyn/lets-encrypt/license)][2]

PHP wrapper for the Let's Encrypt api.

## Use as terminal command

```
composer global require hyn/lets-encrypt
```

> Make sure to place the ~/.composer/vendor/bin directory in your PATH so the hyn-le executable can be located by your system.

You can now globally on your system use the command `hyn-le`.

### Requesting a certificate

Make sure you run this as a user who can write files to the public directory of the domain you're requesting a certificate for:

```
hyn-le certificate:request <hostname> <another-hostname-perhaps> --http <path_to_public_dir> -a <account_name> -e <email_address>
```

Use `hyn-le help certificate:request` for more information on all options.

## Use as package

```
composer require hyn/lets-encrypt
```

## About

This package is meant to ease development of Let's Encrypt functionality without
requiring the python commandline utilities.

## Credits

Developed by looking at [Petertjuh360's efforts](https://github.com/Petertjuh360/da-letsencrypt).

## Useful links

- [da-letsencrypt](https://github.com/Petertjuh360/da-letsencrypt)
- [let's encrypt acme spec](https://letsencrypt.github.io/acme-spec/#rfc.section)
- [let's encrypt documentation](https://letsencrypt.readthedocs.org/en/latest/)


[1]: https://github.com/hyn/lets-encrypt
[2]: https://packagist.org/packages/hyn/lets-encrypt