<?php

namespace LaravelHelpers\Test;

use Illuminate\Support\Facades\Http;

class Test {
    public function justDoIt() {
        $response = ['quote'=>'test quote','author'=>'mahmoutd test'];

        return $response['quote'] . ' -' . $response['author'];
    }
}
