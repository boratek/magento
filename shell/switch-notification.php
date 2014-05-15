<?php

/**
 * Enable/Disable hints
 */

if (!isset($argv[1])) {
    die("[HELP] Arguments: on/off\n\n");
}

switch ($argv[1]) {
    case 'on':
        $switch = 1;
        break;
    case 'off';
        $switch = 0;
        break;
}

if (!isset($switch)) {
    die("Bad argument (on/off)\n\n");
}

include(dirname(__DIR__) . '/app/Mage.php');
$app = Mage::app();

foreach ($app->getWebsites() as $website) {
    $app->getConfig()->saveConfig('dev/debug/template_hints', $switch, 'websites', $website->getId());
    $app->getConfig()->saveConfig('dev/debug/template_hints_blocks', $switch, 'websites', $website->getId());
    printf("Hints are: %s for %s\n", ($switch ? 'Enabled' : 'Disabled'), $website->getName());
}

$app->cleanCache(array(
    'CONFIG',
    'BLOCK_HTML'
));

exit();

