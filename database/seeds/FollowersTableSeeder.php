<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $user = $users->first();

        $followers = $users->slice($user->id);
        $following_ids = $followers->pluck('id')->toArray();

        $user->follow($following_ids);

        foreach ($followers as $follower) {
            $follower->follow($user->id);
        }
    }
}
