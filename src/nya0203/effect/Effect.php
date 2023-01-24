<?php

declare(strict_types=1);

namespace nya0203\effect;

use nya0203\content\effect\EffectContent;
use nya0203\content\effect\EffectContentData;

abstract class Effect {
    private ?EffectHandler $effectHandler = null;

    final public function getHandler(): ?EffectHandler {
        return $this->effectHandler;
    }

    final public function setHandler(?EffectHandler $effectHandler): void {
        if($this->effectHandler === null || $effectHandler === null) {
            $this->effectHandler = $effectHandler;
        }
    }

    public abstract function write(EffectContent $content): void;

    /** @var EffectContentData[] $playContentData */
    public function onPlay(array $playContentData): void {
    }

    public function onCancel(): void {
    }

    public function onEnd(): void {
    }
}