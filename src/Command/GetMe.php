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

class GetMe implements CommandInterface
{
    /**
     * Send command
     *
     * @param ClientInterface $client
     *            Phue Client
     *
     * @return User
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest('api/v2/me');

        $homes = [];
        foreach ($response['homes'] as $homeData) {
            $homes[] = new Home(
                $homeData['id'],
                $homeData['name'],
                $homeData,
                $client
            );
        }

        $mobileDevices = [];
        foreach ($response['mobileDevices'] as $deviceData) {
            $mobileDevices[] = new MobileDevice($deviceData['id'], $deviceData);
        }

        return new User(
            $response['name'],
            $response['email'],
            $response['username'],
            $response['id'],
            $response['locale'],
            $homes,
            $mobileDevices
        );
    }
}