<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:55
 */

namespace Stroker\Tado\Command;

use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Type\Zone;

class GetZones implements CommandInterface
{
    /**
     * Send command
     *
     * @param ClientInterface $client
     * @return Zone[]
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest('api/v2/homes/{home_id}/zones');
        $zones = [];
        foreach ($response as $zoneData) {
            $zones[] = new Zone($zoneData['id'], $zoneData, $client);
        }
        return $zones;
    }
}