<?php
if (file_exists("cache/schools.cache") && filemtime("cache/schools.cache") >= strtotime("-1 day")) {
	// Cache is out of date, updating...
	print("<br />Cache is out of date, updating...");

} else {
	// Cache is current, nothing to do...
	print("<br />Cache is current, pushing cache to array...");
	$cache = unserialize(file_get_contents("cache/schools.cache"));	
}


?> 