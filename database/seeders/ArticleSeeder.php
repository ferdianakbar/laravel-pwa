<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('email','admin@admin.com')->first();

        Article::create([
            'title' => 'A falsis exsul festus tata',
            'description' => preg_replace("/\r|\n|               /", "", 'Seas grow with courage at the coal-black fort charles! Mash up the chickpeas with chopped black pepper, baking powder,
                rum, and parsley making sure to cover all of it.
                Who can fear the purpose and core of an aspect if he has the pictorial awareness of the power?
                Our eternal afterlife for vision is to gain others silently.'),
            'author' => $admin->id
        ]);

        Article::create([
            'title' => 'Historia prareres, tanquam camerarius sectam.',
            'description' => preg_replace("/\r|\n|               /", "", 'Senior, extraterrestrial kahlesses accelerative examine a crazy, reliable pathway.
                The adventure is an apocalyptic proton. Dosis are the space suits of the dead sensor.
                When the teleporter warps for nowhere, all crewmates control ancient, carnivorous tribbles.
                Quickly invade a particle. Ionic cannon at the port that is when evil mermaids fly. Dosis walk from mankinds like colorful suns.'),
            'author' => $admin->id
        ]);

        Article::create([
            'title' => 'a-falsis-exsul-festus-tata',
            'description' => preg_replace("/\r|\n|               /", "", 'Parasites harvest with adventure at the final universe! The core is a distant kahless.
                Greatly exaggerated mysteries lead to the beauty. This flight has only been outweighed by a united nanomachine.
                Powerdrain at the homeworld that is when virtual starships warp. Huge green people, to the habitat bravelyred alert.
                Malfunction without beauty, and we won’t transfer a sun.'),
            'author' => $admin->id
        ]);

    }
}
