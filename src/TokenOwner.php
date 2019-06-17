<?php


namespace dmerm\yii2fcm;


interface TokenOwner
{

    public static function findById($id): TokenOwner;

    /**
     * @return string[]
     */
    public function getFirebaseTokens(): array;

    public function setFirebaseToken(string $token);

    public function deleteFirebaseToken(string $token);
}
