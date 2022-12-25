<?php

declare(strict_types=1);

namespace nya0203;

use nya0203\effect\EffectPlayer;
use nya0203\task\ParticlePacketSendTask;
use pocketmine\plugin\PluginBase;

class EffectHelper extends PluginBase {
    private EffectPlayer $effectPlayer;
    private static ?EffectHelper $instance = null;

    public function onEnable(): void {
        self::$instance = $this;

        $this->effectPlayer = new EffectPlayer();
        $this->getScheduler()->scheduleRepeatingTask(new ParticlePacketSendTask($this->effectPlayer), 1);
    }

    public function getEffectPlayer(): EffectPlayer {
        return $this->effectPlayer;
    }

    public static function getInstance(): ?EffectHelper {
        return self::$instance;
    }
}