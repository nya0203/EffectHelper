<?php

declare(strict_types=1);

namespace nya0203\content\effect;

use Generator;
use pocketmine\math\Vector3;

class EffectContentCache {
    private array $cache = [];

    private const DATA_PARTICLE = 0;
    private const DATA_VECTOR3 = 1;

    private const DATA_VECTOR3_X = 0;
    private const DATA_VECTOR3_Y = 1;
    private const DATA_VECTOR3_Z = 2;

    public function put(int $effectId, EffectContent $effectContent): void {
        $this->cache[$effectId] = $this->contentToArray($effectContent);
    }

    public function contains(int $effectId): bool {
        return array_key_exists($effectId, $this->cache);
    }

    public function get(int $effectId): ?EffectContent {
        if(!$this->contains($effectId))
            return null;
        return $this->arrayToContent($this->cache[$effectId]);
    }

    /** @return Generator<EffectContent> */
    public function getAll(): Generator {
        $cache = [];
        foreach(array_keys($this->cache) as $effectId)
            $cache[$effectId] = $this->get($effectId);
        yield $cache;
    }

    private function contentToArray(EffectContent $content): array {
        $result = [];
        foreach($content->getAll() as $time => $contentDataArray) {
            $result[$time] = [];
            foreach ($contentDataArray as $contentData) {
                $vector3 = $contentData->getVector();
                $result[$time][] = [
                    self::DATA_PARTICLE => $contentData->getParticle(),
                    self::DATA_VECTOR3 => [
                        self::DATA_VECTOR3_X => $vector3->getX(),
                        self::DATA_VECTOR3_Y => $vector3->getY(),
                        self::DATA_VECTOR3_Z => $vector3->getZ()
                    ]
                ];
            }
        }
        return $result;
    }

    private function arrayToContent(array $array): EffectContent {
        $result = new EffectContent();
        foreach($array as $time => $line) {
            $contentDataArray = [];
            foreach($line as $data) {
                $vectorData = $data[self::DATA_VECTOR3];
                $vector3 = new Vector3($vectorData[self::DATA_VECTOR3_X], $vectorData[self::DATA_VECTOR3_Y], $vectorData[self::DATA_VECTOR3_Z]);
                $particle = $data[self::DATA_PARTICLE];
                $contentDataArray[] = new EffectContentData($particle, $vector3);
            }
            $result->putContentDataArray($contentDataArray, $time);
        }
        return $result;
    }
}