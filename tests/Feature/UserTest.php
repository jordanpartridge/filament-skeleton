<?php

use App\Models\User;

it('has a valid factory', function () {
    $user = User::factory()->create();
    expect($user)->toBeInstanceOf(User::class);
});
