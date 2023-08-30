<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$count = Db::table('roles')->count();

        if(!$count){
    		
    		DB::table('roles')->insert([
                'title' => "Admin",
                'is_deleteable' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by'=> 0
            ]);

            DB::table('roles')->insert([
                'title' => "CST",
                'is_deleteable' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by'=> 0
            ]);

            DB::table('roles')->insert([
                'title' => "Comfort Advisor",
                'is_deleteable' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by'=> 0
            ]);

            DB::table('roles')->insert([
                'title' => "Installer",
                'is_deleteable' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by'=> 0
            ]);

            DB::table('roles')->insert([
                'title' => "Technician",
                'is_deleteable' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'created_by'=> 0
            ]);

    	}
    
    }
}
