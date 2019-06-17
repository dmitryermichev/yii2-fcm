<?php


namespace dmerm\yii2fcm;


use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Topic;

class TopicMessage extends Message
{
    public function addTopic(Topic $topic)
    {
        $this->addRecipient($topic);
    }
}
