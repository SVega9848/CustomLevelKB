<?php

namespace SVega9848\CustomLevelKB\Core;

use SVega9848\CustomLevelKB\Commands\CustomKBCommand;
use pocketmine\event\Listener;
use pocketmine\event\server\CommandEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\CancelTaskException;
use pocketmine\scheduler\ClosureTask;
use SVega9848\CustomLevelKB\Listener\Events;

class Main extends PluginBase {

	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents(new Events($this), $this);
        $this->getServer()->getCommandMap()->register("customlevelkb", new CustomKBCommand($this));
	}
}
