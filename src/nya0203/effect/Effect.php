<?php

namespace nya0203\effect;


use nya0203\effect\EffectCache;
use nya0203\motion\Motion;
use nya0203\shape\Shape;
use pocketmine\world\particle\Particle;

abstract class Effect {
    private ?EffectHandler $effectHandler = null;
    private EffectCache $cache;

    final public function getHandler(): ?EffectHandler {
        return $this->effectHandler;
    }

    final public function setHandler(?EffectHandler $effectHandler): void {
        if($this->effectHandler === null || $effectHandler === null) {
            $this->effectHandler = $effectHandler;
        }
    }

    final public function getCache(): EffectCache {
        return $this->cache ?? new EffectCache();
    }

    final public function update(): void {
        $this->cache = new EffectCache();
        $this->content();
    }

    protected abstract function content(): void;

    protected function addEffectMotion(Particle $particle, Shape $shape, Motion $motion): void {
        $vector4Points = $motion->get($shape);
        foreach($vector4Points as $point)
            $this->cache->add($particle, $point);
    }

    protected function addDelayedEffectMotion(Particle $particle, Shape $shape, Motion $motion, int $delay): void {
        $vector4Points = $motion->get($shape);
        $vector4Points_map = array_map(function ($point) use ($delay) {
            return $point->addTime($delay);
        }, $vector4Points);
        foreach($vector4Points_map as $point)
            $this->cache->add($particle, $point);
    }

    public function onPlay(): void {

    }

    public function onCancel(): void {

    }

    public function onEnd(): void {

    }
}