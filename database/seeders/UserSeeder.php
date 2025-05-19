<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Division;
use App\Models\Group;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'fname' => 'Super',
            'mname' => null,
            'lname' => 'User',
            // 'name'=> "Super User",
            'employee_id' => '0000001',
            'position' => 'Admin',
            'email' => 'super.user@gmail.com',
            'company' => 'BMI',
            'password' => bcrypt('password'),
            'isReset' => 1,
            'isBranch' => 1,
            'status' => 'active'
        ]);

        $user = User::create([
            'fname' => 'Guest',
            'mname' => null,
            'lname' => 'User',
            // 'name'=> "Guest User",
            'employee_id' => '0000002',
            'position' => 'User',
            'email' => 'guest.user@gmail.com',
            'company' => 'BFC',
            'password' => bcrypt('password'),
            'isReset' => 1,
            'isBranch' => 2,
            'status' => 'active'
        ]);

        $branch1 = Branch::create([
            'name' => 'Branch 1',
            'branch_code' => '0000001',
            'location' => 'Sample Location of the Branch 1'
        ]);

        $branch2 = Branch::create([
            'name' => 'Branch 2',
            'branch_code' => '0000002',
            'location' => 'Sample Location of the Branch 2'
        ]);

        $group1 = Group::create([
            'name' => 'Group 1',
            'description' => 'Sample Description of the Group 1'
        ]);

        $group2 = Group::create([
            'name' => 'Group 2',
            'description' => 'Sample Description of the Group 2'
        ]);

        $division1 = Division::create([
            'name' => 'Division 1',
            'description' => 'Sample Description of Division 1',
            'group_id' => $group1->id,
        ]);

        $division2 = Division::create([
            'name' => 'Division 2',
            'description' => 'Sample Description of Division 2',
            'group_id' => $group2->id,
        ]);

        $department1 = Department::create([
            'name' => 'Department 1',
            'description' => 'Sample Description of Deparment 1',
            'division_id' => $division1->id
        ]);

        $department2 = Department::create([
            'name' => 'Department 2',
            'description' => 'Sample Description of Deparment 2',
            'division_id' => $division2->id
        ]);

        $section1 = Section::create([
            'name' => 'Section 1',
            'description' => 'Sample Description of Section 1',
            'division_id' => $division1->id,
            'department_id' => $department1->id
        ]);
        
        $section2 = Section::create([
            'name' => 'Section 2',
            'description' => 'Sample Description of Section 2',
            'division_id' => $division2->id,
            'department_id' => $department2->id
        ]);
    }
}
