<?php

declare(strict_types=1);

namespace Wildan\payall;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\player\Player;
use onebone\economyapi\EconomyAPI;

class PayAll extends PluginBase {

    public function onEnable(): void {
        $this->getLogger()->info("PayAll plugin has been enabled.");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "payall") {
            if (count($args) !== 1 || !is_numeric($args[0]) || $args[0] <= 0) {
                $sender->sendMessage(TextFormat::RED . "Usage: /payall <amount>");
                return true;
            }

            $amount = (int) $args[0];
            $onlinePlayers = $this->getServer()->getOnlinePlayers();

            foreach ($onlinePlayers as $player) {
                EconomyAPI::getInstance()->addMoney($player, $amount);
            }

            $sender->sendMessage(TextFormat::GREEN . "You have successfully paid $" . $amount . " to all online players.");
            return true;
        }

        return false;
    }
    
    public function executeConsoleCommand(string $command): void {
        $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
    }
}
