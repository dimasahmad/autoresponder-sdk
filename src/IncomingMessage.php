<?php declare(strict_types=1);

namespace DimasAhmad\AutoresponderSDK;

class IncomingMessage {
    public string $application;
    public string $sender;
    public string $message;
    public bool $isGroup;
    public int $ruleId;

    /**
     * Incoming message object
     * @param string $application
     * @param string $sender
     * @param string $message
     * @param bool $isGroup
     * @param int $ruleId
     */
    public function __construct(string $application, string $sender, string $message, bool $isGroup, int $ruleId)
    {
        $this->application = $application;
        $this->sender = $sender;
        $this->message = $message;
        $this->isGroup = $isGroup;
        $this->ruleId = $ruleId;
    }
}