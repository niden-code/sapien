<?php
namespace Sapien\Response;

use Sapien\Exception;
use Sapien\ResponseTest;

class FileResponseTest extends \PHPUnit\Framework\TestCase
{
    use Assertions;

    public function test() : void
    {
        $response = new FileResponse();
        $response->setContent(__DIR__ . '/fake-content.txt');
        $this->assertSent(
            $response,
            200,
            [
                'content-disposition: attachment; filename="fake-content.txt"',
                'content-type: application/octet-stream',
                'content-transfer-encoding: binary',
                'content-length: 12',
            ],
            ResponseTest::OUTPUT
        );
    }

    public function testBadContent() : void
    {
        $response = new FileResponse();
        $this->expectException(Exception::CLASS);
        $this->expectExceptionMessage('Sapien\Response\FileResponse content must be string or SplFileObject');
        $response->setContent(null);
    }

    public function testSendWithoutContent() : void
    {
        $response = new FileResponse();
        $this->expectException(Exception::CLASS);
        $this->expectExceptionMessage('Sapien\Response\FileResponse has no file to send');
        $response->send();
    }
}
