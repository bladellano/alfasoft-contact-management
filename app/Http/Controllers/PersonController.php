<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        $people = Person::all();
        return view('people.index', compact('people'));
    }

    public function show(Person $person)
    {
        $person->load('contacts');
        return view('people.show', compact('person'));
    }

    public function create()
    {
        return view('people.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|email|unique:people,email',
        ]);

        Person::create($validated);

        return redirect()->route('people.index')->with('success', 'Person created successfully.');
    }

    public function edit(Person $person)
    {
        return view('people.form', compact('person'));
    }

    public function update(Request $request, Person $person)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|email|unique:people,email,' . $person->id,
        ]);

        $person->update($validated);

        return redirect()->route('people.index')->with('success', 'Person updated successfully.');
    }
}
