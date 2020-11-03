<?php

declare(strict_types=1);

namespace Teunboeke\SkinChanger;

use ErrorException;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Skin;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class main extends PluginBase implements Listener
{

    private $uuidURL = "https://api.mojang.com/users/profiles/minecraft/<username>";
        private $skinURL = "https://sessionserver.mojang.com/session/minecraft/profile/<uuid>";
