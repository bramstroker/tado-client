<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:55
 */

namespace Stroker\Tado\Command;

use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Type\Capabilities;
use Stroker\Tado\Type\Weather;
use Stroker\Tado\Type\Zone;

class GetCapabilities implements CommandInterface
{
    /**
     * @var Zone
     */
    private $zone;

    /**
     * GetCapabilities constructor.
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
     * @return Capabilities
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest(sprintf('/api/v2/homes/{home_id}/zones/%s/capabilities', $this->zone->getId()));
        return new Capabilities($response);
    }
}