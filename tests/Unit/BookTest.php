<?php

namespace Tests\Unit;

use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_book_store()
    {
        $response = $this->call('POST','/books',[
            'title'=> 'Some book Title 123',
            'content' =>'Some book content 123',
             'price' => '1212',
             'year_published'=> '2021', 

        ]);
       //dd($response->statusCode);
        $response->assertStatus(200);
        $this->assertTrue(true);
    }
}
