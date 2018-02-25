<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:50
 */

namespace Stroker\Tado\Type;

/**
 * @method string getTimestamp()
 */
class SensorData extends AbstractType
{
    const SENSORTYPE_TEMPERATURE = 'temperature';
    const SENSORTYPE_PERCENTAGE = 'percentage';
}