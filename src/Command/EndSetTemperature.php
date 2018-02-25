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

class EndSetTemperature implements CommandInterface
{
    /**
     * @var Zone
     */
    private $zone;

    /**
     * SetTemperature constructor.
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
     * @return bool
     */
    public function send(ClientInterface $client)
    {
        $client->sendRequest(
            sprintf('api/v2/homes/{home_id}/zones/%s/overlay', $this->zone->getId()),
            ClientInterface::METHOD_DELETE
        );

        return true;
    }
}