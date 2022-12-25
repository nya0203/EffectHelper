<?php

declare(strict_types=1);

namespace nya0203\effect\buffer;

use pocketmine\network\mcpe\protocol\ClientboundPacket;
use pocketmine\player\Player;

class EffectBufferData {
    /**
     * @param Player[] $viewers
     * @param ClientboundPacket[] $packets
     */
    public function __construct(private array $viewers, private array $packets) {
    }

    /** @return Player[] */
    public function getViewers(): array {
        return $this->viewers;
    }

    /** @return ClientboundPacket[] */
    public function getPackets(): array {
        return $this->packets;
    }
}