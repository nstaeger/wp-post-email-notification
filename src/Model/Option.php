<?php

namespace Nstaeger\WpPostEmailNotification\Model;

use Nstaeger\CmsPluginFramework\Broker\OptionBroker;
use Nstaeger\CmsPluginFramework\Support\ArgCheck;

class Option
{
    const EMAIL_BODY = "emailBody";
    const EMAIL_SUBJECT = "emailSubject";
    const NUMBER_OF_EMAILS_SEND_PER_REQUEST = 'numberOfEmailsSendPerRequest';

    /**
     * @var OptionBroker
     */
    private $optionBroker;

    public function __construct(OptionBroker $optionBroker)
    {
        $this->optionBroker = $optionBroker;
    }

    public function getAll()
    {
        return [
            'emailBody'                   => $this->getEmailBody(),
            'emailSubject'                => $this->getEmailSubject(),
            'numberOfMailsSendPerRequest' => $this->getNumberOfEmailsSendPerRequest()
        ];
    }

    public function getEmailBody()
    {
        return $this->optionBroker->get(self::EMAIL_BODY);
    }

    public function getEmailSubject()
    {
        return $this->optionBroker->get(self::EMAIL_SUBJECT);
    }

    public function getNumberOfEmailsSendPerRequest()
    {
        return $this->optionBroker->get(self::NUMBER_OF_EMAILS_SEND_PER_REQUEST);
    }

    public function setAll($values)
    {
        ArgCheck::isArray($values);

        if (isset($values['emailBody'])) {
            $this->setEmailBody($values['emailBody']);
        }

        if (isset($values['emailSubject'])) {
            $this->setEmailSubject($values['emailSubject']);
        }

        if (isset($values['numberOfMailsSendPerRequest'])) {
            $this->setNumberOfEmailsSendPerRequest($values['numberOfMailsSendPerRequest']);
        }
    }

    public function setEmailBody($value)
    {
        ArgCheck::notNull($value);

        return $this->optionBroker->store(self::EMAIL_BODY, $value);
    }

    public function setEmailSubject($value)
    {
        ArgCheck::notNull($value);

        return $this->optionBroker->store(self::EMAIL_SUBJECT, $value);
    }

    public function setNumberOfEmailsSendPerRequest($value)
    {
        ArgCheck::isInt($value);

        $this->optionBroker->store(self::NUMBER_OF_EMAILS_SEND_PER_REQUEST, $value);
    }
}
