<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:50
 */

namespace Stroker\Tado\Type;

class User extends AbstractType
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $id;

    /**
     * @var Home[]
     */
    private $homes = [];

    /**
     * @var string
     */
    private $locale;

    /**
     * @var MobileDevice[]
     */
    private $mobileDevices = [];

    /**
     * Zone constructor.
     * @param string $name
     * @param string $email
     * @param string $username
     * @param string $id
     * @param string $locale
     * @param array $homes
     * @param array $mobileDevices
     */
    public function __construct(string $name, string $email, string $username, string $id, string $locale, array $homes = [], array $mobileDevices = [])
    {
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->id = $id;
        $this->locale = $locale;
        $this->homes = $homes;
        $this->mobileDevices = $mobileDevices;
        parent::__construct([]);
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