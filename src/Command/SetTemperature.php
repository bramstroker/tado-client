<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 16:14
 */

namespace Stroker\Tado\Command;


use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Type\Overlay;
use Stroker\Tado\Type\Zone;

class SetTemperature implements CommandInterface
{
    /**
     * @var float
     */
    private $temperature;
    /**
     * @var string
     */
    private $terminationType;
    /**
     * @var Zone
     */
    private $zone;

    /**
     * SetTemperature constructor.
     * @param Zone $zone
     * @param float $temperature
     * @param string $terminationType
     */
    public function __construct(Zone $zone, float $temperature, $terminationType = Overlay::TERMINATION_MANUAL)
    {
        $this->temperature = $temperature;
        $this->terminationType = $terminationType;
        $this->zone = $zone;
    }

    /**
     * Send command
     *
     * @param ClientInterface $client
     * @return Overlay
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest(
            sprintf('api/v2/homes/{home_id}/zones/%s/overlay', $this->zone->getId()),
            ClientInterface::METHOD_PUT,
            [
                "setting" => [
                    "type" => "HEATING",
                    "power" => "ON",
                    "temperature" => [
                        "celsius" => $this->temperature
                    ],
                ],
                "termination" => [
                    "type" => $this->terminationType
                ]
            ]
        );

        return new Overlay($response);
    }
}