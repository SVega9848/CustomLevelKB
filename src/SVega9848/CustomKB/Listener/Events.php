<?php

namespace SVega9848\CustomKB\Listener;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use SVega9848\CustomKB\Core\Main;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class Events implements Listener {

    private $main;

    public function __construct(Main $main) {
        $this->main = $main;
    }

    public function onTeleport(EntityTeleportEvent $e) {
        $entity = $e->getEntity();
        if($entity instanceof Player) {

            $prevworld = $e->getFrom()->getWorld()->getFolderName();
            $postworld = $e->getTo()->getWorld()->getFolderName();
            $config = new Config($this->main->getDataFolder() . "/" . $postworld . ".yml");
            if(!$config->get("world") == $prevworld) {
                $config->set("kb", $config->get("kb"));
                $config->save();
            }

        }
    }

    public function onAttack(EntityDamageEvent $e) {
        $entity = $e->getEntity();
        if($e instanceof EntityDamageByEntityEvent) {
            $d = $e->getDamager();
            if($d instanceof Player & $entity instanceof Player) {

                $config = new Config($this->main->getDataFolder() . "/" . $d->getWorld()->getFolderName() . ".yml");
                if (!$config->get("kb")) {
                    $config->set("world", $d->getWorld()->getFolderName());
                    $config->set("kb", 0.4);
                    $config->set("delay", 10);
                    $config->save();
                }
                if ($config->get("world") == $entity->getWorld()->getFolderName()) {
                $e->setKnockBack($config->get("kb"));
                $e->setAttackCooldown($config->get("delay"));
                }
            }
        }
    }

}