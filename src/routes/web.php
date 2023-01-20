<?php

use Illuminate\Support\Facades\Route;

Route::get('inspire', function (Mahmoudmhamed\LaravelHelpers\Test $item) {
    return $item->justDoIt();
});
