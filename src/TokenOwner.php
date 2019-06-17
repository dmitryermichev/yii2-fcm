<?php


namespace dmerm\yii2fcm;


interface TokenOwner
{

    public static function findById($id): TokenOwner;

    public function getFirebaseToken(): string;

    public function setFirebaseToken(string $token);

    public function deleteFirebaseToken(string $token);
}
