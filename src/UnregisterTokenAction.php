<?php


namespace dmerm\yii2fcm;


use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\web\NotFoundHttpException;

class UnregisterTokenAction extends Action
{
    public $firebaseComponentName = 'firebase';
    /**
     * @var array contains 'token' and 'id' fields
     */
    public $params;

    /**
     * @var Firebase
     */
    protected $firebase;

    /**
     * @var string model class using for register action
     */
    public $unregisterParamsModelClass = BaseUnregisterParams::class;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->firebase = Instance::ensure($this->firebaseComponentName, Firebase::class);

        if ($this->modelClass === null) {
            throw new InvalidConfigException('modelClass must be set');
        }

        if (!is_subclass_of($this->modelClass, TokenOwner::class)) {
            throw new InvalidConfigException('modelClass must be subclass of ' . TokenOwner::class);
        }

        if ($this->params === null) {
            $this->params = \Yii::$app->request->getBodyParams();
        }
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function run()
    {
        /**
         * @var UnregisterParams $unregParamsModel
         */
        $unregParamsModel = new $this->unregisterParamsModelClass();
        $unregParamsModel->load($this->params);

        if (!$unregParamsModel->validate()) {
            return $unregParamsModel;
        }

        return $this->firebase->unregisterToken($unregParamsModel->getId(), $unregParamsModel->getToken());
    }
}
