<?php
/* BBDiary: A girl's diary on one page
 * Prettyboy-yumi */

/* CONFIG_BBDIARY_HOMEPAGE
 * A URL to this diary */
define("CONFIG_BBDIARY_HOMEPAGE", "http://bbdiary.prettyboytellem.com/");
/* CONFIG_DIARY_FSPATH
 * The directory you will be serving */
define("CONFIG_DIARY_FSPATH", "/var/http/bbdemo");
/* CONFIG_APACHE2_XSENDFILE
 * Enable this if you are running Apache with XSendfile */
define("CONFIG_APACHE2_XSENDFILE", false);
/* CONFIG_NGINX_XSENDFILE
 * Enable this if you are running nginx with XSendfile */
define("CONFIG_NGINX_XSENDFILE", false);
/* CONFIG_LIGHTTPD_XSENDFILE
 * Enable this if you are running lighttpd with XSendfile */
define("CONFIG_LIGHTTPD_XSENDFILE", false);

/*******************************************************
* You probably don't need to touch anything below here *
* unless you are contributing                          *
* of course                            ~Prettyboy-yumi *
*******************************************************/

// Current working directory
$relpath = $_GET['path'] ?: '/';
$abspath = realpath(CONFIG_DIARY_FSPATH . $relpath);
if (is_dir($abspath)) $abspath .= '/';

// Error handling
if (!$abspath) {
	$errresponse = "$_SERVER[SERVER_PROTOCOL] 404 Not Found";
	header($errresponse);
}
else if (strpos($abspath, CONFIG_DIARY_FSPATH) === false) {
	$errresponse = "$_SERVER[SERVER_PROTOCOL] 403 Forbidden";
	header($errresponse);
}
else if (!is_readable($abspath)) {
	$errresponse = "$_SERVER[SERVER_PROTOCOL] 403 Forbidden";
	header($errresponse);
}
else if (is_file($abspath)) {
	$mtype = mime_content_type($abspath);
	if (explode('/', $mtype)[0] != 'text') {
		$fsize = filesize($abspath);
		header("Content-Type: $mtype");
		header("Content-Length: $fsize");
		if (CONFIG_LIGHTTPD_XSENDFILE)
			header("X-LIGHTTPD-send-file: $abspath");
		else if (CONFIG_APACHE2_XSENDFILE)
			header("X-Sendfile: $abspath");
		else if (CONFIG_NGINX_XSENDFILE)
			header("X-Accel-Redirect: $abspath");
		else
			readfile($abspath);
		die;
	}
} ?>
<!DOCTYPE HTML>
<HTML>
<head>
	<title>My BBDiary</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- BBDiary Favicon -->
	<link href="data:image/ico;base64,AAABAAEAEBAQAAAAAAAoAQAAFgAAACgAAAAQA
	AAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAD/ScwAAAAAAP8AAAD///8AAAAA
	AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAERERERERERE
	SIiIiIiIiITMjIyMjIyIxEyMjMyMyIjETIyMjIyMiMRMjIyMjIyMjMiMjMyMzIyMSIiIiIi
	IiIRAAAAAAAAABEzMzADMzMAETMAMwMwAzARMzMzAzMzMBEzADMDMAMwETMzMAMzMwARAAA
	AAAAAABEREREREREREAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA
	AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA" rel=icon type="image/x-icon">
	<style>
	/* Main Layout */
		body { background-color: aliceblue; color: black;
			/* Starry background */
			background-image: url('data:image/gif;base64,R0lGODlh\
			LAEsAZEAAP/83y4QUR0AQv///yH/C05FVFNDQVBFMi4wAwEAAAAh+\
			QQFDwADACwAAAAALAEsAQAC/5SPqcvtD6OctNqLs968+w+G4kiW5o\
			mm6sq27gvH8kzXNhcE9873vpgL5n7EovFoECqRzKaTpQQsn9SqSme\
			LTq3c7icgrQkBZLLQi05jsDQl2K2Oy5lu6XmOT+az7u1e/fY30+cn\
			iMZmCEM4lNjoaLKI+DhJudFXiZmpcafZ6fkJGio6SlpqeoqaqrrK2\
			ur6ChsrO0tba+tFeKvLt7jrq6jF+Tt80mcXRJwMOVZ2LKkc80xqDA\
			c9GIZKXWj9EpgdycgtIz0KHi6OvhYJlD68DuLd7lsdEi9/v4mvv8/\
			f7/8PMKAlcgL5XSro7x1CfGMOLpTXkN5DdEGaOSM4kViwJf8YM+7a\
			qMUjN3B6RFojWamjyRG5MNlbeQVZJ5Uwa9q8+Y8mznnYnJzb2UTnD\
			jA9gZ4UajSpUg9I3Zl8mQ7qwqa/qC69ijWr1q1cu3r9Cjas2LFknZ\
			aNJfXsNztqWREtY7UtpRxs5a5Ka7dU3Lx8+yba67cR3sCfABM+jDi\
			x4sWMGzt+DDmy5MmUK1u+jDmz5s2cO3v+DDq06NGkv5ROM/g0HdWs\
			W7u2Zfi1oqLRYoem+9MFUdtilr41M4h3G9o7cQsPdbxfatk+kjN/D\
			j269OnUq1u/nsE59g7Lt+v2Dko7+Ox1x497K35f+kfo1zMkPq4K3a\
			7uK3TvAYb1ffyt65v//w9ggAIOSGCBBh6IYIIKLshggw6C5d+C+6G\
			WW2MRirHNgwO9UaGGF0TUoYcU0NVMiCJKAOKFA1Yk04kbmvhAiy6+\
			KOOM9rFYo40o4gijjguQCJeKAabo443G9VhkAg4lOSKSTD4JZZRST\
			klllVZeiWWWWm7JZZdefgmmXUIeOGGUZUo5Zphqrslmm26+CWeccs\
			5JZ5123olnTWkWeKaZef4JaKCCDjqXk1NKZNmeyyw5WZ9EgKRoUpG\
			ylOKk11VUoqE+QmppdZBqiVKWConK6JaaEnreqU8iSmqGV7ZkaqZf\
			sgqqqt2sOVin0RnHgKMN/gafALpCxyuYvjI5LKrKlC7LbLOz4hqsq\
			c5OS2211l6LbbbabotQsuAdm6S33I77K7Tibncuuequm5OtyArTbr\
			qTuIocFPSKQyty0dZTalQcuivYvkzBCtGR8vaGQi/vyZoQiKmIx+P\
			BjmyUjcDZ/QsQpnA9bLE6OaqH411qhWyBxJx9HAG4KZWl8rwdY2Uy\
			f+zOTHPNNt+Mc84678xzzz5PVgAAIfkEBQ8AAwAsAAAHACwBEgEAA\
			v+cj6nL7Q8jC7Lai7PevPsPhuJIluaJpipHGe0Kx/JM1/aN5/quvv\
			wPDAqHxKLxiEwql8ym8wmNSqfUqvWKzWq33K73Cw6Lx+Sy+YxOq9f\
			stvsNj8vn9Lr9js/r9/y+/w8YKDhIWGh4iJiouMjY6PgIGSk5SVlp\
			eYmZqbnJ2en5CRoqOkpaanqKmqq6ytrq+gobKztLW2t7i5uru8vb6\
			/sLHCw8TFxsfIycrLzM3Oz8DB0tPU1d4VOddo29ffyizQ0u/B1OXm\
			5+jp6uvs7e7v4OHy8/T19vf4+fr7/P3+//DzCgwIEECxo8iDChwoU\
			MGzrUMO6hRDLeJlpEE/Gixo3BHDt6/AgypMiRJEuaTJDxpIiUKjew\
			bPkggEyYNI28rIkzp86dPHv6/Ak0qNChRIsaPYo0qdKlj24yPVrxq\
			VSUU6tavYo1q9atXLt6/Qo2rNixZMuaPYs2rdq1bNu6fQs3rty5dO\
			vavYs3r969fPv6/Qs4sODBhAsbPow4MV2nivlFbYyQMeTJlCtbvow\
			5s+bNnDt7/gw6tOjRpEubPo06terVrFu7fg07tuzZtGvbvo07t+7d\
			vHtT9E3tMXBokiMUAAAh+QQFDwADACxWAAgA1gDVAAAC/5yPF8ntD\
			6OctNqLs5Zr7Q+G4kiWlWem6sq27gvH8kzX9o3n+s73/g8MCofEov\
			GITCqXzKbzCY1Kp9Sq9YrNarfcrvcLDovH5LL5jE6r1+y2+w2Py+f\
			0uv2Oz+v3/L7/DxgoOEhYaHiImKi4yNjo+AgZKTlJWWl5iZmpucnZ\
			6fkJGio6SlpqeoqaqrrK2ur6ChsrO0trilIr04FLc7vr+wscLDxMX\
			Gx8jJysvMzc7PwMHS09TV1tfY2drb3N3e39DR4uPv7bC65Lbk6+zt\
			7u/g4fLz9PX29/j2+g7r3/3Z8PMKDAgQQLGjyIMKHChQwbOnwIMSL\
			Cf9vQjaMoMaPGjTscO3r8CDKkyJEkS5o8iTKlypUsW7p8CTOmzJk0\
			a9q8iTOnzp08e/r8CTSo0KFEixo9ChJjNovilL4pAAAh+QQJDwADA\
			CwAAAAALAEsAQAC/5yPqcvtD6OctNqLs968+w+G4kiW5omm6sq27g\
			vH8kzX9o3n+s73/g8MCofEovGITColgKXzCWU0m9GqNUm9arfcrvc\
			LDovH5LL5jE6r1+y2+w2Py+f0uv2Oz+v3/L7/DxgoOEhYaHiImKi4\
			yNioGOAYKTl5BGlgSZmpuVmDyfkJGio6SlpqeoqaqrrK2ur6ChsrO\
			0tba3ur5om7y5t7oNsbLAwGPGx8jJysvMzc7PwMHS09TV1tfY2drb\
			3N3e39DR4uPk5ebn6Onq6+zh6W1f41Be8+X29/j5+vv8/f7/8PMKD\
			AgQQLGjyIMKHChQwbOnwIMaLEiRQrWryIMaPGjeYcO3r8CFLIu5Ao\
			5JFUMfKkypUsW7p8CTOmzJk0a9q8iTPngpQ6J/Ds6ROo0KFEixo9i\
			jSp0qVMmzp9CjWq1KlUq1q9WuEnU5NStWL9CjbsJbFNMRUjW/Qs2r\
			Vs27p9Czeu3Ll069q9izev3r18+/r9Cziw4MGECxs+jDix4sWMGzt\
			+DDmy5MmUK1u+jDkzDq9KuUblrDm06NGkS5s+jTq16iFqV/Mz65pg\
			69i0a9u+jTu37t28e/v+DTy48OHEixs/jjy58uXMmzuvNfv5NdjSw\
			UWvjj279u3cu3v/Dj68+PHkywMvAAA7');

			font-family:"ヒラギノ角ゴ Pro W3",
			"Hiragino Kaku Gothic Pro",
			Osaka,
			"メイリオ",
			Meiryo,
			"ＭＳ Ｐゴシック",
			"MS PGothic",
			sans-serif;
		}
		h1 { font-family: "Palatino Linotype",
			"Book Antiqua",
			Palatino,
			serif;
			font-weight: lighter; }
		h1 a, h2 a, h3 a { text-decoration: none; }
	/* Reader */
		main { max-width: 34em;
			margin: auto;
			padding: 10px;
			background: white;
			border: 3px double;
			border-radius: 5px; }
		ol, ul { display: flex;
			flex-wrap: wrap;
			justify-content: center;
			list-style-type: none;
			white-space: nowrap;
			list-style-type: none;
			padding: 0; }
		li { margin: 15px; }
		li a { padding-left: 5px;
			padding-right: 5px;
			transition: box-shadow 0.5s, color 1s;
			border: 1px solid;
			text-decoration: none;
			cursor: pointer; }
		.hoverbox { transition: box-shadow 0.5s, color 1s; }
		.hoverbox:hover { box-shadow: -3px 3px 10px; }
		article { text-align: justify; }
		header { text-align: center; }
		footer { text-align: center; margin: auto; }
	/* Link styling */
		a, a:visited { outline: none; color: inherit; }
		a:hover { text-decoration: none; }
	/* Navigation bar */
		nav a { border-top: 1px solid;
			border-bottom: 1px solid;
			border-right: 1px solid;
			padding-right: 8px;
			padding-left: 8px;
			text-decoration: none; }
		nav a:first-child { border-left: 1px solid; }
	</style>
</head>
<body><main>
<header>
<h1><a href="<?php print CONFIG_BBDIARY_HOMEPAGE?>">BBDiary</a></h1>
<nav><?php
		$chunks = explode('/', $relpath);
		if (empty($chunks[count($chunks)-1]))
			// Ignore the empty item for directories
			// (trailing slash)
			array_pop($chunks);
		foreach ($chunks as $n => $chunk) {
			if (!is_file(CONFIG_DIARY_FSPATH
			. urldecode($chunkedpath) . $chunk)
			|| (count($chunks) - $n - 1))
				$chunk .= '/';
			$chunkedpath .= urlencode($chunk);
			$chunkedpath = str_replace("%2F", "/", $chunkedpath);
			print <<<HOVERBOX
<a class=hoverbox href="$chunkedpath">$chunk</a>
HOVERBOX;
		}
?></nav>
</header>
<hr>
<?php
	if ($errresponse) {
		print <<<ERRRESP
	<article>Error: $errresponse</article>

ERRRESP;
	}
	else if (is_file($abspath)) {
		$text = file_get_contents($abspath);
		$text = bbbbbbb($text);
		$text = nl22br($text);
		print <<<RESP
	<article>$text</article>

RESP;
	} else if (is_dir($abspath)) {
		$contents = array_diff(
			scandir($abspath), array('.', '..')
		);
		print <<<UL
	<ul>

UL;
		foreach ($contents as $item) {
			$href = urlencode($path) . urlencode($item);
			$href = str_replace("%2F", "/", $href);
			if (is_file($abspath.$item)) {
				print <<<FHREF
		<li><a class=hoverbox href="$href">$item</a></li>

FHREF;
			} else {
				print <<<DHREF
		<li><a class=hoverbox href="$href/">$item</a></li>

DHREF;
			}
		}
		print <<<EOUL
	</ul>

EOUL;
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
