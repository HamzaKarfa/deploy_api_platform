<?php

declare(strict_types=1);

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\OpenApi;
use ApiPlatform\Core\OpenApi\Model;

final class StripeDecorator implements OpenApiFactoryInterface
{
    public function __construct(
        private OpenApiFactoryInterface $decorated
    ) {}

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['Stripe'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'Stripe' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ]);
        $schemas['Credentials'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'price' => [
                    'type' => 'string',
                    'example' => 'amount',
                ],
            ],
        ]);

        $pathItem = new Model\PathItem(
            ref: 'Stripe',
            post: new Model\Operation(
                operationId: 'postCredentialsItemStripe',
                tags: ['Stripe'],
                responses: [
                    '200' => [
                        'description' => 'Return confirm payment',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Stripe',
                                ],
                            ],
                        ],
                    ],
                ],
                summary: 'Create a new payment',
                requestBody: new Model\RequestBody(
                    description: 'Create a new PaymentIntent with stripe',
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials',
                            ],
                        ],
                    ]),
                ),
            ),
        );
        $openApi->getPaths()->addPath('/payment_intent', $pathItem);

        return $openApi;
    }
}