<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SetupApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create required configuration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Starting all required tasks...');

        $this->line('Running migrations');
        Artisan::call('migrate:fresh');
        $this->info('Migration success');
        
        $this->line('Seeding training data');
        Artisan::call('db:seed');
        $this->info('Seeding success');

        $this->line('Create default users');
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        $this->info('User created. email = admin@mail.com | password = password | role = admin');

        DB::table('users')->insert([
            'name' => 'teacher',
            'email' => 'teacher@mail.com',
            'password' => bcrypt('password'),
            'role' => 'teacher'
        ]);
        $this->info('User created. email = teacher@mail.com | password = password | role = teacher');

        $this->info('Finish running all required tasks');

    }
}
