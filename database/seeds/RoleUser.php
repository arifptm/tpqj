<?php

use Illuminate\Database\Seeder;
use \Silber\Bouncer\BouncerFacade as Bouncer;

class RoleUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
   {
    	$super = \App\User::create([
    		'name' => 'Super',
    		'email' => 'super@app.com',
    		'password' => bcrypt('password'),
    		'verified' => 1
    	]);

    	$admin = \App\User::create([
    		'name' => 'Admin',
    		'email' => 'admin@app.com',
    		'password' => bcrypt('password'),
    		'verified' => 1
    	]);

    	$user = \App\User::create([
    		'name' => 'User',
    		'email' => 'user@app.com',
    		'password' => bcrypt('password'),
    		'verified' => 1
    	]);


    	Bouncer::allow('super')->to('manage-users');
    	Bouncer::allow('super')->to('manage-roles');
    	Bouncer::assign('super')->to($super);
    	
    	Bouncer::allow('admin')->to('manage-users');
    	Bouncer::assign('admin')->to($admin);

		Bouncer::assign('user')->to($user);

    }
 }
