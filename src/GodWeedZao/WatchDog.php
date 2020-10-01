<?php

declare(strict_types=1);

namespace GodWeedZao;
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

use GodWeedZao\AntiOpHack\Commands;
use GodWeedZao\AntiOpHack\Events;
use GodWeedZao\AntiOpHack\OpChecker;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class WatchDog extends PluginBase implements Listener
{

    public static $settings;
    public static $opHack;

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        $this->saveResource('Settings.yml');
        if (!is_dir($this->getDataFolder() . 'AntiOpHack')) {
            mkdir($this->getDataFolder() . 'AntiOpHack');
        }
        $this->AntiOpHack = new Config($this->getDataFolder() . "AntiOpHack/OpList.yml", Config::YAML);
        self::$settings = new Config($this->getDataFolder() . 'Settings.yml', Config::YAML);
        self::$opHack = new Events ($this);
        if (self::$settings->get('check-op-task') == true) {
            if (self::$settings->get('check-op-move') == true) {
                self::$settings->set('check-op-move', false);
            }
            $this->getScheduler()->scheduleRepeatingTask(new OpChecker($this), 20);
        }
    }

    /**
     * @param PlayerMoveEvent $event
     */
    public function onMove(PlayerMoveEvent $event)
    {
        $player = $event->getPlayer();
        self::$opHack->OpHackMove($player);
    }

    /**
     * @param CommandSender $player
     * @param Command $cmd
     * @param string $label
     * @param array $args
     * @return bool
     */
    public function onCommand(CommandSender $player, Command $cmd, string $label, array $args): bool
    {
        $AntiOpHack = new Commands ($this);
        $AntiOpHack->Cmd($player, $cmd, $label, $args);
        return true;
    }

    /**
     * @param $name
     * @param $punishment
     * @param $cheat
     * @return string|string[]
     */
    public function message($name, $punishment, $cheat)
    {
        $message = self::$settings->get('message');
        $message = str_replace('{hacker_name}', $name, $message);
        $message = str_replace('{cheat_name}', $cheat, $message);
        $message = str_replace('{punishment}', $punishment, $message);
        return $message;
    }

    public function onDisable()
    {
        $this->AntiOpHack->save();
    }
}
