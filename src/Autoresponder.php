<?php declare(strict_types=1);

namespace DimasAhmad\AutoresponderSDK;

class Autoresponder
{
    private ?string $headerKey;
    private ?string $headerValue;

    private array $replies;

    public function __construct(string $headerKey = null, string $headerValue = null)
    {
        $this->headerKey = $headerKey;
        $this->headerValue = $headerValue;
    }

    public function checkAuthHeader(): bool
    {
        return $_SERVER[$this->headerKey] == $this->headerValue;
    }

    /**
     * Parse incoming message
     *
     * Read http request body by default. Pass an optional $json argument to parse from another source.
     *
     * @param string|null $json [optional]
     *
     * Pass an incoming message json string from another source
     *
     * @return IncomingMessage|null The function returns {@see IncomingMessage} object
     */
    public function parse(string $json = null): ?IncomingMessage
    {
        $json ??= file_get_contents('php://input');

        $message = json_decode($json);

        return new IncomingMessage($message->messengerPackageName, $message->query->sender, $message->query->message, $message->query->isGroup, $message->query->ruleId);
    }

    /**
     * @return array
     */
    public function getReplies(): array
    {
        return $this->replies;
    }

    /**
     * @param array $replies
     */
    public function setReplies(array $replies): void
    {
        $this->replies = $replies;
    }

    /**
     * @param string $message
     */
    public function addReply(string $message): void
    {
        $this->replies[] = $message;
    }

    /**
     * Send reply messages
     *
     * @param bool $return [optional]
     *
     * if set to <b>TRUE</b>, returns reply messages as a string instead of emitting to response body.
     *
     * @return string|null
     */
    public function send(bool $return = false): ?string
    {
        $reply = '{"replies":[';
        foreach ($this->replies as $message) {
            $reply .= '{"message":"' . $message . '"}';
        }
        $reply .= ']}';

        if ($return) {
            return $reply;
        }

        print $reply;
        return null;
    }
}