<?php

declare(strict_types=1);

namespace nya0203\task;

use nya0203\effect\buffer\EffectBufferReader;
use nya0203\effect\EffectPlayer;
use nya0203\EffectHelper;
use pocketmine\scheduler\Task;

class ParticlePacketSendTask extends Task {
    public function __construct(private EffectPlayer $player) {
    }

    public function onRun(): void {
        $this->player->playEffects();
        $buffer = $this->player->getBuffer();
        if($buffer->isEmpty())
            return;
        $reader = new EffectBufferReader($buffer);
        $queue = [];
        while(($readline = $reader->readline()) !== null) {
            foreach($readline->getViewers() as $viewer) {
                $viewerName = $viewer->getName();
                if(!isset($queue[$viewerName]))
                    $queue[$viewerName] = [];
                $queue[$viewerName] = array_merge($queue[$viewerName], $readline->getPackets());
            }
        }
        $plugin = EffectHelper::getInstance();
        foreach($queue as $name => $packets) {
            $player = $plugin->getServer()->getPlayerExact($name);
            if($player === null)
                continue;
            $recipient = $player->getNetworkSession();
            $recipient->getBroadcaster()->broadcastPackets([$recipient], $packets);
        }
    }
}