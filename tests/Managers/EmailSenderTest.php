<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\EmailSenderFaker;
use Amethyst\Managers\DataBuilderManager;
use Amethyst\Managers\EmailSenderManager;
use Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class EmailSenderTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = EmailSenderManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = EmailSenderFaker::class;

    public function testSend()
    {
        $manager = $this->getManager();

        $result = $manager->create(EmailSenderFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());
        $resource = $result->getResource();

        $result = $manager->execute($resource, [
            'name' => $resource->name.'.png',
            'file' => 'https://github.githubassets.com/images/modules/logos_page/Octocat.png',
        ]);

        $this->assertEquals(true, $result->ok());
    }

    public function testRender()
    {
        $manager = $this->getManager();

        $result = $manager->create(EmailSenderFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());

        $resource = $result->getResource();

        $result = $manager->render($resource->data_builder, [
            'body' => '{{ name }}',
        ], (new DataBuilderManager())->build($resource->data_builder, ['name' => 'ban'])->getResource());

        $this->assertEquals(true, $result->ok());
        $this->assertEquals('ban', $result->getResource()['body']);
    }
}
