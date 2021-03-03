<?php

namespace Rudl\DnsBind;


use Rudl\LibGitDb\RudlGitDbClient;

class Bind9UpdateRunner
{
    public function __construct(
        private RudlGitDbClient $gitDb
    ){}

    public function __invoke()
    {
        $objList = $this->gitDb->syncObjects(DNS_SCOPE, BIND_ZONE_DIR);

        $config = "";
        foreach($objList->objects as $curZone) {
            if (preg_match("/^([a-z0-9-.]+)\.zone$/i", $curZone->name, $matches)) {
                $zoneName = $matches[1];
                $zoneFile = BIND_ZONE_DIR . "/{$curZone->name}";
                echo "Updating zone $zoneName...";
                phore_exec("named-checkzone ? ?", [$zoneName, $zoneFile]);
                $config .= 'zone "' . $zoneName .  '" {type master; file "' . $zoneFile . '";};' . "\n";
                echo "OK\n";

            }
        }

        phore_file(BIND_ZONE_CONFIG)->set_contents($config);
        try {
            phore_exec("service named reload");
        } catch (\Exception $e) {
            echo "Reloading failed. Trying to restart server...\n";
            phore_exec("service named restart");
        }
    }
}