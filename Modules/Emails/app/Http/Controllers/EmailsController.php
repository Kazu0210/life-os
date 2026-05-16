<?php

namespace Modules\Emails\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Emails\Models\Email;

class EmailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('emails::index');
    }

    public function data(): JsonResponse
    {
        $emails = Email::query()
            ->latest()
            ->get(['id', 'email', 'created_at']);

        return response()->json($emails);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('emails::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:emails,email'],
        ]);

        Email::create($validated);

        return redirect()->route('emails.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('emails::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('emails::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email): JsonResponse
    {
        $email->delete();

        return response()->json(null, 204);
    }
}
