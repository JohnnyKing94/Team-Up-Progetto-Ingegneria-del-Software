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
            [ 'name' => 'Project 1', 'description' => Lipsum::short()->text(3), 'labels' => 'Svago,Economia,Tecnologia', 'owner_id' => '1', 'slug' => 'project-1-' . Project::createProjectSlug() ],
            [ 'name' => 'Project 2', 'description' => Lipsum::short()->text(2), 'labels' => 'Economia', 'owner_id' => '1', 'slug' => 'project-2-' . Project::createProjectSlug() ],
            [ 'name' => 'Project 3', 'description' => Lipsum::short()->text(4), 'labels' => 'Svago,Tecnologia', 'owner_id' => '2', 'slug' => 'project-3-' . Project::createProjectSlug() ],
            [ 'name' => 'Project 4', 'description' => Lipsum::short()->text(1), 'labels' => 'Politica,Tecnologia', 'owner_id' => '3', 'slug' => 'project-4-' . Project::createProjectSlug() ],
            [ 'name' => 'Project 5', 'description' => Lipsum::short()->text(3), 'labels' => 'Medicina,Economia', 'owner_id' => '3', 'slug' => 'project-5-' . Project::createProjectSlug() ],
        ];

        DB::table('users')->insert($users);
        DB::table('projects')->insert($projects);
        // $this->call(UserSeeder::class);
    }
}
