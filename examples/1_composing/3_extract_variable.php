<?php

// TODO: present in browser
// php -S localhost:1234
// http://localhost:1234/3_extract_variable.php

require_once __DIR__ . '/../vendor/autoload.php';

// Wrong example:

if (collect(explode(' ', $_SERVER['HTTP_USER_AGENT']))->contains('Mac') &&
    (!collect(explode(' ', $_SERVER['HTTP_USER_AGENT']))->contains('IE')))
{
    echo 'You are using a Mac and not using IE';
}

echo '<br>'.PHP_EOL;

// Good example:
$os = collect(explode(' ', $_SERVER['HTTP_USER_AGENT']));
$isMac = $os->contains('Mac');
$isIE = $os->contains('IE');

if ($isMac && !$isIE)
{
    echo 'You are using a Mac and not using IE';
}