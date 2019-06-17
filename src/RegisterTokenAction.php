<?php


namespace dmerm\yii2fcm;


use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\web\NotFoundHttpException;

class RegisterTokenAction extends Action
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
    public $registerParamsModelClass = BaseRegisterParams::class;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->firebase = Instance::ensure($this->firebaseComponentName, Firebase::class);

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
         * @var RegisterParams $regParamsModel
         */
        $regParamsModel = new $this->registerParamsModelClass();
        $regParamsModel->load($this->params);

        if (!$regParamsModel->validate()) {
            return $regParamsModel;
        }

        return $this->firebase->registerToken($regParamsModel->getId(), $regParamsModel->getToken());
    }
}
