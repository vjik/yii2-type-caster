<?php

namespace vjik\yii2\typeCaster\request;

use Yii;

trait RequestTrait
{

    /**
     * @param string $name
     * @return RequestTypeCaster
     */
    public function fromPost($name): RequestTypeCaster
    {
        return Yii::createObject(RequestTypeCaster::class, [$name, $this->post($name)]);
    }

    /**
     * @param $name
     * @return RequestTypeCaster
     */
    public function fromGet($name): RequestTypeCaster
    {
        return Yii::createObject(RequestTypeCaster::class, [$name, $this->get($name)]);
    }

    /**
     * Returns GET parameter with a given name. If name isn't specified, returns an array of all GET parameters.
     *
     * @param string $name the parameter name
     * @param mixed $defaultValue the default parameter value if the parameter does not exist.
     * @return array|mixed
     */
    abstract public function get($name = null, $defaultValue = null);

    /**
     * Returns POST parameter with a given name. If name isn't specified, returns an array of all POST parameters.
     *
     * @param string $name the parameter name
     * @param mixed $defaultValue the default parameter value if the parameter does not exist.
     * @return array|mixed
     */
    abstract public function post($name = null, $defaultValue = null);
}
