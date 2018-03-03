<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:50
 */

namespace Stroker\Tado\Type;

/**
 * @method string getName()
 * @method string getLocale()
 */
class User extends AbstractType
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var Home[]
     */
    private $homes = [];

    /**
     * @var MobileDevice[]
     */
    private $mobileDevices = [];

    /**
     * Zone constructor.
     * @param string $id
     * @param array $attributes
     * @param array $homes
     * @param array $mobileDevices
     */
    public function __construct(string $id, array $attributes, array $homes = [], array $mobileDevices = [])
    {
        $this->id = $id;
        $this->homes = $homes;
        $this->mobileDevices = $mobileDevices;
        parent::__construct($attributes);
    }

    /**
     * @return Home[]
     */
    public function getHomes(): array
    {
        return $this->homes;
    }

    /**
     * @return MobileDevice[]
     */
    public function getMobileDevices(): array
    {
        return $this->mobileDevices;
    }
}