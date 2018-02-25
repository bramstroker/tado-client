<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:55
 */

namespace Stroker\Tado\Command;

use Stroker\Tado\Client\ClientInterface;
use Stroker\Tado\Type\Weather;

class GetWeather implements CommandInterface
{
    /**
     * Send command
     *
     * @param ClientInterface $client
     * @return Weather
     */
    public function send(ClientInterface $client)
    {
        $response = $client->sendRequest('api/v2/homes/{home_id}/weather');
        return new Weather($response);
    }
}