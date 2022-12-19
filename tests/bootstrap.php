<?php declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

function loadResult(string $name, string $save = ''): string
{
	$file = __DIR__ . "/fixtures/$name.csv";
	if ($save !== '') {
		file_put_contents($file, $save);
	}

	$content = file_get_contents($file);
	assert($content !== false);

	return $content;
}


Tester\Environment::setup();
