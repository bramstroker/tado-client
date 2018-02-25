<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:50
 */

namespace Stroker\Tado\Type;

/**
 * @method string getName()
 * @method array getSettings()
 * @method array getLocation()
 * @method array getDeviceMetadata()
 */
class MobileDevice extends AbstractType
{
    /**
     * @var int
     */
    private $id;

    /**
     * MobileDevice constructor.
     * @param int $id
     * @param array $attributes
     */
    public function __construct(int $id, array $attributes)
    {
        $this->id = $id;
        parent::__construct($attributes);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}