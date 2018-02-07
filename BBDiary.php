<?php
/*
 * BBDiary: A girl's diary on one page
 *
 * Prettyboy-yumi
*/

/*
 * User configuration
*/
define("CANON_WEBPATH", "/");
define("DIARY", "/var/http/bbdemo");


/******************************************************\
* You probably don't need to touch anything below here *
* unless you are contributing                          *
* of course                            ~Prettyboy-yumi *
\******************************************************/

// Current working directory
$relpath = $_GET['path'] ?: '/';
// Just write your own virtualization function!
$abspath = realpath(DIARY . $relpath);
if (is_dir($abspath)) $abspath .= '/';

/* Error Handling */
if (!$abspath) {
	$errresponse = "$_SERVER[SERVER_PROTOCOL] 404 Not Found";
	header($errresponse);
}
else if (strpos($abspath, DIARY) === false) {
	$errresponse = "$_SERVER[SERVER_PROTOCOL] 403 Forbidden";
	header($errresponse);
}

else if (is_file($abspath)) {
	$mtype = mime_content_type($abspath);
	if (explode('/', $mtype)[0] != 'text') {
		$fsize = filesize($abspath);
		header("Content-Type: $mtype");
		header("Content-Length: $fsize");
		header("X-LIGHTTPD-send-file: $abspath");
		die;
	}
} ?>
<!DOCTYPE HTML>
<HTML>
<head>
	<title>BBDiary</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
	/* Main Layout */
		body {
			background-color: aliceblue;
			color: black;
			background-image: url('data:image/gif;base64,R0lGODlhLAEsAZEAAP/83y4QUR0AQv///yH/C05FVFNDQVBFMi4wAwEAAAAh+QQFDwADACwAAAAALAEsAQAC/5SPqcvtD6OctNqLs968+w+G4kiW5omm6sq27gvH8kzXNhcE9873vpgL5n7EovFoECqRzKaTpQQsn9SqSmeLTq3c7icgrQkBZLLQi05jsDQl2K2Oy5lu6XmOT+az7u1e/fY30+cniMZmCEM4lNjoaLKI+DhJudFXiZmpcafZ6fkJGio6SlpqeoqaqrrK2ur6ChsrO0tba+tFeKvLt7jrq6jF+Tt80mcXRJwMOVZ2LKkc80xqDAc9GIZKXWj9EpgdycgtIz0KHi6OvhYJlD68DuLd7lsdEi9/v4mvv8/f7/8PMKAlcgL5XSro7x1CfGMOLpTXkN5DdEGaOSM4kViwJf8YM+7aqMUjN3B6RFojWamjyRG5MNlbeQVZJ5Uwa9q8+Y8mznnYnJzb2UTnDjA9gZ4UajSpUg9I3Zl8mQ7qwqa/qC69ijWr1q1cu3r9Cjas2LFknZaNJfXsNztqWREtY7UtpRxs5a5Ka7dU3Lx8+yba67cR3sCfABM+jDix4sWMGzt+DDmy5MmUK1u+jDmz5s2cO3v+DDq06NGkv5ROM/g0HdWsW7u2Zfi1oqLRYoem+9MFUdtilr41M4h3G9o7cQsPdbxfatk+kjN/Dj269OnUq1u/nsE59g7Lt+v2Dko7+Ox1x497K35f+kfo1zMkPq4K3a7uK3TvAYb1ffyt65v//w9ggAIOSGCBBh6IYIIKLshggw6C5d+C+6GWW2MRirHNgwO9UaGGF0TUoYcU0NVMiCJKAOKFA1Yk04kbmvhAiy6+KOOM9rFYo40o4gijjguQCJeKAabo443G9VhkAg4lOSKSTD4JZZRSTklllVZeiWWWWm7JZZdefgmmXUIeOGGUZUo5Zphqrslmm26+CWeccs5JZ5123olnTWkWeKaZef4JaKCCDjqXk1NKZNmeyyw5WZ9EgKRoUpGylOKk11VUoqE+QmppdZBqiVKWConK6JaaEnreqU8iSmqGV7ZkaqZfsgqqqt2sOVin0RnHgKMN/gafALpCxyuYvjI5LKrKlC7LbLOz4hqsqc5OS2211l6LbbbabotQsuAdm6S33I77K7Tibncuuequm5OtyArTbrqTuIocFPSKQyty0dZTalQcuivYvkzBCtGR8vaGQi/vyZoQiKmIx+PBjmyUjcDZ/QsQpnA9bLE6OaqH411qhWyBxJx9HAG4KZWl8rwdY2Uyf+zOTHPNNt+Mc84678xzzz5PVgAAIfkEBQ8AAwAsAAAHACwBEgEAAv+cj6nL7Q8jC7Lai7PevPsPhuJIluaJpipHGe0Kx/JM1/aN5/quvvwPDAqHxKLxiEwql8ym8wmNSqfUqvWKzWq33K73Cw6Lx+Sy+YxOq9fstvsNj8vn9Lr9js/r9/y+/w8YKDhIWGh4iJiouMjY6PgIGSk5SVlpeYmZqbnJ2en5CRoqOkpaanqKmqq6ytrq+gobKztLW2t7i5uru8vb6/sLHCw8TFxsfIycrLzM3Oz8DB0tPU1d4VOddo29ffyizQ0u/B1OXm5+jp6uvs7e7v4OHy8/T19vf4+fr7/P3+//DzCgwIEECxo8iDChwoUMGzrUMO6hRDLeJlpEE/Gixo3BHDt6/AgypMiRJEuaTJDxpIiUKjewbPkggEyYNI28rIkzp86dPHv6/Ak0qNChRIsaPYo0qdKlj24yPVrxqVSUU6tavYo1q9atXLt6/Qo2rNixZMuaPYs2rdq1bNu6fQs3rty5dOvavYs3r969fPv6/Qs4sODBhAsbPow4MV2nivlFbYyQMeTJlCtbvow5s+bNnDt7/gw6tOjRpEubPo06terVrFu7fg07tuzZtGvbvo07t+7dvHtT9E3tMXBokiMUAAAh+QQFDwADACxWAAgA1gDVAAAC/5yPF8ntD6OctNqLs5Zr7Q+G4kiWlWem6sq27gvH8kzX9o3n+s73/g8MCofEovGITCqXzKbzCY1Kp9Sq9YrNarfcrvcLDovH5LL5jE6r1+y2+w2Py+f0uv2Oz+v3/L7/DxgoOEhYaHiImKi4yNjo+AgZKTlJWWl5iZmpucnZ6fkJGio6SlpqeoqaqrrK2ur6ChsrO0trilIr04FLc7vr+wscLDxMXGx8jJysvMzc7PwMHS09TV1tfY2drb3N3e39DR4uPv7bC65Lbk6+zt7u/g4fLz9PX29/j2+g7r3/3Z8PMKDAgQQLGjyIMKHChQwbOnwIMSLCf9vQjaMoMaPGjTscO3r8CDKkyJEkS5o8iTKlypUsW7p8CTOmzJk0a9q8iTOnzp08e/r8CTSo0KFEixo9ChJjNovilL4pAAAh+QQJDwADACwAAAAALAEsAQAC/5yPqcvtD6OctNqLs968+w+G4kiW5omm6sq27gvH8kzX9o3n+s73/g8MCofEovGITColgKXzCWU0m9GqNUm9arfcrvcLDovH5LL5jE6r1+y2+w2Py+f0uv2Oz+v3/L7/DxgoOEhYaHiImKi4yNioGOAYKTl5BGlgSZmpuVmDyfkJGio6SlpqeoqaqrrK2ur6ChsrO0tba3ur5om7y5t7oNsbLAwGPGx8jJysvMzc7PwMHS09TV1tfY2drb3N3e39DR4uPk5ebn6Onq6+zh6W1f41Be8+X29/j5+vv8/f7/8PMKDAgQQLGjyIMKHChQwbOnwIMaLEiRQrWryIMaPGjeYcO3r8CFLIu5Ao5JFUMfKkypUsW7p8CTOmzJk0a9q8iTPngpQ6J/Ds6ROo0KFEixo9ijSp0qVMmzp9CjWq1KlUq1q9WuEnU5NStWL9CjbsJbFNMRUjW/Qs2rVs27p9Czeu3Ll069q9izev3r18+/r9Cziw4MGECxs+jDix4sWMGzt+DDmy5MmUK1u+jDkzDq9KuUblrDm06NGkS5s+jTq16iFqV/Mz65pg69i0a9u+jTu37t28e/v+DTy48OHEixs/jjy58uXMmzuvNfv5NdjSwUWvjj279u3cu3v/Dj68+PHkywMvAAA7');
			font-family:"ヒラギノ角ゴ Pro W3",
			"Hiragino Kaku Gothic Pro",
			Osaka,
			"メイリオ",
			Meiryo,
			"ＭＳ Ｐゴシック",
			"MS PGothic",
			sans-serif;
		}
		h1, h2, h3 {
			font-family: "Palatino Linotype",
			"Book Antiqua",
			Palatino,
			serif;
			font-weight: lighter;
		}
	/* Reader */
		main {
			max-width: 34em;
			margin: auto;
			padding: 10px;
			background: white;
			border: 3px double;
			border-radius: 5px;
		}
		ol, ul {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			list-style-type: none;
			white-space: nowrap;
			list-style-type: none;
			padding: 0;
		}
		li {
			margin: 15px;
		}
		li a {
			padding-left: 5px;
			padding-right: 5px;
			transition: box-shadow 0.5s, color 1s;
			border: 1px solid;
			text-decoration: none;
			cursor: pointer;
		}
		li a:hover {
			box-shadow: -3px 3px 10px;
		}
		article {
			text-align: justify;
		}

		header {
			text-align: center;
		}

		footer {
			text-align: center;
			margin: auto;
		}
		a,
		a:visited {
			outline: none;
			color: inherit;
		}
		a:hover {
			text-decoration: none;
		}
	/* Navigation bar */
		nav a {
			border-top: 1px solid;
			border-bottom: 1px solid;
			border-right: 1px solid;
			padding-right: 8px;
			padding-left: 8px;
			border-radius: 8px 8px 0 8px;
			text-decoration: none;
		}
		nav a:first-child {
			border-left: 1px solid;
		}
	</style>
</head>
<body><main>
<header>
<h1>BBDiary</h1>
<nav><?php
	if ($errresponse) {
		print '<a href="' . CANON_WEBPATH . '">Home</a>';
	} else {
		$chunks = explode('/', $relpath);
		if (empty($chunks[count($chunks)-1]))
			 // Ignore the empty entry after the final '/'
			array_pop($chunks);
		foreach ($chunks as $chunk) {
			if (!is_file(DIARY.urldecode($chunkedpath).$chunk)) {
				$chunk .= '/';
			}
			$chunkedpath .= urlencode($chunk);
			$chunkedpath = str_replace("%2F", "/", $chunkedpath);
			print "<a href='" . "$chunkedpath'>$chunk</a>";
		}
	}
?></nav>
</header>
<hr>
<?php
	if ($errresponse) {
		print "<article>Error: $errresponse</article>";
	}
	else if (is_file($abspath)) {
		$text = file_get_contents($abspath);
		$text = bbbbbbb($text);
		$text = nl22br($text);
		print "<article>$text</article>";
	} else if (is_dir($abspath)) {
		$contents = array_diff(
			scandir($abspath), array('.', '..')
		);
		print "<ul>";
		foreach ($contents as $item) {
			print "<li>";
			$href = urlencode($path) . urlencode($item);
			$href = str_replace("%2F", "/", $href);
			if (is_file($abspath.$item)) {
				print "<a href='"
				. $href
				. "'>$item</a>";
			} else {
				print "<a href='"
				. $href
				. "/'>$item</a>";
			}
			print "</li>";
		}
		print "</ul>";
	}
?></main>
</body>
</HTML>
<?php
/*
 * Like strpos but does not loop over the
 * entire string when given an offset
*/
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
/*
 * Magical BBCode parse
*/
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
function nl22br($string)
{
	return str_replace("\n\n", "<br/><br/>", $string);
}
?>
