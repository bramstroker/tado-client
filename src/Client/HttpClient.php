<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:52
 */

namespace Stroker\Tado\Client;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Stroker\Tado\Command\EndSetTemperature;
use Stroker\Tado\Command\GetDevices;
use Stroker\Tado\Command\GetHomeById;
use Stroker\Tado\Command\GetMe;
use Stroker\Tado\Command\GetMobileDevices;
use Stroker\Tado\Command\GetWeather;
use Stroker\Tado\Command\GetZones;
use Stroker\Tado\Type\Device;
use Stroker\Tado\Type\Home;
use Stroker\Tado\Type\MobileDevice;
use Stroker\Tado\Type\Weather;
use Stroker\Tado\Type\Zone;

class HttpClient implements ClientInterface
{
    /**
     * @var string
     */
    protected $homeId = null;

    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * @var Credentials
     */
    protected $credentials;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var int
     */
    protected $tokenExpires;

    /**
     * HttpClient constructor.
     * @param Credentials $credentials
     * @param null $homeId
     */
    public function __construct(Credentials $credentials, $homeId = null)
    {
        $this->homeId = $homeId;
        $this->credentials = $credentials;
    }

    /**
     * @param string $path
     * @param string $method
     * @param array $data
     * @return mixed
     */
    public function sendRequest(string $path, string $method = ClientInterface::METHOD_GET, array $data = [])
    {
        $accessToken = $this->getOauthToken();

        if (preg_match('/{home_id}/', $path)) {
            $path = str_replace('{home_id}', $this->getHomeId(), $path);
        }

        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ];

        if ($method === ClientInterface::METHOD_PUT || $method === ClientInterface::METHOD_POST) {
            $options[RequestOptions::JSON] = $data;
        }

        $response = $this->getGuzzleClient()->request(
            $method,
            $path,
            $options
        );

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Invalid response: ' . $response->getBody());
        }

        $body = (string) $response->getBody();
        if (empty($body)) {
            return [];
        }
        return \GuzzleHttp\json_decode($body, true);
    }

    /**
     * @return string
     */
    public function getOauthToken(): string
    {
        $isTokenExpired = time() > $this->tokenExpires;
        if ($this->accessToken !== null && !$isTokenExpired) {
            return $this->accessToken;
        }

        // We haven't aquired a access token or the token has expired
        $response = $this->getGuzzleClient()->request(
            ClientInterface::METHOD_POST,
            'oauth/token',
            [
                'form_params' => array_merge(
                    $this->credentials->jsonSerialize(),
                    [
                        'grant_type' => 'password',
                        'scope' => 'home.user'
                    ]
                )
            ]
        );

        $json = \GuzzleHttp\json_decode($response->getBody(), true);
        $this->accessToken = $json['access_token'];
        $this->tokenExpires = time() + $json['expires_in'];
        return $this->accessToken;
    }

    /**
     * @return GuzzleClient
     */
    public function getGuzzleClient()
    {
        return new GuzzleClient(
            [
                'base_uri' => 'https://my.tado.com/'
            ]
        );
    }

    /**
     * @return null
     */
    public function getHomeId()
    {
        if ($this->homeId == null) {
            $me = (new GetMe())->send($this);
            $this->homeId = $me->getHomes()[0]->getId();
        }
        return $this->homeId;
    }

    /**
     * @param null $homeId
     */
    public function setHomeId($homeId)
    {
        $this->homeId = $homeId;
    }

    /**
     * @return Home
     */
    public function getHome()
    {
        return (new GetHomeById($this->homeId))->send($this);
    }

    /**
     * @return Zone[]
     */
    public function getZones()
    {
        return (new GetZones())->send($this);
    }

    /**
     * @return null|Zone
     */
    public function getHeatingZone()
    {
        $zones = $this->getZones();
        foreach ($zones as $zone) {
            if ($zone->getType() == Zone::ZONETYPE_HEATING) {
                return $zone;
            }
        }
        return null;
    }

    /**
     * @return Weather
     */
    public function getWeather()
    {
        return (new GetWeather())->send($this);
    }

    /**
     * @return Device[]
     */
    public function getDevices()
    {
        return (new GetDevices())->send($this);
    }

    /**
     * @return MobileDevice[]
     */
    public function getMobileDevices()
    {
        return (new GetMobileDevices())->send($this);
    }
}