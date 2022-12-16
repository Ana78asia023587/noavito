<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Orchid\Platform\Models\Role;

class RoleSeeder extends Seeder
{
    private const ROLES = [
        [
            'name' => 'Pro-аккаунт',
            'slug' => 'pro-user',
        ],
    ];

    public function run()
    {
        foreach (self::ROLES as $role) {
            Role::query()->updateOrCreate([
                'slug' => $role['slug']
            ], $role);
        }
    }
}
