<?php

declare(strict_types=1);

namespace nya0203\effect\content;

use nya0203\motion\Motion;
use nya0203\shape\Shape;
use pocketmine\world\particle\Particle;

class EffectContent {
    private array $content = [];

    public function put(Particle $particle, Shape $shape, Motion $motion, int $delay = 0): void {
        $vector4Objs = $motion->get($shape);
        if($delay > 0) {
            $vector4Objs = array_map(function ($vector4) use ($delay) {
                return $vector4->addTime($delay);
                }, $vector4Objs);
        }
        foreach($vector4Objs as $vector4) {
            $content = &$this->content[$vector4->getTime()];
            if(!is_array($content))
                $content = [];
            $content[] = new EffectContentData($particle, $vector4->toVector3());
        }
    }

    public function putContentData(EffectContentData $contentData, int $time): void {
        $content = &$this->content[$time];
        if(!is_array($content))
            $content = [];
        $content[] = $contentData;
    }

    /** @param EffectContentData[] $contentDataArray */
    public function putContentDataArray(array $contentDataArray, int $time): void {
        if(!isset($this->content[$time]))
            $this->content[$time] = [];
        $content = &$this->content[$time];
        $content = array_merge($content, $contentDataArray);
    }

    /** @return EffectContentData[] */
    public function get(int $index): array {
        return $this->content[$index] ?? [];
    }

    public function getAll(): array {
        return $this->content;
    }

    /** @return int[] */
    public function getTimeline(): array {
        $timeline = array_keys($this->content);
        sort($timeline);
        return $timeline;
    }

    public function getContentLength(): int {
        return max(array_keys($this->content));
    }

    public function isEmpty(): bool {
        return empty($this->content);
    }
}