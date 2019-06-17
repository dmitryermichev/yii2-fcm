<?php


namespace dmerm\yii2fcm;


use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Device;

class DeviceMessage extends Message
{
    public function addTokenOwner(TokenOwner $device)
    {
        foreach ($device->getFirebaseTokens() as $token) {
            $this->addRecipient(new Device($token));
        }
    }
}
