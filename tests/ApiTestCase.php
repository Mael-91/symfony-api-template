<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiTestCase extends \ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase
{

    use FixturesTrait;

    const DEFAULT_OPTIONS = [
        'auth_basic' => null,
        'auth_bearer' => null,
        'query' => [],
        'headers' => [
            'content-type' => ['application/json', 'application/ld+json', 'application/merge+patch+json'],
            'accept' => ['application/json', 'application/ld+json', 'application/merge+patch+json'],
        ],
        'body' => '',
        'json' => null,
        'base_uri' => 'http://localhost'
    ];
    /**
     * @var Client
     */
    protected $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->setDefaultOptions(self::DEFAULT_OPTIONS);
        parent::setUp();
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $route
     * To make it easier to define arguments with the right values
     * Ex : public function login(string $username = 'test', string $password = 'test', string $route = '/api/login')
     */
    public function login(string $username, string $password, string $route): void
    {
        $this->client->request('POST', $route, ['json' => [
            'username' => $username,
            'password' => $password
        ]]);

        if ($this->client->getResponse()->getStatusCode() === Response::HTTP_NOT_FOUND) {
            throw new \LogicException(sprintf('The route %s does not exist please configure the path of your route in the %s in the %s method', $route, __CLASS__, __METHOD__));
        } else if ($this->client->getResponse()->getStatusCode() === Response::HTTP_METHOD_NOT_ALLOWED) {
            throw new \LogicException(sprintf('The route %s is not accessible in POST method', $route));
        }

        $data = json_decode($this->client->getResponse()->getContent(), true);
        $options = self::DEFAULT_OPTIONS;
        $options['headers'] = ['Authorization' => 'Bearer ' . $data['token']];
        $this->client->setDefaultOptions($options);
    }

}