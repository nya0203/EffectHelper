<?php

declare(strict_types=1);

namespace nya0203;

use nya0203\content\effect\EffectContent;
use nya0203\effect\Effect;
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

    public static function extractEffect(Effect $effect, string $effectName): void {
        $effectContent = new EffectContent();
        $effect->write($effectContent);
        $times = array_keys($effectContent->getAll());
        $data = array_fill_keys($times, []);
        foreach($times as $time) {
            foreach($effectContent->get($time) as $contentData) {
                $data[$time][] = [
                    "pos"=> ['x'=> $contentData->getVector()->getX(), 'y'=> $contentData->getVector()->getY(), 'z'=> $contentData->getVector()->getZ()],
                    "particle"=> $contentData->getParticle()->jsonSerialize()
                ];
            }
        }
        $dir = self::getInstance()->getDataFolder(). "extract_effects";
        @mkdir($dir);
        $fileStream = fopen($dir."\\". $effectName.".json", "w");
        fwrite($fileStream, json_encode($data));
        fclose($fileStream);
    }
}