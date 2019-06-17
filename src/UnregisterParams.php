<?php


namespace dmerm\yii2fcm;


use yii\base\Model;

/**
 * Class UnregisterParams
 *
 * @package dmerm\yii2fcm
 */
abstract class UnregisterParams extends Model
{
    public abstract function getId();

    public abstract function getToken();
}
