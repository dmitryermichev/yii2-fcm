<?php


namespace dmerm\yii2fcm;


interface TokenOwner
{

    public static function findById($id): TokenOwner;
    
    public static function findByFirebaseToken($token): TokenOwner;

    /**
     * @return string[]
     */
    public function getFirebaseTokens(): array;

    public function setFirebaseToken(string $token);

    public function deleteFirebaseToken(string $token);
}
