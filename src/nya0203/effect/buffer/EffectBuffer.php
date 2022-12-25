<?php

namespace nya0203\effect\buffer;

use pocketmine\network\mcpe\protocol\ClientboundPacket;
use pocketmine\player\Player;

class EffectBuffer {
    private array $buffer = [];

    /**
     * @param Player[] $viewers
     * @param ClientboundPacket[] $packets
     */
    public function put(array $viewers, array $packets): void {
        $this->buffer[] = new EffectBufferData($viewers, $packets);
    }

    public function get(): array {
        return $this->buffer;
    }

    public function isEmpty(): bool {
        return empty($this->buffer);
    }
}