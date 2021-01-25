<?php namespace professionalweb\IntegrationHub\Sendsay\Models;

use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\Models\SubsystemOptions;

/**
 * Subsystem options
 * @package professionalweb\IntegrationHub\Sendsay\Models
 */
class SendDataOptions implements SubsystemOptions
{


    /**
     * Get available fields for mapping
     *
     * @return array
     */
    public function getAvailableFields(): array
    {
        return [
            'email'    => 'E-mail',
            'anketaId' => 'Anketa id',
            'fields'   => 'Fields',
        ];
    }

    /**
     * Get service settings
     *
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'apikey' => [
                'name' => 'API key',
                'type' => 'string',
            ],
        ];
    }

    /**
     * Get array fields, that subsystem generates
     *
     * @return array
     */
    public function getAvailableOutFields(): array
    {
        return [];
    }
}