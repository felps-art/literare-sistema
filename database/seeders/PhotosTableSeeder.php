<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Photo;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //pego a lista de posts
        $listaPosts = Post::all();

        //percorro a lista de posts e crio uma foto para cada
        foreach($listaPosts as $post){
            for($i=0; $i<rand(1,3);$i++){
                Photo::create([
                    'post_id' => $post->id,
                    'image_path' => "default-post.png"
                ]);
            }
        }
    }
}
