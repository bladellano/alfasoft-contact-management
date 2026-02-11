<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Person;
use App\Services\CountryService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function create(Request $request)
    {
        $personId = $request->query('person');
        $person = Person::findOrFail($personId);
        $countries = $this->countryService->getAllCountries();

        return view('contacts.form', compact('person', 'countries'));
    }

    public function show(Contact $contact)
    {
        $contact->load('person');
        $countries = $this->countryService->getAllCountries();

        $countryName = collect($countries)->firstWhere('calling_code', $contact->country_code)['name'] ?? 'Unknown';

        return view('contacts.show', compact('contact', 'countryName'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'person_id' => 'required|exists:people,id',
            'country_code' => 'required|string',
            'number' => 'required|digits:9|unique:contacts,number,NULL,id,country_code,' . $request->country_code,
        ]);

        Contact::create($validated);

        return redirect()->route('people.show', $validated['person_id'])->with('success', 'Contact created successfully.');
    }

    public function edit(Contact $contact)
    {
        $person = $contact->person;
        $countries = $this->countryService->getAllCountries();

        return view('contacts.form', compact('contact', 'person', 'countries'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'person_id' => 'required|exists:people,id',
            'country_code' => 'required|string',
            'number' => 'required|digits:9|unique:contacts,number,' . $contact->id . ',id,country_code,' . $request->country_code,
        ]);

        $contact->update($validated);

        return redirect()->route('people.show', $validated['person_id'])->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $personId = $contact->person_id;
        $contact->delete();

        return redirect()->route('people.show', $personId)->with('success', 'Contact deleted successfully.');
    }
}
