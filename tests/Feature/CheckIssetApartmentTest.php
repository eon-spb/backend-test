<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use XMLReader;

class CheckIssetApartmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $reader = new XMLReader();
        $reader->open('storage/tmp/test.xml');
        $result = false;
        while ($reader->read()) {
            if ($result) continue;
            $result = $reader->nodeType == XMLReader::ELEMENT && $reader->name === 'apartment';
        }
        $reader->close();
        $this->assertTrue($result);
    }
}
