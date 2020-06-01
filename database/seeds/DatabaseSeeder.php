<?php

use App\Project;
use Carbon\Carbon;
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
            [ 'email' => 'test1@email.com', 'password' => Hash::make('password'), 'name' => 'Gianfranco', 'surname' => 'Mossa', 'birthday' => '1994-11-16', 'gender' => 'Maschio', 'skills' => Str::random(255), 'interests' => 'Svago,Tecnologia,Viaggio,Arte & Disegno,Videogioco', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'email' => 'test2@email.com', 'password' => Hash::make('password'), 'name' => 'Francesco', 'surname' => 'Gasbarro', 'birthday' => '1996-12-04', 'gender' => 'Maschio', 'skills' => Str::random(255), 'interests' => 'Svago,Sport,Tecnologia,Politica,Videogioco', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'email' => 'test3@email.com', 'password' => Hash::make('password'), 'name' => 'Umberto', 'surname' => 'Messina', 'birthday' => '1996-05-18', 'gender' => 'Maschio', 'skills' => Str::random(255), 'interests' => 'Tecnologia,Medicina,Viaggio,Lettura,Videogioco', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'email' => 'test4@email.com', 'password' => Hash::make('password'), 'name' => 'Angelo', 'surname' => 'Minoia', 'birthday' => '1998-12-11', 'gender' => 'Maschio', 'skills' => Str::random(255), 'interests' => 'Sport,Volontariato,Viaggio,Musica', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
        ];

        $projects = [
            [ 'name' => 'Project 1', 'description' => Lipsum::short()->text(3), 'labels' => 'Svago,Tecnologia,Economia', 'leader_id' => '1', 'slug' => 'project-1-' . Project::createSlugCode(), 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'name' => 'Project 2', 'description' => Lipsum::short()->text(2), 'labels' => 'Economia,Politica', 'leader_id' => '1', 'slug' => 'project-2-' . Project::createSlugCode(), 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'name' => 'Project 3', 'description' => Lipsum::short()->text(4), 'labels' => 'Medicina,Volontariato,Viaggio', 'leader_id' => '2', 'slug' => 'project-3-' . Project::createSlugCode(), 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'name' => 'Project 4', 'description' => Lipsum::short()->text(4), 'labels' => 'Svago,Viaggio,Musica', 'leader_id' => '2', 'slug' => 'project-4-' . Project::createSlugCode(), 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'name' => 'Project 5', 'description' => Lipsum::short()->text(1), 'labels' => 'Svago,Arte & Disegno,Lettura', 'leader_id' => '3', 'slug' => 'project-5-' . Project::createSlugCode(), 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'name' => 'Project 6', 'description' => Lipsum::short()->text(3), 'labels' => 'Sport,Videogioco', 'leader_id' => '3', 'slug' => 'project-6-' . Project::createSlugCode(), 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'name' => 'Project 7', 'description' => Lipsum::short()->text(3), 'labels' => 'Economia,Politica,Lettura', 'leader_id' => '3', 'slug' => 'project-7-' . Project::createSlugCode(), 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'name' => 'Project 8', 'description' => Lipsum::short()->text(3), 'labels' => 'Sport,Medicina', 'leader_id' => '4', 'slug' => 'project-8-' . Project::createSlugCode(), 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
        ];

        $sponsors = [
            [ 'title' => 'Sponsorship 1', 'description' => Lipsum::short()->text(3), 'project_id' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'title' => 'Sponsorship 2', 'description' => Lipsum::short()->text(3), 'project_id' => '1', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'title' => 'Sponsorship 3', 'description' => Lipsum::short()->text(2), 'project_id' => '2', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'title' => 'Sponsorship 4', 'description' => Lipsum::short()->text(4), 'project_id' => '3', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
            [ 'title' => 'Sponsorship 5', 'description' => Lipsum::short()->text(4), 'project_id' => '3', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s'), ],
        ];

        DB::table('users')->insert($users);
        DB::table('projects')->insert($projects);
        DB::table('sponsors')->insert($sponsors);
        // $this->call(UserSeeder::class);
    }
}
