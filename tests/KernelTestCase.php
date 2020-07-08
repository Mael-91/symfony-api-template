<?php

namespace App\Tests;

use Liip\TestFixturesBundle\Test\FixturesTrait;

abstract class KernelTestCase extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{

    use FixturesTrait;
}