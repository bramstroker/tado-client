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
    const UNITTYPE_TEMPERATURE = 'temperature';
    const UNITTYPE_PERCENTAGE = 'percentage';

    const SENSORTYPE_INSIDETEMP = 'insideTemperature';
    const SENSORTYPE_HUMIDITY = 'humidity';
}