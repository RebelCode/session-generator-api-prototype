<?php

namespace RebelCode\Sessions\Api;

use Dhii\Expression\ExpressionInterface;
use Dhii\Util\Invocation\InvocableInterface;
use Dhii\Util\String\StringableInterface;

/**
 * A session factory that creates sessions in the form of associative arrays that are also aware of a service ID.
 *
 * @since [*next-version*]
 */
class ServiceArraySessionFactory implements InvocableInterface
{
    /**
     * The key to use for start timestamp in created session arrays.
     *
     * @since [*next-version*]
     */
    const K_START = 'start';

    /**
     * The key to use for end timestamp in created session arrays.
     *
     * @since [*next-version*]
     */
    const K_END = 'end';

    /**
     * The key to use for service ID in created session arrays.
     *
     * @since [*next-version*]
     */
    const K_SERVICE_ID = 'serviceId';

    /**
     * The key to use for misc. data in created session arrays.
     *
     * @since [*next-version*]
     */
    const K_DATA = 'data';

    /**
     * The key to use for pricing data in created session arrays.
     *
     * @since [*next-version*]
     */
    const K_DATA_PRICE = 'price';

    /**
     * The service as an associative array of data.
     *
     * @since [*next-version*]
     *
     * @var array
     */
    protected $service;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param array $service The service data.
     */
    public function __construct($service)
    {
        $this->_setService($service);
    }

    /**
     * Retrieves the service.
     *
     * @since [*next-version*]
     *
     * @return array The service data as an associative array.
     */
    protected function _getService()
    {
        return $this->service;
    }

    /**
     * Sets the service.
     *
     * @since [*next-version*]
     *
     * @param array $service The service data.
     *
     * @return $this
     */
    protected function _setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function __invoke()
    {
        $start    = func_get_arg(0);
        $end      = func_get_arg(1);
        $duration = $end - $start;
        $service  = $this->_getService();
        $length   = $this->_getSessionLengthInfoForDuration($service, $duration);
        $price    = $length['price'];

        return [
            static::K_START      => $start,
            static::K_END        => $end,
            static::K_SERVICE_ID => $service['id'],
            static::K_DATA       => [
                static::K_DATA_PRICE => $price,
            ],
        ];
    }

    /**
     * Retrieves the session length information for a matching session duration.
     *
     * @since [*next-version*]
     *
     * @param array $service  The service info.
     * @param int   $duration The duration.
     *
     * @return array|null
     */
    protected function _getSessionLengthInfoForDuration($service, $duration)
    {
        $duration = intval($duration);

        foreach ($service['sessionLengths'] as $_length) {
            if (intval($_length['length']) === $duration) {
                return $_length;
            }
        }

        // Should never be null. The service's lengths are used by the generator, so theoretically the session's
        // duration will always match a session length.
        return null;
    }
}
