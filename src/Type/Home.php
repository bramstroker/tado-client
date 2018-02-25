<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:50
 */

namespace Stroker\Tado\Type;

use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Command\GetWeather;

class Home extends AbstractType
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Zone constructor.
     * @param int $id
     * @param string $name
     * @param array $attributes
     * @param ClientInterface $client
     */
    public function __construct(int $id, string $name, array $attributes, ClientInterface $client)
    {
        $this->id = $id;
        $this->name = $name;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Weather
     */
    public function getWeather()
    {
        return (new GetWeather())->send($this->client);
    }
}