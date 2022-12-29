<?php

namespace Mahmoudmhamed\LaravelHelpers;

class Test
{
    public function justDoIt()
    {
        $response = ['quote' => 'test quote', 'author' => 'mahmoutd test'];

        return $response['quote'].' -'.$response['author'];
    }
}
