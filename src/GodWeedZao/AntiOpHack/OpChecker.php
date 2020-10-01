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
use pocketmine\scheduler\Task;

class OpChecker extends Task
{
    public function __construct(WatchDog $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * @param $currentTick
     */
    public function onRun($currentTick)
    {
        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
            if (($player->isOp()) && (!in_array($player->getName(), $this->plugin->AntiOpHack->getAll()))) {
                if (WatchDog::$settings->get('kick-op-hack') == true) {
                    $player->kick(WatchDog::$settings->get('message-kick'));
                    $this->plugin->getServer()->broadcastMessage($this->plugin->message($player->getName(), 'kicked', 'OpHack'));
                    return;
                } elseif (WatchDog::$settings->get('ban-op-hack') == true) {
                    $player->setBanned(true);
                    $this->plugin->getServer()->broadcastMessage($this->plugin->message($player->getName(), 'banned', 'OpHack'));
                    return;
                }
            }
        }
    }
}