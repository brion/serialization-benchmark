<?php

$iterations = 1000;

function benchmark($str, $data, $callback) {
	global $iterations;

	echo "Benchmarking $str...";

	$start = microtime(true);
	for($i = 0; $i < $iterations; $i++) {
		$stuff = $callback($data);
	}
	$delta = microtime(true) - $start;

	$avg = $delta / $iterations;
	echo " " . sprintf("%0.3f ms", $avg * 1000.0) . "\n";
}

benchmark('xml', file_get_contents('rc.xml'), function($data) {
	$dom = new DOMDocument;
	$dom->loadXML($data);
	return $dom;
});

benchmark('json-objects', file_get_contents('rc.json'), function($data) {
	return json_decode($data);
});

benchmark('json-assoc', file_get_contents('rc.json'), function($data) {
	return json_decode($data, true);
});

benchmark('php', file_get_contents('rc.phpser'), function($data) {
	return unserialize($data);
});
