<?php

namespace App\Tests;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

abstract class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{

    use FixturesTrait;

    /**
     * @var KernelBrowser
     */
    protected $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
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
        $this->client->request(
            'POST',
            $route,
            [],
            [],
            ['CONTENT-TYPE' => 'application/json'],
            json_encode([
                'username' => $username,
                'password' => $password
            ])
        );

        if ($this->client->getResponse()->getStatusCode() === Response::HTTP_NOT_FOUND) {
            throw new \LogicException(sprintf('The route %s does not exist please configure the path of your route in the %s in the %s method', $route, __CLASS__, __METHOD__));
        } else if ($this->client->getResponse()->getStatusCode() === Response::HTTP_METHOD_NOT_ALLOWED) {
            throw new \LogicException(sprintf('The route %s is not accessible in %s method', $route, $this->client->getRequest()->getMethod()));
        }

        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $data['token']));
    }
}