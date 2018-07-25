<?php

namespace Railken\LaraOre\Tests\EmailSender;

use Illuminate\Support\Facades\Config;
use Railken\LaraOre\EmailSender\EmailSenderFaker;
use Railken\LaraOre\Support\Testing\ApiTestableTrait;

class ApiTest extends BaseTest
{
    use ApiTestableTrait;

    /**
     * Retrieve basic url.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return Config::get('ore.api.router.prefix').Config::get('ore.email-sender.http.admin.router.prefix');
    }

    /**
     * Test common requests.
     */
    public function testSuccessCommon()
    {
        $this->commonTest($this->getBaseUrl(), EmailSenderFaker::make()->parameters());
    }
}