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
        private $playerData = null;
        private $skinsDir = "";
        private $playerDataPath = "";
    
        public function onEnable()
        {
                $this->playerDataPath = $this->getDataFolder() . "players.json";
                $this->skinsDir = $this->getDataFolder() . "cache";
            
                    if (file_exists($this->playerDataPath)) {
                         $this->playerData = json_decode(file_get_contents($this->playerDataPath));
                                } else {
                                    $this->playerData = (object)array();
                                }
            
                    $this->getServer()->getPluginManager()->registerEvents($this, $this      
                }
                                                                           
               public function onDisable()
                          {     
                                       file_put_contents($this->playerDataPath, json_encode($this->playerData));
                                      }
                                                                                                                                                   
    public function onJoin(PlayerJoinEvent $event)
                                                         {
         $player = $event->getPlayer();
                                     $id = $player->getUniqueId()->toString();
      if (isset($this->playerData->{$id})) {
                          $skinName = $this->playerData->{$id};
                          $player->setSkin($this->createSkin($skinName));
                          $player->sendSkin();
                      }
                                                                     }
                                                                           
                                                                               public function onQuit(PlayerQuitEvent $event)
                                                                               {                 
                                                                                       $id = $event->getPlayer()->getUniqueId()->toString();                                                                                      
                                                                                              if (isset($this->playerData->{$id})) {
                                                                                                file_put_contents($this->playerDataPath, json_encode($this->playerData));
                                                                                                                 file_put_contents($this->playerDataPath, json_encode($this->playerData)); 
