<?php
require_once __DIR__ . '/../../../bootstrap.php';

$log = new Log('cron', Log::SUCCESS, 'Telstra cinema cron starts');
$log->save();

$telstra = new Telstra();
//$telstra->login('bluestreamjc', '0172122a');
$telstra->getCinemas();

echo "done\n";