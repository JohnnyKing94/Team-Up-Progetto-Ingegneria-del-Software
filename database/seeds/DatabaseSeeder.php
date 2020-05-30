<?php

use App\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [ 'email' => 'test1@hotmail.it', 'password' => Hash::make('password'), 'name' => 'Name 1', 'surname' => 'Surname 1', 'birthday' => '1990-10-10', 'gender' => 'Maschio', 'skills' => Str::random(255), 'interests' => 'Svago,Economia,Tecnologia', ],
            [ 'email' => 'test2@hotmail.it', 'password' => Hash::make('password'), 'name' => 'Name 2', 'surname' => 'Surname 2', 'birthday' => '1994-08-22', 'gender' => 'Femmina', 'skills' => Str::random(255), 'interests' => 'Svago,Sport', ],
            [ 'email' => 'test3@hotmail.it', 'password' => Hash::make('password'), 'name' => 'Name 3', 'surname' => 'Surname 3', 'birthday' => '1996-01-07', 'gender' => 'Maschio', 'skills' => Str::random(255), 'interests' => 'Medicina,Tecnologia', ],
            [ 'email' => 'test4@hotmail.it', 'password' => Hash::make('password'), 'name' => 'Name 4', 'surname' => 'Surname 4', 'birthday' => '1991-09-13', 'gender' => 'Non specificato', 'skills' => Str::random(255), 'interests' => 'Politica,Sport', ],
        ];

        $projects = [
            [ 'name' => 'Project 1', 'description' => Str::random(255), 'labels' => 'Svago,Economia,Tecnologia', 'ownerid' => '1', 'slug' => 'project-1-' . Project::createProjectSlug() ],
            [ 'name' => 'Project 2', 'description' => Str::random(255), 'labels' => 'Economia', 'ownerid' => '1', 'slug' => 'project-2-' . Project::createProjectSlug() ],
            [ 'name' => 'Project 3', 'description' => Str::random(255), 'labels' => 'Svago,Tecnologia', 'ownerid' => '2', 'slug' => 'project-3-' . Project::createProjectSlug() ],
            [ 'name' => 'Project 4', 'description' => Str::random(255), 'labels' => 'Politica,Tecnologia', 'ownerid' => '3', 'slug' => 'project-4-' . Project::createProjectSlug() ],
            [ 'name' => 'Project 5', 'description' => Str::random(255), 'labels' => 'Medicina,Economia', 'ownerid' => '3', 'slug' => 'project-5-' . Project::createProjectSlug() ],
        ];

        DB::table('users')->insert($users);
        DB::table('projects')->insert($projects);
        // $this->call(UserSeeder::class);
    }
}
