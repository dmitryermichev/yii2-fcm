<?php


namespace dmerm\yii2fcm;


use yii\base\Model;

abstract class RegisterParams extends Model
{
    public abstract function getId();

    public abstract function getToken();
}
