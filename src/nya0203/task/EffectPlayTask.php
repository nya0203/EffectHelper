<?php

namespace nya0203\task;

use nya0203\effect\EffectPlayer;
use pocketmine\scheduler\TasK;

class EffectPlayTask extends Task {
    public function __construct(private EffectPlayer $player) {
    }

    public function onRun(): void {
        $this->player->playEffects();
        $buffer = $this->player->getBuffer();
        if($buffer->isEmpty())
            return;
        $packetSender = new ParticlePacketSendAsyncTask($buffer);
        $packetSender->run();
    }
}