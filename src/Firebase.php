<?php

namespace dmerm\yii2fcm;

use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message;
use yii\base\Component;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

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
     * @var string|TokenOwner classname of token owner
     */
    public $tokenOwnerClass;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!$this->apiKey) {
            throw new InvalidConfigException('Firebase: apiKey must be set');
        }

        if (!$this->tokenOwnerClass) {
            throw new InvalidConfigException('Firebase: token owner class must be set');
        }

        if (!$this->fireBaseClient) {
            $this->fireBaseClient = new Client();
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

    /**
     * @param $ownerId
     * @param $token
     *
     * @return TokenOwner
     * @throws NotFoundHttpException
     */
    public function registerToken($ownerId, $token)
    {
        $oldModelsLimit = 5;
        for($i = 0; $i < $oldModelsLimit; $i++) {
            $oldModel = $this->tokenOwnerClass::findByFirebaseToken($token);
            if ($oldModel === null) {
                break;
            }
            $oldModel->deleteFirebaseToken($token);
        }

        $model = $this->tokenOwnerClass::findById($ownerId);
        if (!$model) {
            throw new NotFoundHttpException($this->tokenOwnerClass . ' not found by id ' . $ownerId);
        }
        $model->setFirebaseToken($token);

        return $model;
    }

    /**
     * @param $ownerId
     * @param $token
     *
     * @return TokenOwner
     * @throws NotFoundHttpException
     */
    public function unregisterToken($ownerId, $token)
    {
        $model = $this->tokenOwnerClass::findById($ownerId);
        if (!$model) {
            throw new NotFoundHttpException($this->tokenOwnerClass . ' not found by id ' . $ownerId);
        }
        $model->deleteFirebaseToken($token);

        return $model;
    }
}
