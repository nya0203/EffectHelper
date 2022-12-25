<?php

namespace nya0203;

use nya0203\effect\Effect;
use nya0203\effect\EffectPlayer;
use nya0203\shape\ShapeShifter;
use nya0203\task\EffectPlayTask;
use pocketmine\plugin\PluginBase;

class EffectHelper extends PluginBase {
    private EffectPlayer $effectPlayer;
    private ShapeShifter $shapeShifter;

    public function onEnable(): void {
        $this->init();
    }

    public function init() {
        $this->shapeShifter = new ShapeShifter();
        $this->effectPlayer = new EffectPlayer();
        $this->getScheduler()->scheduleRepeatingTask(new EffectPlayTask($this->effectPlayer), 1);
    }

    public function getEffectPlayer(): EffectPlayer {
        return $this->effectPlayer;
    }

    public function getShapeShifter(): ShapeShifter {
        return $this->shapeShifter;
    }
}