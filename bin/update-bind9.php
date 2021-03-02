<?php

namespace App;
use Rudl\DnsBind\Bind9UpdateRunner;
use Rudl\LibGitDb\RudlGitDbClient;
use Rudl\LibGitDb\UpdateRunner;

require __DIR__ . "/../vendor/autoload.php";

$gitdb = new RudlGitDbClient();
try {
    $gitdb->loadClientConfigFromEnv();
} catch (\Exception $e) {
    echo "\n\nEMERGENCY! EMERGENCY! EMERGENCY! EMERGENCY! EMERGENCY! EMERGENCY !EMERGENCY! EMERGENCY! EMERGENCY! \n\n";
    echo "LoadSystemConfig failed: " . $e->getMessage() . "\n";
    echo "\nThis is a permananent configuration error! Please correct environment and redeploy!\n\n";
    echo "\nThis system will shutdown in 30sec\n";
    sleep(30);
    throw $e;
}

$runner = new UpdateRunner($gitdb);

$runner->run(new Bind9UpdateRunner($gitdb));
