<?php

namespace dmerm\yii2fcm;

use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Firebase extends Component
{
    /**
     * @var Firebase API key
     */
    public $apiKey;

    /**
     * @var \GuzzleHttp\Client
     */
    public $httpClient;

    /**
     * @var Client
     */
    public $fireBaseClient;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!$this->fireBaseClient) {
            $this->fireBaseClient = new Client();
        }

        if (!$this->apiKey) {
            throw new InvalidConfigException('Firebase: apiKey must be set');
        }
        $this->fireBaseClient->setApiKey($this->apiKey);

        if (!$this->httpClient) {
            $this->httpClient = new \GuzzleHttp\Client();
        }
        $this->fireBaseClient->injectHttpClient($this->httpClient);
    }

    /**
     * @param Message $message
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(Message $message)
    {
        return $this->fireBaseClient->send($message);
    }
}
