# Purdy

This package adds HTML entities to text to make it look purdy.

## Install

**Warning: This package is still a work-in-progress. Use at your own risk.**

Add to `composer.json`:

``` js
	"repositories": [
		{
			"type": "vcs",
			"url": "git@github.com:jlbelanger/purdy.git"
		}
	],
```

Run:

``` bash
composer require jlbelanger/purdy @dev
```

## Usage

``` php
\Jlbelanger\Purdy::convert('Lorem ipsum...');
```

Input:

``` html
Lorem "ipsum" dolor... 'sit' amet--consectetur & adipiscing elit.
5 x 5
5'3"
33 1/3
pg. 1-2
'60s Rock 'n' Roll
Ain't Talkin' 'Bout Love
```

Output:

``` html
Lorem &ldquo;ipsum&rdquo; dolor&hellip; &lsquo;sit&rsquo; amet&mdash;consectetur &amp; adipiscing elit.
5 &times; 5
5&apos;3&quot;
33 &frac13;
pg. 1&ndash;2
&rsquo;60s Rock &rsquo;n&rsquo; Roll
Ain&rsquo;t Talkin&rsquo; &rsquo;Bout Love
```

## Development

### Requirements

- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- PHP

### Setup

``` bash
git clone https://github.com/jlbelanger/purdy.git
cd purdy
composer install
```

### Lint

``` bash
./vendor/bin/phpcs
```

### Test

``` bash
./vendor/bin/phpunit
```
