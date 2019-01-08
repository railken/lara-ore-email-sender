<?php

namespace Railken\Amethyst\Tests\Http\Admin;

use Railken\Amethyst\Api\Support\Testing\TestableBaseTrait;
use Railken\Amethyst\Fakers\EmailSenderFaker;
use Railken\Amethyst\Managers\EmailSenderManager;
use Railken\Amethyst\Tests\BaseTest;

class EmailSenderTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = EmailSenderFaker::class;

    /**
     * Router group resource.
     *
     * @var string
     */
    protected $group = 'admin';

    /**
     * Route name.
     *
     * @var string
     */
    protected $route = 'admin.email-sender';

    public function testSend()
    {
        $manager = new EmailSenderManager();

        $result = $manager->create(EmailSenderFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());
        $resource = $result->getResource();

        $response = $this->callAndTest('POST', route('admin.email-sender.send', ['id' => $resource->id]), ['data' => ['name' => $resource->name]], 200);
    }

    public function testRender()
    {
        $manager = new EmailSenderManager();

        $result = $manager->create(EmailSenderFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());

        $resource = $result->getResource();

        $response = $this->callAndTest('post', route('admin.email-sender.render'), [
            'data_builder_id' => $resource->data_builder->id,
            'body'            => '{{ name }}',
            'subject'         => 'Subject',
            'recipients'      => 'test@test.net',
            'data'            => ['name' => 'ban'],
        ], 200);

        $this->assertEquals('ban', base64_decode(json_decode($response->getContent())->resource->body));
    }
}