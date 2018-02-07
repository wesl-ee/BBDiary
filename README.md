# BBDiary

A simple file-browser written in one PHP file, intended for diary-keeping and
other girly things; entries are styled using BBCode Markup (reference below)

## Requisites

1. Webserver capable of executing PHP

2. Text files worth hosting

## Install

Clone the up-to-date repository to get started

`git clone https://github.com/yumi-xx/bbdiary`

Adjust the configuration in the preamble of `index.php` to match your
system. A lot of these options are important in creating a working install,
so do not forget this step!

Next, host `BBDiary.php` using your favorite webserver (Apache,
nginx, lighttpd, etc.).

### Clean URLs

Lastly, you will need to add a rewrite rule to your webserver so you can
access your entries using a more semantic URL. The following rules rewrite
all characters past `/path/to/bbdiary` in the request to mean a path for an
entry. For example, `/path/to/bbdiary/2015/` would be rewritten to
`/path/to/bbdiary?path=/2015` for use in our script.

#### Lighttpd

In your server block:

	url.rewrite-if-not-file = (
		"^/path/to/bbdiary(.+)$" => "/path/to/bbdiary?path=$1"
	)

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

Contributions welcome!
