<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:55
 */

namespace Stroker\Tado\Command;

use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Type\Device;
use Stroker\Tado\Type\User;

class GetUsers implements CommandInterface
{
    /**
     * Send command
     *
     * @param ClientInterface $client
     * @return Device[]
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest('api/v2/homes/{home_id}/users');
        $users = [];
        foreach ($response as $userData) {
            $users[] = new User($userData['id'], $userData);
        }
    }
}