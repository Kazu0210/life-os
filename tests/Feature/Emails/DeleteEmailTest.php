<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Emails\Models\Email;

uses(RefreshDatabase::class);

test('an email can be deleted', function () {
    $email = Email::create(['email' => 'delete-me@example.com']);

    $response = $this->deleteJson(route('emails.destroy', $email));

    $response->assertNoContent();
    $this->assertDatabaseMissing('emails', ['id' => $email->id]);
});

test('deleting a missing email returns not found', function () {
    $response = $this->deleteJson(route('emails.destroy', 999));

    $response->assertNotFound();
});
