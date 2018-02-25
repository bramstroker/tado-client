<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:55
 */

namespace Stroker\Tado\Command;

use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Type\Home;
use Stroker\Tado\Type\MobileDevice;
use Stroker\Tado\Type\User;

class GetHomeById implements CommandInterface
{
    /**
     * @var int
     */
    private $homeId;

    /**
     * GetHomeById constructor.
     * @param int $homeId
     */
    public function __construct(int $homeId)
    {
        $this->homeId = $homeId;
    }

    /**
     * Send command
     *
     * @param ClientInterface $client
     * @return Home
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest('api/v2/homes/' . $this->homeId);
        return new Home(
            $this->homeId,
            $response['name'],
            $client
        );
    }
}