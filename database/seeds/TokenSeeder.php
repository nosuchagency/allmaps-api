<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Token;

class TokenSeeder extends Seeder
{
    public function run()
    {
        $token = Token::firstOrCreate([
            'name' => 'Seeded Token',
            'token' => Str::random(60)(60)
        ]);

        $token->assignRole('admin');
    }
}