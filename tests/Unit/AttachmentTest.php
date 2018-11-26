<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit;

use Orchid\Attachment\File;
use Orchid\Tests\TestUnitCase;
use Illuminate\Http\UploadedFile;

/**
 * Class AttachmentTest.
 */
class AttachmentTest extends TestUnitCase
{
    /**
     * @var string
     */
    public $disk;

    /**
     * @test
     */
    public function testAttachmentFile()
    {
        $file = UploadedFile::fake()->create('document.xml', 200);
        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertEquals([
            'size' => $file->getSize(),
            'name' => $file->name,
        ], [
            'size' => $upload->size,
            'name' => $upload->original_name,
        ]);

        $this->assertContains($upload->name.'.xml', $upload->url());
    }

    /**
     * @test
     */
    public function testAttachmentImage()
    {
        $file = UploadedFile::fake()->image('avatar.jpg', 1920, 1080)->size(100);

        $attachment = new File($file, $this->disk);
        $upload = $attachment->load();

        $this->assertNotNull($upload->url());
    }

    protected function setUp()
    {
        parent::setUp();
        $this->disk = 'public';
    }
}
