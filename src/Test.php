<?php

namespace Mahmoudmhamed\LaravelHelpers;

class Test
{
    public function justDoIt()
    {
        $response = ['quote' => 'test quote', 'author' => 'this is test message test'];

        return $response['quote'].' -'.$response['author'];
    }
}
