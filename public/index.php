<?
	error_reporting(0);
	$qs = $_SERVER['QUERY_STRING'];
	parse_str($qs);
	if (intval($timestamp)) {
		$out = date('l jS \of F Y h:i:s A', $timestamp);
		$title = $out;
	} else {
		$out = "Add a timestamp to the url&hellip;<br/><a href='/1234567890'>http://timestamp.io/1234567890</a>";
		$title = "timestamp.io ~ Human readable timestamps";
	}
?><!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$title?></title>
	<meta charset="utf-8">
	<link rel="icon" href="/favicon.png" />
	<style>body{margin:50px;font-family:sans-serif;text-align:center;}</style>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-268194-2']);
		_gaq.push(['_trackPageview']);
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</head>
<body>

	<?=$out?>

	<script type="text/javascript">
		var _gauges = _gauges || [];
		(function() {
			var t   = document.createElement('script');
			t.type  = 'text/javascript';
			t.async = true;
			t.id    = 'gauges-tracker';
			t.setAttribute('data-site-id', '4fd20e82f5a1f542d9000001');
			t.src = '//secure.gaug.es/track.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(t, s);
		})();
	</script>

</body>
</html>