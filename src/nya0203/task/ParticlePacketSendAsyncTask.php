<?php

namespace nya0203\task;

use nya0203\effect\buffer\EffectBuffer;
use nya0203\effect\buffer\EffectBufferReader;
use pocketmine\player\Player;
use pocketmine\scheduler\AsyncTask;

class ParticlePacketSendAsyncTask extends AsyncTask {
    private array $queue = [];
    private array $players = [];

    public function __construct(private EffectBuffer $buffer) {
    }

    public function onRun(): void {
        $reader = new EffectBufferReader($this->buffer);
        while(($readline = $reader->readline()) !== null) {
            foreach($readline->getViewers() as $viewer) {
                $viewerName = $viewer->getName();
                $queue = &$this->queue[$viewerName];
                if(!is_array($queue)) {
                    $queue = [];
                    $this->players[$viewerName] = $viewer;
                }
                $queue = array_merge($queue, $readline->getPackets());
            }
        }
    }

    private function getPlayerByName(string $name): Player {
        return $this->players[$name];
    }

    public function onCompletion(): void {
        foreach($this->queue as $name => $packets) {
            $recipient = $this->getPlayerByName($name)->getNetworkSession();
            $recipient->getBroadcaster()->broadcastPackets([$recipient], $packets);
        }
    }
}