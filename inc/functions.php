<?php

function dumpData($filename, $data) {
	file_put_contents($filename, '<?php return ' . preg_replace(
			['/\s*array \(/', '/\)/s', '/\[\s*\]/s', '/  /'],
			[' [', ']', '[]', "\t"],
			var_export($data, true)
		) . ";\n\n");
}
