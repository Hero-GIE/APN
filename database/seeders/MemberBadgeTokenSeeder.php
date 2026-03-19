<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use Illuminate\Support\Str;

class MemberBadgeTokenSeeder extends Seeder
{
    public function run()
    {
        Member::whereNull('badge_token')->each(function($member) {
            $member->badge_token = Str::random(32);
            $member->save();
        });
    }
}