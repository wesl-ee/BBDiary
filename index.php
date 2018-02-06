<?php
define("WEB_ROOT", "https://prettyboytellem.com/writing");
define("DIARY", "/var/diary");

$path = "/";
if (!empty($_GET["path"]))
	$path = $_GET["path"];
if (strpos(realpath(DIARY.$path), realpath(DIARY)) === false)
	die;
if (is_file(DIARY.$path)) {
	$mtype = mime_content_type(DIARY.$path);
	if (explode('/', $mtype)[0] != 'text') {
		header("Content-Type: $mtype");
		header("Content-Length: " . filesize(DIARY.$path));
		header("X-LIGHTTPD-send-file: " . DIARY.$path);
	}
}

function bbbbbbb($string)
{
	$opened = []; $contents = [];
	$offset = 0;
	while (($a = indexOf($string, "[", $offset)) >= 0
	&& ($b = indexOf($string, "]", $offset)) > $a) {
		// Push the parsed contents to an array
		$contents[] = substr($string, $offset, $a - $offset);
		$tag = substr($string, $a, $b + 1 - $a);
		$contents[] = $tag;

		// Since we finished scanning the part of the string
		// that is behind the last seen bracket, advance
		// the scanning offset
		$offset = $b + 1;

		// Strip brackets
		$inside = substr($tag, 1, strlen($tag) - 2);

		// Is this a closing or opening tag?
		if ($inside{0} == "/") {
			$tag = substr($inside, 1);
			if (!count($opened[$tag]))
				continue;
			$opening_tag = array_pop($opened[$tag]);
			$from = $opening_tag["index"];
			$param = $opening_tag["param"];
			$to = count($contents) - 1;

			switch($tag) {
			case  'b':
				$open = "<strong>";
				$close = "</strong>";
				break;
			case 'i':
				$open = "<em>";
				$close = "</em>";
				break;
			case 'color':
				$color = htmlspecialchars($param);
				$open = "<span style='color:$color'>";
				$close = "</span>";
				break;
			case 'quote':
				$open = "<blockquote>";
				$close = "</blockquote>";
				break;
			case 'url':
				$url = htmlspecialchars($param);
				$open = "<a href='$url'>";
				$close = "</a>";
				break;
			case 'code':
				$open = "<pre>";
				$close = "</pre>";
				break;
			default: continue;
			}
			$contents[$from] = $open;
			$contents[$to] = $close;
		} else {
			if (($c = indexOf($inside, "=")) > 0) {
				$tag = substr($inside, 0, $c);
				$param = substr($inside, $c + 1);
			} else {
				$tag = $inside;
				unset($param);
			}
			$opened[$tag][] = [
				"index" => count($contents) - 1,
				"param" => $param
			];
		}
	}
	$contents[] = substr($string, $offset);
	return join($contents);
}
function indexOf($string, $substring, $offset = 0)
{
	$stringlen = strlen($string);
	$sublen = strlen($substring);
	for ($i = $offset, $j = 0; $i < $stringlen; $i++) {
		if ($string{$i} == $substring{$j}) {
			if (!(++$j - $sublen))
			return $i - $sublen + 1;
		} else $j = 0;
	}
	return -1;
}
function nl22br($string)
{
	return str_replace("\n\n", "<br/><br/>", $string);
}
?>
<HTML>
<head>
	<title>BBDiary</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel=stylesheet href="yumi.css">
</head>
<body>
<main class=explorer>
<header>
<h1>BBDiary</h1>
<h3><?php
	$chunks = explode('/', $path);
	if (empty($chunks[count($chunks)-1]))
		array_pop($chunks); // Ignore the empty entry after the final '/'
	foreach ($chunks as $chunk) {
		if (!is_file(DIARY.urldecode($chunkedpath).$chunk)) {
			$chunk .= '/';
		}
		$chunkedpath .= urlencode($chunk);
		$chunkedpath = str_replace("%2F", "/", $chunkedpath);
		print " <a href='" . WEB_ROOT . "$chunkedpath'>$chunk</a> ";
	}
?></h3>
</header>
<hr>
<?php
	if (is_file(DIARY.$path)) {
		if (($text = file_get_contents(DIARY.$path)) === False) {
			$text = 'You lack the requisite permissions';
		}
		$text = bbbbbbb($text);
		$text = nl22br($text);
		print "<article>$text</article>";
	} else {
		$contents = array_diff(
			scandir(DIARY.$path), array('.', '..')
		);
		print "<ul>";
		foreach ($contents as $item) {
			print "<li>";
			$href = urlencode($path) . urlencode($item);
			$href = str_replace("%2F", "/", $href);
			if (is_file(DIARY.$path.$item)) {
				print "<a href='"
				. WEB_ROOT . $href
				. "'>$item</a>";
			} else {
				print "<a href='"
				. WEB_ROOT . $href
				. "/'>$item</a>";
			}
			print "</li>";
		}
		print "</ul>";
	}
?></main>
</body>
</HTML>
