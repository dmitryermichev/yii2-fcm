<?php


namespace dmerm\yii2fcm;


use paragraph1\phpFCM\Message;

class DeviceMessage extends Message
{
    public function addDevice(TokenOwner $device)
    {
        $this->addRecipient(new \paragraph1\phpFCM\Recipient\Device($device->getFirebaseToken()));
    }
}
