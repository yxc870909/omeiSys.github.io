<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $this->call(CategoryTableSeeder::class);
        // $this->call(TempleFromTxt::class);
        // $this->call(UserFromTxt::class);
        // $this->call(TempleUpidFromTxt::class);
        // $this->call(AgendaFromTxt::class);
        // $this->call(BookFromTxt::class);
        // $this->call(ActivityTypeTableSeeder::class);
        // $this->call(CenterActivityTypeTableSeeder::class);

        
        $this->call(UserTableSeeder::class);
        $this->call(TempleTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(AgendaTableSeeder::class);
        $this->call(ActivityTableSeeder::class);
        $this->call(ActivityTypeTableSeeder::class);
        $this->call(CenterActivityTableSeeder::class);
        $this->call(CenterActivityTypeTableSeeder::class);
        $this->call(BooksTableSeeder::class);
        $this->call(SubscriptionBookTableSeeder::class);
        $this->call(SubApplicationTableSeeder::class);
        $this->call(BorrowBooksSeeder::class);
        $this->call(CenterRecordSeeder::class);
        
    }
}
