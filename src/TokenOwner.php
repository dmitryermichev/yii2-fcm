<?php


namespace dmerm\yii2fcm;


interface TokenOwner
{
    /**
     * @param $token
     *
     * @return self|null
     */
    public static function findByFirebaseToken($token);

    /**
     * @param $id
     *
     * @return self|null
     */
    public static function findById($id);

    /**
     * @return string[]
     */
    public function getFirebaseTokens(): array;

    public function setFirebaseToken(string $token);

    public function deleteFirebaseToken(string $token);
}
