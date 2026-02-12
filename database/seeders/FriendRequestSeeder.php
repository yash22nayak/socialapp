<?php

namespace Database\Seeders;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FriendRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereNot('id', 1)->pluck('id')->toArray();
        $receiver_id = 1;
        $requests = [];

        foreach ($users as $key => $value) {
            $status = fake()->randomElement(['sent', 'accept', 'reject']);

            $requests[] = [
                'sender_id' => $value,
                'receiver_id' => $receiver_id,
                'status' => $status,
                'accepted_at' => $status === 'accept' ? now() : null,
                'created_at' => now(),
                'updated_at' => now(),
                'unfriended_by_id' => ($key % 5) === 0 ? $receiver_id : null,
            ];
        }


        FriendRequest::insert($requests);
    }
}
