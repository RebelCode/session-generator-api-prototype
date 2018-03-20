<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// For pinging purposes
$app->get(
    '/',
    function(Request $request, Response $response, $args) {
        return $response->withStatus(200, 'OK');
    }
);

$app->get(
    '/service',
    function(Request $request, Response $response, $args) {
        $response = $response->withAddedHeader('Content-type', 'application/json');
        $settings = $this->get('settings');
        $services = $settings['services'];

        $response->getBody()->write(json_encode($services));

        return $response;
    }
);

$app->get(
    '/service/{serviceId}',
    function(Request $request, Response $response, $args) {
        $response = $response->withAddedHeader('Content-type', 'application/json');

        $settings  = $this->get('settings');
        $services  = $settings['services'];
        $serviceId = $args['serviceId'];

        $service = isset($services[$serviceId])
            ? $services[$serviceId]
            : null;

        if ($service === null) {
            $response->getBody()->write(
                json_encode(['error' => sprintf('Service with ID %s was not found.', $serviceId)])
            );

            return $response->withStatus(404, 'Service not found');
        }

        $response->getBody()->write(json_encode($service));

        return $response;
    }
);

$app->get(
    '/service/{serviceId}/sessions',
    function(Request $request, Response $response, $args) {
        $response = $response->withAddedHeader('Content-type', 'application/json');

        $settings  = $this->get('settings');
        $services  = $settings['services'];
        $serviceId = $args['serviceId'];

        $service = isset($services[$serviceId])
            ? $services[$serviceId]
            : null;

        if ($service === null) {
            $response->getBody()->write(
                json_encode(['error' => sprintf('Service with ID %s was not found.', $serviceId)])
            );

            return $response->withStatus(404, 'Service not found');
        }

        $params = $request->getQueryParams();

        if (!isset($params['start'], $params['end'])) {
            $response->getBody()->write(
                json_encode(['error' => 'Start and/or end timestamps not provided.'])
            );

            return $response->withStatus(400, 'Service not found');
        }

        $start = $params['start'];
        $end   = $params['end'];

        // Get Availability Generator factory
        // And create an instance with the service ID in the request
        $factory  = $this->get('availabilityGeneratorFactory');
        $instance = call_user_func_array($factory, [$service]);

        $sessions = $instance->generate($start, $end);
        $json     = json_encode($sessions);

        $response->getBody()->write($json);

        return $response->withAddedHeader('Content-type', 'application/json');
    }
);
