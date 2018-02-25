<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 15:11
 */

namespace Stroker\Tado\Type;

/*
 * @method string getTadoMode()
 * @method bool getGeolocationOverride()
 * @method bool getGeolocationOverrideDisableTime()
 */
class ZoneState extends AbstractType
{
    /**
     * @var SensorData[]
     */
    protected $sensorData;

    /**
     * @param string $key
     * @param SensorData $sensorData
     */
    public function addSensorData(string $key, SensorData $sensorData)
    {
        $this->sensorData[$key] = $sensorData;
    }

    /**
     * @return SensorData[]
     */
    public function getSensorData()
    {
        return $this->sensorData;
    }

    /**
     * @param string $unit
     * @return float
     */
    public function getInsideTemperature($unit = 'celsius'): float
    {
        return $this->sensorData['insideTemperature']->getAttribute($unit);
    }

    /**
     * @return float
     */
    public function getHumidity(): float
    {
        return $this->sensorData['humidity']->getAttribute('percentage');
    }
}