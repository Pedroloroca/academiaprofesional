<?php

test('can switch locale via web route', function () {
    $response = $this->get(route('locale.change', 'en'));

    $response->assertRedirect();
    $this->assertEquals('en', session('locale'));
});

test('can switch to french', function () {
    $response = $this->get(route('locale.change', 'fr'));

    $response->assertRedirect();
    $this->assertEquals('fr', session('locale'));

    // Verify it loads with the correct language
    $response2 = $this->withSession(['locale' => 'fr'])->get('/');
    $response2->assertSee('Nouveaux cours disponibles');
});

test('ignores invalid locales', function () {
    $response = $this->get(route('locale.change', 'invalid'));

    $response->assertRedirect();
    $this->assertFalse(session()->has('locale'));
});
