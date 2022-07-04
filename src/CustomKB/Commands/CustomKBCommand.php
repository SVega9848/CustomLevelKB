<?php

namespace CustomKB\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use CustomKB\Core\Main;

class CustomKBCommand extends Command {

    private $main;

    public function __construct(Main $main)
    {
        parent::__construct("ckb", "Modify your servers kb!");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender->hasPermission("ckb.cmd")) {
            if($sender instanceof Player) {

                $config = new Config($this->main->getDataFolder(). "/". $sender->getWorld()->getFolderName(). ".yml", Config::YAML);

                if(isset($args[0])) {
                    if(isset($args[1])) {
                        switch($args[0]) {
                            case "setkb":

                                $config->set("world", $sender->getWorld()->getFolderName());
                                $config->set("kb", $args[1]);
                                $config->save();
                                $sender->sendMessage(TextFormat::GREEN. "You succesfully changed the kb to ". TextFormat::DARK_GREEN. $args[1]. TextFormat::GREEN. " in the world ". TextFormat::DARK_GREEN. $sender->getWorld()->getFolderName());

                                break;
                            case "setdelay":

                                $config->set("world", $sender->getWorld()->getFolderName());
                                $config->set("delay", $args[1]);
                                $config->save();
                                $sender->sendMessage(TextFormat::GREEN. "You succesfully changed the delay hit to ". TextFormat::DARK_GREEN. $args[1]. TextFormat::GREEN. " in the world ". TextFormat::DARK_GREEN. $sender->getWorld()->getFolderName());

                                break;
                            default:
                                $sender->sendMessage(TextFormat::RED. "Missing arguments. Try /ckb (setkb/setdelay) (amount)");
                                break;
                    }
                } else {
                    $sender->sendMessage(TextFormat::RED. "Missing arguments. Use /ckb (setkb/setdelay) (amount)");
                }
            }} else {
                $sender->sendMessage(TextFormat::RED. "Missing arguments. Use /ckb (setkb/setdelay)");
            }
        } else {
            $sender->sendMessage(TextFormat::RED. "You do not have permissions to use this command");
        }
    }
}