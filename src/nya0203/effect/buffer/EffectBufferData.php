<?php

namespace nya0203\effect\buffer;

use pocketmine\network\mcpe\protocol\ClientboundPacket;
use pocketmine\player\Player;

class EffectBufferData {
    private array $data;

    private const DATA_VIEWERS = 0;
    private const DATA_PACKETS = 1;

    /**
     * @param Player[] $viewers
     * @param ClientboundPacket[] $packets
     */
    public function __construct(array $viewers, array $packets) {
        $this->data = [self::DATA_VIEWERS => $viewers, self::DATA_PACKETS => $packets];
    }

    /** @return Player[] */
    public function getViewers(): array {
        return $this->data[self::DATA_VIEWERS];
    }

    /** @return ClientboundPacket[] */
    public function getPackets(): array {
        return $this->data[self::DATA_PACKETS];
    }
}