# BBDiary

A simple file-browser written in one PHP file, intended for diary-keeping and
other girly things; entries are styled using Bulletin Board Code (BBCode)

## Requisites

1. Webserver capable of executing PHP

2. Text files worth hosting

## Install

Clone the up-to-date repository to get started

`git clone https://github.com/yumi-xx/bbdiary`

Adjust the configuration in the preamble of `index.php` to match your
system. A lot of these options are important in creating a working install,
so do not forget this step!

Lastly, host `BBDiary.php` using your favorite webserver (Apache,
nginx, lighttpd, etc.). Alternatively, you may simply host the repository
folder, (the `index.php` symbolic link is provided) if your webserver is
already configured to host index files.

### Clean URLs

The config flag `CONFIG_CLEAN_URL` makes the URLs of your diary more
semantic for your users and for search engines. For this flag to have
any meaning, you must add a rewrite rule to your webserver.

The following rules rewrite all characters past `/path/to/bbdiary` in the
request URI to mean a path for an entry. If you enable this flag and
implement the appropriate set of rules, your URLs will look like
`/path/to/bbdiary/2015/` instead of `/path/to/bbdiary?path=/2015`

#### Lighttpd

In `lighttpd.conf`, put:

	server.modules = ( mod_rewrite, ... )

And in your server block:

	url.rewrite-if-not-file = (
		"^/path/to/bbdiary(.+)$" => "/path/to/bbdiary?path=$1"
	)

#### NGINX

Put the following in your server block:

	location /path/to/bbdiary {
		if ($query_string !~* ^?path=) {
			rewrite ^/path/to/bbdiary(.+)$ /path/to/bbdiary?path=$1 break
		}
		# Adjust to your configuration
		fastcgi_pass unix:/var/run/php-fpm.sock;
	}

## Writing Entries

Once you have a working install, the only thing left is to exercise your
creativity and pour your heart out! A little easier said than done, but
these tips will help you master the technical side of it.

### Format

Your index file has a configuration option which points to the root of your
diary on your file system. Each entry can be written as a text file within
this root. For example, an entry in my diary my look like
`/var/diary/2015/05-May/May15`. You may choose to oranize yours by subject
or anything else!

The text of each entry may be marked up by BBCode (reference below) or not
marked up at all! Since I use a modern text editor which hard-wraps at 80
characters per line, BBDiary treats single line breaks as simple whitespace.
. . a double line break indicates a paragraph break.

### BBCode Reference

BBDiary supports Bulletic Board Markup (BBCode); BBCode is a de-facto markup
language used on many messaging boards and forums. It resembles HTML with a
vastly simpler vocabulary. The vocabulary of the BBDiary BBCode interpeter
is as follows:

BBCode Tag | Effect
-----------|-------
[b] | Strong, attention-grabbing
[i] | Emphasis
[color=x] | Colored
[quote] | Blockquote
[url] | Hyperlink
[code] | Pre-formatted text

### Example

Here's an excerpt from one of my entries hosted by BBDiary on
[my website](https://prettyboytellem.com/).

	[b]WipEout 64[/b] and [b]WipEout HD[/b] ([i]Nintendo 64[/i] and [i]PS3[/i])

	Racing games have always been a weakness of mine: they have always found a way
	into my heart because of the artistic freedom that can be taken with the
	world of these games.

## Contributing

Contributions welcome! If you are interested in contributing, the first step
is to clone this repository. Then either add your features and open a pull
request or get in contact with me on
[my website](https://prettyboytellem.com). . . I look forward to hearing from
you!
