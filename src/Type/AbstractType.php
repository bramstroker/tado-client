<?php
/**
 * Created by PhpStorm.
 * User: Bram
 * Date: 25-2-2018
 * Time: 13:50
 */

namespace Stroker\Tado\Type;

class AbstractType
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * AbstractType constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __call(string $name, $arguments)
    {
        if (substr($name, 0, 3) == 'get') {
            $attribute = lcfirst(substr($name, 3));
            return $this->getAttribute($attribute);
        }
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getAttribute(string $name)
    {
        if (!isset($this->attributes[$name])) {
            return null;
        }

        return $this->attributes[$name];
    }
}