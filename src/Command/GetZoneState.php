<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:55
 */

namespace Stroker\Tado\Command;

use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Type\SensorData;
use Stroker\Tado\Type\Zone;
use Stroker\Tado\Type\ZoneState;

class GetZoneState implements CommandInterface
{
    /**
     * @var Zone
     */
    private $zone;

    /**
     * GetZoneTemperature constructor.
     * @param Zone $zone
     */
    public function __construct(Zone $zone)
    {
        $this->zone = $zone;
    }

    /**
     * Send command
     *
     * @param ClientInterface $client
     * @return ZoneState
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest(sprintf('api/v2/homes/{home_id}/zones/%s/state', $this->zone->getId()));
        $zoneState = new ZoneState($response);

        foreach ($response['sensorDataPoints'] as $key => $sensorDataPoint) {
            $zoneState->addSensorData(
                $key,
                new SensorData($sensorDataPoint)
            );
        }

        return $zoneState;
    }
}