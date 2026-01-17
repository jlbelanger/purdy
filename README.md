# Purdy

Purdy is a Composer package that adds HTML entities to text to make it look purdy.

## Features

| Input                                                               | Output                                                                                                    |
| ------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------- |
| `Lorem "ipsum" dolor... 'sit' amet--consectetur & adipiscing elit.` | `Lorem &ldquo;ipsum&rdquo; dolor&hellip; &lsquo;sit&rsquo; amet&mdash;consectetur &amp; adipiscing elit.` |
| `5 x 5`                                                             | `5 &times; 5`                                                                                             |
| `5'3"`                                                              | `5&apos;3&quot;`                                                                                          |
| `33 1/3`                                                            | `33 &frac13;`                                                                                             |
| `pg. 1-2`                                                           | `pg. 1&ndash;2`                                                                                           |
| `'60s Rock 'n' Roll`                                                | `&rsquo;60s Rock &rsquo;n&rsquo; Roll`                                                                    |
| `Ain't Talkin' 'Bout Love`                                          | `Ain&rsquo;t Talkin&rsquo; &rsquo;Bout Love`                                                              |

## Requirements

- PHP 8.4+
- [Composer](https://getcomposer.org/)

## Install

**Warning: This package is still a work-in-progress. Use at your own risk.**

Run:

```bash
composer config repositories.purdy vcs git@github.com:jlbelanger/purdy.git
composer require jlbelanger/purdy @dev
```

## Usage

```php
\Jlbelanger\Purdy::convert('Lorem ipsum...');
```

## Development

### Requirements

- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- PHP

### Setup

```bash
git clone https://github.com/jlbelanger/purdy.git
cd purdy
composer install
```

### Lint

```bash
./vendor/bin/phpcs
```

### Test

```bash
./vendor/bin/phpunit
```
