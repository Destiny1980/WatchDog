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
use pocketmine\Player;

class Events
{

    private $plugin;

    public function __construct(WatchDog $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param Player $player
     */
    public function OpHackMove(Player $player)
    {
        if (WatchDog::$settings->get('check-op-move') == true) {
            if (($player->isOp()) && ($this->plugin->AntiOpHack->get($player->getName()) == false)) {
                if (WatchDog::$settings->get('kick-op-hack') == true) {
                    $player->kick(WatchDog::$settings->get('message-kick'));
                    $this->plugin->getServer()->broadcastMessage($this->plugin->message($player->getName(), 'kicked', 'OpHack'));
                    return;
                } elseif (WatchDog::$settings->get('ban-op-hack') == true) {
                    $player->setBanned(true);
                    $this->plugin->getServer()->broadcastMessage($this->plugin->message($player->getName(), 'Banned', 'OpHack'));
                    return;
                }
            }
        }
    }
}