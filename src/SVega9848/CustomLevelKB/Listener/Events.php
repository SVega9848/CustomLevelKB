<?php

namespace SVega9848\CustomLevelKB\Listener;

use JsonException;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use SVega9848\CustomLevelKB\Core\Main;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class Events implements Listener {

    private $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onAttack(EntityDamageEvent $e) {
        $entity = $e->getEntity();
        if($e instanceof EntityDamageByEntityEvent) {
            $d = $e->getDamager();
            if($d instanceof Player & $entity instanceof Player) {

                $config = new Config($this->main->getDataFolder() . "/" . $d->getWorld()->getFolderName() . ".yml");

                if(!$config->get("world") or !$config->get("kb") or !$config->get("delay")) {
                    $config->set("world", $entity->getWorld()->getFolderName());
                    $config->set("kb", $e->getKnockBack());
                    $config->set("delay", $e->getAttackCooldown());
                    $config->save();
                } else {
                    $e->setKnockBack($config->get("kb"));
                    $e->setAttackCooldown($config->get("delay"));
                }
            }
        }
    }

}