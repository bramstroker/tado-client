<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:50
 */

namespace Stroker\Tado\Type;
use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Command\EndSetTemperature;
use Stroker\Tado\Command\GetCapabilities;
use Stroker\Tado\Command\GetZoneState;
use Stroker\Tado\Command\SetTemperature;

/**
 * @method string getName()
 * @method string getType()
 * @method string getReportsAvailable()
 * @method string getSupportsDazzle()
 * @method string getDazzleEnabled()
 */
class Zone extends AbstractType
{
    const ZONETYPE_HEATING = 'HEATING';

    /**
     * @var int
     */
    private $id;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Zone constructor.
     * @param int $id
     * @param array $attributes
     * @param ClientInterface $client
     */
    public function __construct(int $id, array $attributes, ClientInterface $client)
    {
        $this->id = $id;
        $this->client = $client;
        parent::__construct($attributes);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ZoneState
     */
    public function getState()
    {
        return (new GetZoneState($this))->send($this->client);
    }

    /**
     * @return Capabilities
     */
    public function getCapabilities()
    {
        return (new GetCapabilities($this))->send($this->client);
    }

    /**
     * @param float $temperature
     * @param string $terminationType
     * @return Overlay
     */
    public function setTemperature(float $temperature, $terminationType = Overlay::TERMINATION_MANUAL)
    {
        return (new SetTemperature($this, $temperature, $terminationType))->send($this->client);
    }

    /**
     * @return Overlay
     */
    public function endSetTemperature()
    {
        return (new EndSetTemperature($this))->send($this->client);
    }
}