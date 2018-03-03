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
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;
use Stroker\Tado\Command\GetDevices;
use Stroker\Tado\Command\GetHomeById;
use Stroker\Tado\Command\GetMe;
use Stroker\Tado\Command\GetMobileDevices;
use Stroker\Tado\Command\GetWeather;
use Stroker\Tado\Command\GetZones;
use Stroker\Tado\Exception\ExceptionInterface;
use Stroker\Tado\Exception\InvalidResponseException;
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
     * @var AccessToken
     */
    protected $accessToken;

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
     * @throws ExceptionInterface
     */
    public function sendRequest(string $path, string $method = ClientInterface::METHOD_GET, array $data = []): array
    {
        $accessToken = $this->getAccessToken();

        if (preg_match('/{home_id}/', $path)) {
            $path = str_replace('{home_id}', $this->getHomeId(), $path);
        }

        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken->getToken(),
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
            throw new InvalidResponseException('Invalid response: ' . $response->getBody());
        }

        $body = (string) $response->getBody();
        if (empty($body)) {
            return [];
        }
        return \GuzzleHttp\json_decode($body, true);
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken(): AccessToken
    {
        if ($this->accessToken !== null) {

            if ($this->accessToken->hasExpired()) {
                $this->accessToken = $this->getOAuthProvider()->getAccessToken('refresh_token', [
                    'refresh_token' => $this->accessToken->getRefreshToken()
                ]);
            }

            return $this->accessToken;
        }

        $this->accessToken = $this->getOAuthProvider()->getAccessToken('password', [
            'username' => $this->credentials->getUsername(),
            'password' => $this->credentials->getPassword(),
            'scope' => 'home.user',
        ]);

        return $this->accessToken;
    }

    /**
     * @return AbstractProvider
     */
    public function getOAuthProvider(): AbstractProvider
    {
        return new GenericProvider([
            'clientId'                => $this->credentials->getClientId(),
            'clientSecret'            => $this->credentials->getClientSecret(),
            'urlAuthorize'            => 'https://my.tado.com/oauth/token',
            'urlAccessToken'          => 'https://my.tado.com/oauth/token',
            'urlResourceOwnerDetails' => null,
        ]);
    }

    /**
     * @return GuzzleClient
     */
    public function getGuzzleClient(): GuzzleClient
    {
        return new GuzzleClient(
            [
                'base_uri' => 'https://my.tado.com/'
            ]
        );
    }

    /**
     * @return int
     */
    public function getHomeId(): int
    {
        if ($this->homeId == null) {
            $me = (new GetMe())->send($this);
            $this->homeId = $me->getHomes()[0]->getId();
        }
        return $this->homeId;
    }

    /**
     * @param int $homeId
     */
    public function setHomeId(int $homeId)
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
    public function getZones(): array
    {
        return (new GetZones())->send($this);
    }

    /**
     * @return null|Zone
     */
    public function getHeatingZone(): ?Zone
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
    public function getDevices(): array
    {
        return (new GetDevices())->send($this);
    }

    /**
     * @return MobileDevice[]
     */
    public function getMobileDevices(): array
    {
        return (new GetMobileDevices())->send($this);
    }
}