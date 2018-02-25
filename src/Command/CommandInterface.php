<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:51
 */

namespace Stroker\Tado\Command;

use Stroker\Tado\Client\ClientInterface;

interface CommandInterface
{

    /**
     * Send command
     *
     * @param ClientInterface $client
     * @return mixed
     */
    public function send(ClientInterface $client);
}