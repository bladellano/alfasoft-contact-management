<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $person1 = Person::create([
            'name' => 'João Silva',
            'email' => 'joao.silva@example.com',
        ]);

        Contact::create([
            'person_id' => $person1->id,
            'country_code' => '351',
            'number' => '912345678',
        ]);

        Contact::create([
            'person_id' => $person1->id,
            'country_code' => '351',
            'number' => '923456789',
        ]);

        $person2 = Person::create([
            'name' => 'Maria Santos',
            'email' => 'maria.santos@example.com',
        ]);

        Contact::create([
            'person_id' => $person2->id,
            'country_code' => '55',
            'number' => '987654321',
        ]);

        $person3 = Person::create([
            'name' => 'Pedro Costa',
            'email' => 'pedro.costa@example.com',
        ]);

        Contact::create([
            'person_id' => $person3->id,
            'country_code' => '34',
            'number' => '611223344',
        ]);
    }
}
