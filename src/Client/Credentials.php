<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 14:13
 */

namespace Stroker\Tado\Client;


class Credentials implements \JsonSerializable
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $client_id;

    /**
     * @var string
     */
    private $client_secret;

    /**
     * Credentials constructor.
     * @param string $username
     * @param string $password
     * @param string $client_id
     * @param string $client_secret
     */
    public function __construct(string $username, string $password, string $client_id, string $client_secret)
    {
        $this->username = $username;
        $this->password = $password;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->client_id;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->client_secret;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];
    }
}