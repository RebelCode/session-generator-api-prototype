<?php

// DIC configuration

use Psr\Container\ContainerInterface;
use RebelCode\Sessions\Api\AvailabilityGenerator;
use RebelCode\Sessions\Api\HourlyPriceExpression;
use RebelCode\Sessions\Api\ServiceArraySessionFactory;
use RebelCode\Sessions\SessionGenerator;

$container = $app->getContainer();

//==== Factories =====
//  We need factories because the instances cannot be pre-created due to the service ID not being available
//  at the time of container population - it is available when the request for specific routes are processed.

// Session factory factory - creates session factories
$container['sessionFactoryFactory'] = function(ContainerInterface $c) {
    return function($service) {
        return new ServiceArraySessionFactory($service);
    };
};

// session generator factory - creates session generators
$container['sessionGeneratorFactory'] = function(ContainerInterface $c) {
    return function($service) use ($c) {
        $settings = $c->get('settings')['sessionGenerator'];
        $lengths  = array_column($service['sessionLengths'], 'length');
        $padding  = $settings['padding'];

        // Create the session factory using the service ID
        $sessionFactory = call_user_func_array(
            $c->get('sessionFactoryFactory'),
            [$service]
        );

        return new SessionGenerator(
            $sessionFactory,
            $lengths,
            $padding,
            null
        );
    };
};

// availability generator factory - creates availability generators
$container['availabilityGeneratorFactory'] = function(ContainerInterface $c) {
    return function($service) use ($c) {
        $settings = $c->get('settings')['availabilityGenerator'];
        $rules    = $settings['rules'];

        // Create session generator with the service ID.
        $sessionGenerator = call_user_func_array(
            $c->get('sessionGeneratorFactory'),
            [$service]
        );

        return new AvailabilityGenerator($sessionGenerator, $rules);
    };
};
