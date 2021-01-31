<?php

namespace Tests\Unit;

use Illuminate\Support\HtmlString;
use PHPUnit\Framework\TestCase;
use Revolution\Ordering\Support\QrCode;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testQrcode()
    {
        $qr = QrCode::svg('http://');

        $this->assertNotEmpty((string) $qr);
        $this->assertInstanceOf(HtmlString::class, $qr);
    }
}
