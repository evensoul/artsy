<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    private const AVATAR_URLS = [
        'https://yt3.ggpht.com/9xMkfTVDrIjDq-f4uZqVVPGxT6Z8mB5Snpso6kV6YDBKUNo3F1cZfCCu1Cb3gr78R1GkbKR0=s900-c-k-c0x00ffffff-no-rj',
        'https://scanport.ru/assets/uploads/tv/2053/2053-2021-03-23-2yltdp.png',
        'https://upload.wikimedia.org/wikipedia/commons/e/ee/Logo_brand_Adidas.png',
        'https://w7.pngwing.com/pngs/231/935/png-transparent-the-north-face-logo-the-north-face-logo-outerwear-decal-berghaus-the-north-face-face-text-logo-thumbnail.png',
        'https://cdn.freelogovectors.net/wp-content/uploads/2019/02/Mavi_Jeans_Logo.png',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'description' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'avatar' => $this->faker->randomElement(self::AVATAR_URLS),
        ];
    }
}
