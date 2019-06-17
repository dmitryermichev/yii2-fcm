<?php


namespace dmerm\yii2fcm;


use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

class UnregisterTokenAction extends Action
{
    /**
     * @var array contains 'token' and 'id' fields
     */
    public $params;
    /**
     * @var TokenOwner
     */
    public $modelClass;

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

        $model = $this->modelClass::findById($unregParamsModel->getId());
        if (!$model) {
            throw new NotFoundHttpException('Device not found by id ' . $unregParamsModel->getId());
        }
        $model->deleteFirebaseToken($unregParamsModel->getToken());

        return $model;
    }
}
