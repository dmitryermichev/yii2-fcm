<?php


namespace dmerm\yii2fcm;


use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

class RegisterTokenAction extends Action
{
    /**
     * @var array contains 'token' and 'id' fields
     */
    public $params;
    /**
     * @var Device
     */
    public $modelClass;

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

        if ($this->modelClass === null) {
            throw new InvalidConfigException('modelClass must be set');
        }

        if (!is_subclass_of($this->modelClass, Device::class)) {
            throw new InvalidConfigException('modelClass must be subclass of ' . Device::class);
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
         * @var RegisterParams $regParamsModel
         */
        $regParamsModel = new $this->registerParamsModelClass();
        $regParamsModel->load($this->params);

        if (!$regParamsModel->validate()) {
            return $regParamsModel;
        }

        $model = $this->modelClass::findById($regParamsModel->getId());
        if (!$model) {
            throw new NotFoundHttpException('Device not found by id ' . $regParamsModel->getId());
        }
        $model->setFirebaseToken($regParamsModel->getToken());

        return $model;
    }
}
