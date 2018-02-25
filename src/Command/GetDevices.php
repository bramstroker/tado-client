<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:55
 */

namespace Stroker\Tado\Command;

use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Type\Device;
use Stroker\Tado\Type\Zone;

class GetDevices implements CommandInterface
{
    /**
     * Send command
     *
     * @param ClientInterface $client
     * @return Device[]
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest('api/v2/homes/{home_id}/devices');
        $devices = [];
        foreach ($response as $deviceData) {
            $devices[] = new Device($deviceData);
        }
        return $devices;
    }
}