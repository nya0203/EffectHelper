<?php

namespace nya0203\effect;

use nya0203\effect\buffer\EffectBuffer;
use nya0203\effect\EffectMotionData;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class EffectHandler {
    public const REMOVE_TYRE_END = 0;
    public const REMOVE_TYPE_CANCEL = 1;

    protected int $runtime = 0;
    protected bool $cancelled = false;
    protected bool $ended = false;

    /** @var int[] */
    protected array $timeline;
    protected int $timelineIndex = 0;

    private int $effectId;

    /** @param Player[] $viewers */
    public function __construct(protected Effect $effect, protected Vector3 $center, protected array $viewers) {
        $this->init();
    }

    private function init(): void {
        $this->effect->setHandler($this);
        $this->effect->update();
        $this->timeline = $this->effect->getCache()->getTimeline();
        $this->effectId = spl_object_id($this->effect);
    }

    /** @return Player[] */
    public function getViewers(): array {
        return $this->viewers;
    }

    public function getCenter(): Vector3 {
        return $this->center;
    }

    public function isCancelled(): bool {
        return $this->cancelled;
    }

    public function isEnded(): bool {
        return $this->ended;
    }

    public function getNextPlay(): int {
        return $this->timeline[$this->timelineIndex];
    }

    public function getEffectLength(): int {
        return max($this->timeline);
    }

    public function play(EffectBuffer $buffer): void {
        if($this->runtime == $this->getNextPlay()) {
            $packets = [];
            foreach($this->readCache($this->runtime) as $cacheData)
                $packets[] = $cacheData->getParticlePacket($this->getCenter());
            $buffer->put($this->getViewers(), $packets);
            if($this->getEffectLength() == $this->timelineIndex)
                $this->end();
            else $this->effect->onPlay();
            $this->timelineIndex++;
        }
        $this->runtime++;
    }

    public function end(): void {
        if(!$this->isEnded())
            $this->effect->onEnd();
        $this->remove(self::REMOVE_TYRE_END);
    }

    public function getEffect(): Effect {
        return $this->effect;
    }

    public function cancel(): void {
        if(!$this->isCancelled())
            $this->effect->onCancel();
        $this->remove(self::REMOVE_TYPE_CANCEL);
    }

    public function remove(int $type): void {
        switch($type) {
            case self::REMOVE_TYRE_END :
                $this->ended = true;
                break;
            case self::REMOVE_TYPE_CANCEL :
                $this->cancelled = true;
                break;
        }
        $this->effect->setHandler(null);
    }

    public function getEffectId(): int {
        return $this->effectId;
    }

    /** @return EffectMotionData[] */
    private function readCache(int $index): array {
        return $this->effect->getCache()->get($index);
    }
}