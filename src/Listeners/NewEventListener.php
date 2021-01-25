<?php namespace professionalweb\IntegrationHub\Sendsay\Listeners;

use professionalweb\IntegrationHub\Sendsay\Interfaces\SendDataSubsystem;
use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\EventData;
use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\Events\EventToProcess;

class NewEventListener
{
    /**
     * @param EventToProcess $eventToProcess
     *
     * @return EventData
     */
    public function handle(EventToProcess $eventToProcess): EventData
    {
        if ($eventToProcess->getProcessOptions()->getSubsystemId() === SendDataSubsystem::SEND_DATA_SUBSYSTEM_ID) {
            return app(SendDataSubsystem::class)->setProcessOptions($eventToProcess->getProcessOptions())->process($eventToProcess->getEventData());
        }

        return $eventToProcess->getEventData();
    }
}