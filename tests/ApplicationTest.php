<?php

use Bow\Testing\TestCase;

class ApplicationTest extends TestCase
{
    public function test_show_the_welcome_page()
    {
        $response = $this->get('/status');

        $response->assertStatus(200)->assertContentType('application/json');
    }
}
