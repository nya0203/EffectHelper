<?php

declare(strict_types=1);

namespace nya0203\effect;

use nya0203\effect\buffer\EffectBuffer;
use nya0203\effect\content\EffectContent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class EffectHandler {
    public const REMOVE_TYRE_END = 0;
    public const REMOVE_TYPE_CANCEL = 1;

    protected bool $cancelled = false;
    protected bool $ended = false;

    protected int $runtime = 0;
    protected int $timelineIndex = 0;

    protected EffectContent $content;

    private int $effectId;

    /** @param Player[] $viewers */
    public function __construct(protected Effect $effect, protected Vector3 $center, protected array $viewers) {
        $this->effect->setHandler($this);
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
        return $this->content->getTimeline()[$this->timelineIndex];
    }

    public function getLength(): int {
        return $this->content->getContentLength();
    }

    public function getContent(): EffectContent {
        return $this->content;
    }

    public function play(EffectBuffer $buffer): void {
        if($this->runtime == $this->getNextPlay()) {
            $packets = [];
            if($this->content->isEmpty())
                $this->effect->onPlay($this->content);
            foreach($this->content->get($this->runtime) as $contentData)
                $packets = array_merge($packets, $contentData->particleEncode($this->getCenter()));
            $buffer->put($this->getViewers(), $packets);
            if($this->getLength() == $this->timelineIndex)
                $this->end();
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

    public function loadCache(EffectContent $cache): void {
        $this->content = $cache;
    }

    public function getEffectId(): int {
        return $this->effectId;
    }
}