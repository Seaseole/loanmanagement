<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Core Departments
        $deptData = [
            ['name' => 'Executive Office', 'description' => 'Top level management'],
            ['name' => 'Loan Operations', 'description' => 'Loan processing and approvals'],
            ['name' => 'Customer Relations', 'description' => 'Customer onboarding and support'],
            ['name' => 'IT & Systems', 'description' => 'System maintenance and security'],
        ];

        foreach ($deptData as $dept) {
            $createdDept = Department::create([
                'name' => $dept['name'],
                'slug' => Str::slug($dept['name']),
                'description' => $dept['description'],
                'is_active' => true,
            ]);

            // 2. Create Positions based on Department
            if ($dept['name'] === 'Executive Office') {
                $pos = Position::create([
                    'department_id' => $createdDept->id,
                    'name' => 'Chief Executive Officer',
                    'slug' => 'ceo',
                    'is_active' => true,
                ]);

                // Create Superadmin User
                User::create([
                    'name' => 'Admin User',
                    'username' => 'admin',
                    'email' => 'admin@botslms.com',
                    'password' => Hash::make('password'),
                    'department_id' => $createdDept->id,
                    'position_id' => $pos->id,
                    'user_type' => 'Superadmin',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
            }

            if ($dept['name'] === 'Loan Operations') {
                $pos = Position::create([
                    'department_id' => $createdDept->id,
                    'name' => 'Senior Loan Officer',
                    'slug' => 'senior-loan-officer',
                    'is_active' => true,
                ]);

                // Create Employee User
                User::create([
                    'name' => 'Loan Officer',
                    'username' => 'loanofficer',
                    'email' => 'officer@botslms.com',
                    'password' => Hash::make('password'),
                    'department_id' => $createdDept->id,
                    'position_id' => $pos->id,
                    'user_type' => 'Employee',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
            }
        }
    }
}
