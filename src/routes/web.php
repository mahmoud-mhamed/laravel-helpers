<?php

use Illuminate\Support\Facades\Route;

Route::get('inspire', function (Mahmoudmhamed\LaravelHelpers\Test $item) {
    return 10;
    return $item->justDoIt();
});
