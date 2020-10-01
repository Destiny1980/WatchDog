<?php

namespace GodWeedZao\AntiOpHack;
/*
 ###############################################################################
 #  ░██╗░░░░░░░██╗░█████╗░████████╗░█████╗░██╗░░██╗██████╗░░█████╗░░██████╗░   #
 #  ░██║░░██╗░░██║██╔══██╗╚══██╔══╝██╔══██╗██║░░██║██╔══██╗██╔══██╗██╔════╝░   #
 #  ░╚██╗████╗██╔╝███████║░░░██║░░░██║░░╚═╝███████║██║░░██║██║░░██║██║░░██╗░   #
 #  ░░████╔═████║░██╔══██║░░░██║░░░██║░░██╗██╔══██║██║░░██║██║░░██║██║░░╚██╗   #
 #  ░░╚██╔╝░╚██╔╝░██║░░██║░░░██║░░░╚█████╔╝██║░░██║██████╔╝╚█████╔╝╚██████╔╝   #
 #  ░░░╚═╝░░░╚═╝░░╚═╝░░╚═╝░░░╚═╝░░░░╚════╝░╚═╝░░╚═╝╚═════╝░░╚════╝░░╚═════╝░   #
 ###############################################################################
 */

use GodWeedZao\WatchDog;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as GW;

class Commands
{
    public function __construct(WatchDog $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param CommandSender $player
     * @param Command $cmd
     * @param string $label
     * @param array $args
     * @return bool
     */
    public function Cmd(CommandSender $player, Command $cmd, string $label, array $args): bool
    {
        if ($player->isOp()) {
            switch ($cmd->getName()) {
                case 'setop':
                    if (isset($args[0])) {
                        if (!in_array($args[0], $this->plugin->AntiOpHack->getAll())) {
                            $operators = $this->plugin->AntiOpHack->getAll();
                            $operators[] = $args[0];
                            $this->plugin->AntiOpHack->setAll($operators);
                            $player->sendMessage(GW::GREEN . 'Player ' . GW::AQUA . $args[0] . GW::GREEN . ' is op now!');
                            return true;
                        } else {
                            $player->sendMessage(GW::RED . 'Player ' . GW::AQUA . $args[0] . GW::RED . ' was op!');
                        }
                    } else {
                        $player->sendMessage(GW::RED . 'Player name must not be empty!');
                    }
                    return true;
                case 'removeop':
                    if (isset($args[0])) {
                        if (in_array($args[0], $this->plugin->AntiOpHack->getAll())) {
                            $index = array_search($args[0], $this->plugin->AntiOpHack->getAll());
                            $this->plugin->AntiOpHack->remove($index);
                            $player->sendMessage(GW::GREEN . 'Player ' . GW::AQUA . $args[0] . GW::GREEN . ' deoped!');
                        } else {
                            $player->sendMessage(GW::RED . 'Player ' . GW::AQUA . $args[0] . GW::RED . ' is not op!');
                        }
                    }
            }
        }
        return true;
    }
}