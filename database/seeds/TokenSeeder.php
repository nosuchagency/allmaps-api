<?php

use Illuminate\Database\Seeder;

use App\Models\Token;

class TokenSeeder extends Seeder
{
    public function run()
    {
        $token = Token::firstOrCreate([
            'name' => 'Seeded Token',
            'token' => str_random(60)
        ]);

        $token->assignRole('admin');
    }
}