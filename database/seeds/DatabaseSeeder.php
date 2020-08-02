<?php

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
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PermissionSeeder::class);
//        factory(\App\Category::class , 50)->create();
//        factory(\App\Product::class , 50)->create()->each(function ($product) {
//            factory(\App\Gallery::class , rand(0,10))
//                ->create([ 'product_id' => $product->id]);
//            factory(\App\Productlike::class , rand(0,10))
//                ->create([ 'product_id' => $product->id]);
//        });
//        factory(\App\Article::class , 50)->create(['user_id' => \App\User::all()->random()->id]);
//        factory(\App\Video::class , 50)->create(['user_id' => \App\User::all()->random()->id]);
//        $products = App\Product::all();
//
//        App\Category::all()->each(function ($category) use ($products) {
//            $category->products()->attach(
//                $products->random(rand(1, 3))->pluck('id')->toArray()
//            );
//        });
//        App\Article::all()->each(function ($article) use ($products) {
//            $article->products()->attach(
//                $products->random(rand(1, 3))->pluck('id')->toArray()
//            );
//        });
//        App\Video::all()->each(function ($video) use ($products) {
//            $video->products()->attach(
//                $products->random(rand(1, 3))->pluck('id')->toArray()
//            );
//        });

    }
}
