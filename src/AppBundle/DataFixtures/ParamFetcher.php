<?php
namespace AppBundle\DataFixtures;

use FOS\RestBundle\Request\ParamFetcherInterface;

class ParamFetcher implements ParamFetcherInterface
{

    /**
     * @var array
     */
    protected $params = [];

    /**
     * Sets the controller.
     *
     * @param callable $controller
     */
    public function setController($controller)
    {
    }

    public function add($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * Gets a validated parameter.
     *
     * @param string $name Name of the parameter
     * @param bool $strict Whether a requirement mismatch should cause an exception
     *
     * @return mixed Value of the parameter.
     */
    public function get($name, $strict = null)
    {
        return $this->params[$name];
    }

    /**
     * Gets all validated parameter.
     *
     * @param bool $strict Whether a requirement mismatch should cause an exception
     *
     * @return array Values of all the parameters.
     */
    public function all($strict = false)
    {
        return $this->params;
    }
}
