# mmCMS

A headless CMS. With a REST API.
mmCMS is a Laravel package that provides a REST interface over creating structured data.

## Table of Contents

* [Installation](#installation)
* [Usage](#usage)
* [Development](#development)
* [License](#license)
* [Security Vulnerabilities](#security-vulnerabilities)

## Installation

```bash
composer global require thtg88/mmcms-installer
```

Make sure to place Composer's system-wide vendor bin directory in your $PATH so the `mmcms` executable can be located by your system.
This directory exists in different locations based on your operating system;
however, some common locations include:

- macOS: `$HOME/.composer/vendor/bin`
- Windows: `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin`
- GNU / Linux Distributions: `$HOME/.config/composer/vendor/bin` or `$HOME/.composer/vendor/bin`

You could also find the composer's global installation path by running `composer global about` and looking up from the first line.

Once installed, the `mmcms` new command will create a fresh mmCMS installation in the directory you specify. For instance, `mmcms new blog` will create a directory named `blog` containing a fresh mmCMS installation with all of mmCMS's dependencies already installed:

```bash
mmcms new blog
```

Configure your database connection as you normally do within Laravel.

Next from your terminal run:

```bash
php artisan mmcms:install
```

## Usage

**Coming soon!**

## Development

Clone the repo

```bash
# clone the repo
$ git clone https://github.com/thtg88/mmcms.git mmcms

# create a new Laravel application
$ laravel new mmcms-api
```

Add mmcms as a dependency of your API project in `composer.json`:
```json
{
    ...
    "repositories": [
        {
            "type": "path",
            "url": "../mmcms"
        }
    ],
    "require": {
        ...
        "thtg88/mmcms": "*"
    },
    ...
}
```

Next from your terminal run:

```bash
# Run composer update to bring in mmCMS as dependancy
composer update

# And install mmCMS
php artisan mmcms:install
```

## Tests

mmCMS uses [PHPUnit](https://github.com/sebastianbergmann/phpunit) for testing.

You can run the whole tests suite using:

```bash
composer run-script test

# or
composer test

# or
./vendor/bin/phpunit
```

## License

mmCMS is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Security Vulnerabilities

If you discover a security vulnerability within mmCMS, please send an e-mail to Marco Marassi at security@marco-marassi.com. All security vulnerabilities will be promptly addressed.
