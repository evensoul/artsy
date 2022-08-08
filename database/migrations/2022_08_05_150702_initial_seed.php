<?php

use App\Models\Admin;
use Fereron\CategoryTree\Models\Menu;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Admin::query()->first()) {
            Admin::factory()->create([
                'name' => 'Super Admin',
                'email' => 'admin@mail.com',
            ]);
        }

        if (!Menu::query()->first()) {
            Menu::create([
                'id' => 1,
                'name' => 'Menu',
                'slug' => 'Slug',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
