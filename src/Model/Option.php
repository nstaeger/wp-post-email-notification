<?php

namespace Nstaeger\WpPostEmailNotification\Model;

use Nstaeger\CmsPluginFramework\Broker\OptionBroker;
use Nstaeger\CmsPluginFramework\Support\ArgCheck;

class Option
{
    const EMAIL_BODY = "emailBody";
    const EMAIL_SUBJECT = "emailSubject";
    const JOB_BATCH_TIME_WAIT = 'jobBatchTimeWait';
    const JOB_INITIAL_TIME_WAIT = 'jobInitialTimeWait';
    const NUMBER_OF_EMAILS_SEND_PER_BATCH = 'numberOfEmailsSendPerRequest';

    const DEFAULT_JOB_BATCH_TIME_WAIT = 10;
    const DEFAULT_JOB_INITIAL_TIME_WAIT = 60;
    const DEFAULT_NUMBER_OF_EMAILS_SEND_PER_BATCH = 5;

    /**
     * @var OptionBroker
     */
    private $optionBroker;

    public function __construct(OptionBroker $optionBroker)
    {
        $this->optionBroker = $optionBroker;
    }

    public function createDefaults()
    {
        $this->setEmailBody("Hi,\n\n@@post.author.name just published a new post named @@post.title. You can view the full article here:\n\n@@post.link");
        $this->setEmailSubject("New Post on @@blog.name");
        $this->setNumberOfEmailsSendPerBatch(self::DEFAULT_NUMBER_OF_EMAILS_SEND_PER_BATCH);
        $this->setJobInitialTimeWait(self::DEFAULT_JOB_INITIAL_TIME_WAIT);
        $this->setJobBatchTimeWait(self::DEFAULT_JOB_BATCH_TIME_WAIT);
    }

    public function deleteAll()
    {
        $this->optionBroker->delete(self::EMAIL_BODY);
        $this->optionBroker->delete(self::EMAIL_SUBJECT);
        $this->optionBroker->delete(self::NUMBER_OF_EMAILS_SEND_PER_BATCH);
        $this->optionBroker->delete(self::JOB_INITIAL_TIME_WAIT);
        $this->optionBroker->delete(self::JOB_BATCH_TIME_WAIT);
    }

    public function getAll()
    {
        return [
            'emailBody' => $this->getEmailBody(),
            'emailSubject' => $this->getEmailSubject(),
            'jobBatchTimeWait' => $this->getJobBatchTimeWait(),
            'jobInitialTimeWait' => $this->getJobInitialTimeWait(),
            'numberOfMailsSendPerBatch' => $this->getNumberOfEmailsSendPerRequest()
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

    public function getJobBatchTimeWait()
    {
        return $this->optionBroker->get(self::JOB_BATCH_TIME_WAIT, self::DEFAULT_JOB_BATCH_TIME_WAIT);
    }

    public function getJobInitialTimeWait()
    {
        return $this->optionBroker->get(self::JOB_INITIAL_TIME_WAIT, self::DEFAULT_JOB_INITIAL_TIME_WAIT);
    }

    public function getNumberOfEmailsSendPerRequest()
    {
        return $this->optionBroker->get(self::NUMBER_OF_EMAILS_SEND_PER_BATCH,
                                        self::DEFAULT_NUMBER_OF_EMAILS_SEND_PER_BATCH);
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

        if (isset($values['numberOfMailsSendPerBatch'])) {
            $this->setNumberOfEmailsSendPerBatch($values['numberOfMailsSendPerBatch']);
        }

        if (isset($values['jobInitialTimeWait'])) {
            $this->setJobInitialTimeWait($values['jobInitialTimeWait']);
        }

        if (isset($values['jobBatchTimeWait'])) {
            $this->setJobBatchTimeWait($values['jobBatchTimeWait']);
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

    public function setJobBatchTimeWait($value)
    {
        ArgCheck::isInt($value);

        $this->optionBroker->store(self::JOB_BATCH_TIME_WAIT, $value);
    }

    public function setJobInitialTimeWait($value)
    {
        ArgCheck::isInt($value);

        $this->optionBroker->store(self::JOB_INITIAL_TIME_WAIT, $value);
    }

    public function setNumberOfEmailsSendPerBatch($value)
    {
        ArgCheck::isInt($value);

        $this->optionBroker->store(self::NUMBER_OF_EMAILS_SEND_PER_BATCH, $value);
    }
}
