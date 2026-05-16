<?php

use App\Support\CommandPalette;

it('includes home and module navigation routes', function () {
    $items = CommandPalette::items();

    expect($items)->not->toBeEmpty();

    $ids = collect($items)->pluck('id');

    expect($ids)->toContain('home')
        ->and($ids)->toContain('emails.index')
        ->and($ids)->toContain('emails.create')
        ->and($ids)->not->toContain('emails.data');
});
