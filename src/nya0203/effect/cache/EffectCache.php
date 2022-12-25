<?php

namespace nya0203\effect\cache;

use nya0203\math\Vector4;
use pocketmine\world\particle\Particle;

class EffectCache {
    private array $caches = [];

    public function add(Particle $particle, Vector4 $vector4): void {
        $index = $vector4->getTime();
        $cache = &$this->caches[$index];
        if(!is_array($cache))
            $cache = [];
        $cache[] = new EffectCacheData($particle, $vector4->toVector3());
    }

    public function isEmpty(): bool {
        return empty($this->caches);
    }

    /**
     * @return EffectCacheData[]
     */
    public function get(int $index): array {
        return $this->caches[$index];
    }

    public function remove(int $index): void {
        unset($this->caches[$index]);
    }

    /**
     * @return int[];
     */
    public function getTimeline(): array {
        $times = array_keys($this->caches);
        sort($times);
        return $times;
    }
}