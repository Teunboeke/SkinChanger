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
                                                                                                                        }
                          
                                                                               }
                                                                               public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
                                                                               {
                                                                                   if ($command->getName() !== "setskin") {
                                                                                                       return false;
                                                                                                   }
                                                                                       
                                                                                               if (!$sender instanceof Player) {
                                                                                                                  $sender->sendMessage("This command is only usable by players"); 
                                                                                                                   return false;
                                                                                                               }
                                                                                               if (empty($args)) {
                                                                                                                   $sender->sendMessage("/setskin <username>");
                                                                                                                   return false;
                                                                                                               }
                                                                                       
                                                                                               if (!file_exists($this->skinsDir)) {
                                                                                                   mkdir($this->skinsDir);
                                                                                                               }
                                                                                       
                                                                                               $username = $args[0];
                                                                                             $cachedSkin = null;
                                                                                                      
        
            if (!file_exists($this->skinsDir . "/" . $username . ".png")) {
                                try {                                       
  $uuid = $this->getUUID($username);                    
                                 if ($uuid) {                
                                                     $profile = $this->loadJSON(str_replace("<uuid>", $uuid, $this->skinURL));
                                                     if ($profile) {
                                                                          $properties = json_decode(base64_decode($profile->properties[0]->value));
                                                                                     $skinUrl = $properties->textures->SKIN->url;
                                                                                     $cachedSkin = file_get_contents($skinUrl);
                                            file_put_contents($this->skinsDir . "/" . $username . ".png", $cachedSkin);      
                                                                                 }
                                                         }
                                                    } catch (ErrorException $ex) {
                                                        $sender->sendMessage("Failed to load skin for $username");
                                                    }
                           }

                                   if (file_exists($this->skinsDir . "/" . $username . ".png")) {                                                          
