<?php namespace professionalweb\IntegrationHub\Sendsay\Providers;

use Illuminate\Support\ServiceProvider;
use professionalweb\IntegrationHub\Sendsay\Services\SendDataSubsystem;
use professionalweb\IntegrationHub\Sendsay\Interfaces\SendDataSubsystem as ISendDataSubsystem;

class SendsayProvider extends ServiceProvider
{
    public function boot(): void
    {

    }

    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);

        $this->app->bind(ISendDataSubsystem::class,SendDataSubsystem::class);
    }
}