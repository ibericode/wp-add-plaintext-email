<?php

$time_start = microtime(true);
$failed_tests = [];

function assert_equals($actual, $expected): void
{
    global $failed_tests;

    if ($actual !== $expected) {
        echo 'F';

        $failed_tests[] = [$actual, $expected];
    }

    echo '.';
}

// mock some WordPress stuf
define('ABSPATH', '');
function add_action($a, $b) {};

// require the class we're about to test
require dirname(__DIR__) . '/add-plain-text-email.php';
$class = new Add_Plain_Text_Email;

echo "Testing\n";

assert_equals($class->strip_html_tags('') ,  '');

assert_equals($class->strip_html_tags('<head>var f;</head>') ,  '');
assert_equals($class->strip_html_tags('<style>.a { }</style>') ,  '');
assert_equals($class->strip_html_tags('<script>var f;</script>') ,  '');
assert_equals($class->strip_html_tags('<object>var f;</object>') ,  '');
assert_equals($class->strip_html_tags('<embed>var f;</embed>') ,  '');
assert_equals($class->strip_html_tags('<noscript>var f;</noscript>') ,  '');
assert_equals($class->strip_html_tags('<noembed>var f;</noembed>') ,  '');
assert_equals($class->strip_html_tags("\t") ,  '');
assert_equals($class->strip_html_tags("\t\t") ,  '');
assert_equals($class->strip_html_tags("\n\n") ,  '');
assert_equals($class->strip_html_tags("n") ,  'n');
assert_equals($class->strip_html_tags("t") ,  't');

assert_equals($class->strip_html_tags('<html><head><title>Email title</title></head><body>Hello, world</body></html>') ,  'Hello, world');

assert_equals($class->strip_html_tags('<html><head><title>Email title</title></head><body><h1>Hello, world</h1></body></html>') ,  'Hello, world');

assert_equals($class->strip_html_tags("<html>\n<head>\n\t<title>Email title</title>\n\t<style>h1 { font-size: 22px; }</style>\n</head>\n<body>\n\t<h1>Hello, world</h1>\n</body>\n</html>") ,  'Hello, world');

assert_equals($class->strip_html_tags("<html>\n<head>\n\t<title>Email title</title>\n\t<style>h1 { font-size: 22px; }</style>\n</head>\n<body>\n\t<h1>Hello, world</h1><p>Who this?</p>\n</body>\n</html>") ,  "Hello, world\n\nWho this?");

assert_equals($class->strip_html_tags("<html>\n<head>\n\t<title>Email title</title>\n\t<style>h1 { font-size: 22px; }</style>\n</head>\n<body>\n\t<h1>Hello, world</h1>\n\t<a href=\"https://dannyvankooten.com\">My website</a>\n</body>\n</html>") ,  "Hello, world\nMy website (https://dannyvankooten.com)");

echo "\n\n";

$time_elapsed = round((microtime(true) - $time_start) * 1000, 2);
$memory = round(memory_get_peak_usage() / 1024 / 1024, 2);
echo "Time: {$time_elapsed} ms\tMemory: {$memory} MB\n";

if (!empty($failed_tests)) {

    echo "\n\n";
    echo "There were ", count($failed_tests), " failures: \n\n";
    foreach ($failed_tests as $n => [$actual, $expected]) {
        echo "$n: Failed asserting that two values are equal.\n";
        echo "Expected: " . var_export($expected, true) . "\n";
        echo "Actual: " . var_export($actual, true) . "\n";
        echo "\n";
    }

    exit(1);
}

exit(0);
