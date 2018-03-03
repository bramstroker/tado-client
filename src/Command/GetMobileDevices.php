<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:55
 */

namespace Stroker\Tado\Command;

use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Type\MobileDevice;

class GetMobileDevices implements CommandInterface
{
    /**
     * Send command
     *
     * @param ClientInterface $client
     * @return MobileDevice[]
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest('api/v2/homes/{home_id}/mobileDevices');
        $devices = [];
        foreach ($response as $deviceData) {
            $devices[] = new MobileDevice($deviceData['id'], $deviceData);
        }
        return $devices;
    }
}