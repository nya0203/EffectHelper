<?php

declare(strict_types=1);

namespace nya0203\content\effect;

use nya0203\content\motion\MotionContent;
use pocketmine\world\particle\Particle;

class EffectContent {
    private array $content = [];

    public function put(Particle $particle, MotionContent $motionContent, int $delay = 0): void {
        $delay = max(0, $delay);
        foreach($motionContent->get() as $contentData) {
            $time = $contentData->getTime() + $delay;
            if(!isset($this->content[$time]))
                $this->content[$time] = [];
            foreach($contentData->getShapeContent()->get() as $vector3)
                $this->content[$time][] = new EffectContentData($particle, $contentData->getOffCenter()->addVector($vector3));
        }
    }

    public function putContentData(EffectContentData $contentData, int $time): void {
        if(!isset($this->content[$time]))
            $this->content[$time] = [];
        $this->content[$time][] = $contentData;
    }

    /** @param EffectContentData[] $contentDataArray */
    public function putContentDataArray(array $contentDataArray, int $time): void {
        if(!isset($this->content[$time]))
            $this->content[$time] = [];
        $this->content[$time] = array_merge($this->content[$time], $contentDataArray);
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