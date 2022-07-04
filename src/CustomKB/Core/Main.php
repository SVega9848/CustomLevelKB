<?php

namespace CustomKB\Core;

use CustomKB\Commands\CustomKBCommand;
use pocketmine\event\Listener;
use pocketmine\event\server\CommandEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\CancelTaskException;
use pocketmine\scheduler\ClosureTask;
use CustomKB\Listener\Events;

class Main extends PluginBase {

	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents(new Events($this), $this);
        $this->getServer()->getCommandMap()->register("ckb", new CustomKBCommand($this));
	}

    

}
