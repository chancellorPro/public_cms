<?php

namespace App\Listeners;

use App\Events\ConfigDeployed;
use GuzzleHttp\Client;

/**
 * Send a notification to a config server about config changing
 */
class ConfigServerNotification
{

    /**
     * Handle the event.
     *
     * @param  ConfigDeployed $event
     * @return void
     */
    public function handle(ConfigDeployed $event)
    {
        $host = env('HTTP_SERVER_URL_' . strtoupper($event->getEnv()));

        if (!empty($host)) {
            $action = 'configsUpdated';
            $time   = time();

            $HTTPClient = new Client(['base_uri' => $host]);

            try {
                $response = $HTTPClient->request('HEAD', $action, [
                    'headers' => [
                        'X-SIG' => md5(env('HTTP_SERVER_SECRET') . $action . $time),
                    ],
                    'query'   => [
                        't' => $time,
                    ],
                ]);

                if ($response->getStatusCode() == 200) {
                    pushNotify('success', __('Config server was updated'));

                    return;
                }

                pushNotify('danger', __("Config server wasn't updated"));
            } catch (\Exception $e) {
                pushNotify('danger', __("Config server wasn't updated"));
            }

            return;
        }

        pushNotify('warning', __("Config server wasn't found in .ENV"));

        return;
    }
}
