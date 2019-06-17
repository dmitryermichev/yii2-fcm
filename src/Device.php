<?php


namespace dmerm\yii2fcm;


interface Device
{
    public static function findByFirebaseToken($token): Device;

    public static function findById($id): Device;

    public function getFirebaseToken(): string;

    public function setFirebaseToken(string $token);

    public function deleteFirebaseToken(string $token);
}
