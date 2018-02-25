<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:52
 */

namespace Stroker\Tado\Client;


interface ClientInterface
{
    /**
     * Get method
     */
    const METHOD_GET = 'GET';

    /**
     * Post method
     */
    const METHOD_POST = 'POST';

    /**
     * Put method
     */
    const METHOD_PUT = 'PUT';

    /**
     * Delete method
     */
    const METHOD_DELETE = 'DELETE';

    /**
     * @param string $path
     * @param string $method
     * @param array $data
     * @return mixed
     */
    public function sendRequest(string $path, string $method = self::METHOD_GET, array $data = []);
}