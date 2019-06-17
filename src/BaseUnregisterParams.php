<?php


namespace dmerm\yii2fcm;


class BaseUnregisterParams extends UnregisterParams
{
    public $id;
    public $token;

    public function rules()
    {
        return [
            [['id', 'token'], 'required'],
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getToken()
    {
        return $this->token;
    }
}
