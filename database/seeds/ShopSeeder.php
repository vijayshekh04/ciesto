<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Shop;
use App\Product;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
    	for($i=1;$i<=100;$i++)
    	{
    		$shopData['name'] = "shop".$i;
    		$shopData['image'] = "no-image.png";
    		$shopData['email'] = "shop".$i."@gmail.com";
    		$shopData['address'] = "shop".$i."Address";
    		$id = Shop::create($shopData)->id;

    		$productData['shop_id'] = $id;
            $productData['name'] = "product ".$i;
            $productData['price'] = rand(10,100);
            $productData['stock'] =  rand(1,10);
            Product::create($productData);
    	}
    }
}
