<?php

use Illuminate\Database\Seeder;
use App\Journal;

class JournalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Journal::truncate();
        Journal::create(['name' => '/storage/journals/2015.pdf']);
        Journal::create(['name' => '/storage/journals/2017.pdf']);
        Journal::create(['name' => '/storage/journals/2018.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2005.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2006.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2007.pdf']);
        Journal::create(['name' => '/storage/storage/journals/cover_june_2008.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2009.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2010.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2011.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2012.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2013.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2014.pdf']);
        Journal::create(['name' => '/storage/journals/cover_june_2015.pdf']);
        Journal::create(['name' => '/storage/journals/dec_ cover_2010.pdf']);
        Journal::create(['name' => '/storage/journals/dec_2016.pdf']);
        Journal::create(['name' => '/storage/journals/dec_2017.pdf']);
        Journal::create(['name' => '/storage/journals/dec_cover_2005.pdf']);
        Journal::create(['name' => '/storage/journals/dec_cover_2006.pdf']);
        Journal::create(['name' => '/storage/journals/dec_cover_2007.pdf']);
        Journal::create(['name' => '/storage/journals/dec_cover_2008.pdf']);
        Journal::create(['name' => '/storage/journals/dec_cover_2009.doc']);
        Journal::create(['name' => '/storage/journals/dec_cover_2011.pdf']);
        Journal::create(['name' => '/storage/journals/dec_cover_2012.pdf']);
        Journal::create(['name' => '/storage/journals/dec_cover_2013.pdf']);
        Journal::create(['name' => '/storage/journals/dec_cover_2014.pdf']);
        Journal::create(['name' => '/storage/journals/dec_cover_2015.pdf']);
        Journal::create(['name' => '/storage/journals/deccover_2015.pdf']);
        Journal::create(['name' => '/storage/journals/june 2019.pdf']);
    }
}
