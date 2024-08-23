<?php

test('get otp', function () {
    $data = [
        'phoneNumber' => '09157982447',
    ];

    $response = $this->postJson('/api/getotp', $data);


    $text = 'otp has been sent!';
    $response->assertSee($text);
});
