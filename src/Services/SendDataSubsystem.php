<?php namespace professionalweb\IntegrationHub\Sendsay\Services;

use Illuminate\Support\Facades\Config;
use professionalweb\sendsay\interfaces\Sendsay;
use professionalweb\sendsay\models\Member\Member;
use professionalweb\sendsay\models\Member\AnketaAnswer;
use professionalweb\IntegrationHub\Sendsay\Models\SendDataOptions;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\EventData;
use professionalweb\IntegrationHub\IntegrationHubCommon\Traits\HasProcessOptions;
use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\Models\SubsystemOptions;
use professionalweb\IntegrationHub\Sendsay\Interfaces\SendDataSubsystem as ISendDataSubsystem;

/**
 * Subsystem to integrate with Sendsay
 * @package professionalweb\IntegrationHub\Sendsay\Services
 */
class SendDataSubsystem implements ISendDataSubsystem
{
    use HasProcessOptions;

    /** @var Sendsay */
    private $sendsayService;

    public function __construct(Sendsay $sendsay)
    {
        $this->setSendsayService($sendsay);
    }

    /**
     * Get available options
     *
     * @return SubsystemOptions
     */
    public function getAvailableOptions(): SubsystemOptions
    {
        return new SendDataOptions();
    }

    /**
     * Process event data
     *
     * @param EventData $eventData
     *
     * @return EventData
     */
    public function process(EventData $eventData): EventData
    {
        $options = $this->getProcessOptions()->getOptions();
        if (!isset($options['api-key']) || empty($options['api-key'])) {
            throw new BadRequestHttpException('Api key required');
        }

        Config::set('sendsay.api-key', $options['api-key']);

        $data = $eventData->getData();
        if (!isset($data['anketaId'], $data['email'], $data['fields'])) {
            throw new BadRequestHttpException('Email and anketaId required');
        }

        $member = new Member(['email' => $data['email']]);
        $anketaAnswers = new AnketaAnswer();
        $anketaAnswers->setAnketaId($data['anketaId']);
        $anketaAnswers->setAnswers($data['fields']);
        $member->addAnketaAnswers($anketaAnswers);
        $this->getSendsayService()->members()->save($member);

        return $eventData;
    }

    /**
     * @return Sendsay
     */
    public function getSendsayService(): Sendsay
    {
        return $this->sendsayService;
    }

    /**
     * @param Sendsay $sendsayService
     *
     * @return SendDataSubsystem
     */
    public function setSendsayService(Sendsay $sendsayService): SendDataSubsystem
    {
        $this->sendsayService = $sendsayService;

        return $this;
    }
}