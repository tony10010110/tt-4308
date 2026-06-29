<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\HeroSection;
use App\Models\Page;
use App\Models\Price;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@mounty.ua'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Hero section
        HeroSection::firstOrCreate(
            ['title' => 'МААААМ, Я В КАРПАТИ'],
            [
                'subtitle'    => 'Сервіс подорожей кращими місцями Карпат',
                'button_text' => 'Дізнатися більше',
                'button_url'  => '#routes',
                'is_active'   => true,
            ]
        );

        // Prices
        $plans = [
            [
                'title'      => 'Базовий',
                'price'      => 2500,
                'period'     => 'за похід',
                'features'   => ['Маршрут на 2 дні', 'Інструктор', 'Страхування'],
                'is_popular' => false,
                'sort_order' => 1,
            ],
            [
                'title'      => 'Стандарт',
                'price'      => 4500,
                'period'     => 'за похід',
                'features'   => ['Маршрут на 4 дні', 'Інструктор', 'Страхування', 'Харчування', 'Спорядження'],
                'is_popular' => true,
                'sort_order' => 2,
            ],
            [
                'title'      => 'Преміум',
                'price'      => 8000,
                'period'     => 'за похід',
                'features'   => ['Маршрут на 7 днів', 'Персональний гід', 'Страхування', 'Харчування', 'Спорядження', 'Трансфер'],
                'is_popular' => false,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            Price::firstOrCreate(['title' => $plan['title']], array_merge($plan, ['is_active' => true]));
        }

        // FAQ
        $faqs = [
            ['question' => 'Що потрібно мати з собою?', 'answer' => 'Зручний одяг, водонепроникні черевики, дощовик, особисті речі. Спорядження можна орендувати у нас.', 'sort_order' => 1],
            ['question' => 'Чи є вікові обмеження?', 'answer' => 'Мінімальний вік — 14 років. Діти до 18 років лише у супроводі батьків.', 'sort_order' => 2],
            ['question' => 'Що включено у вартість?', 'answer' => 'Послуги інструктора, страхування, розміщення на маршруті. Деталі залежать від обраного тарифу.', 'sort_order' => 3],
            ['question' => 'Як відбувається запис?', 'answer' => 'Залиште заявку на сайті або зателефонуйте нам. Менеджер звʼяжеться з вами протягом 30 хвилин.', 'sort_order' => 4],
            ['question' => 'Чи можна скасувати бронювання?', 'answer' => 'Так, скасування безкоштовне за 7 і більше днів до початку туру.', 'sort_order' => 5],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], array_merge($faq, ['is_active' => true]));
        }

        // About page
        Page::firstOrCreate(
            ['slug' => 'about'],
            [
                'title'            => 'Про Маунті',
                'content'          => '<p>Mounty — сервіс подорожей кращими місцями Карпат. Ми організовуємо туристичні походи для людей, які хочуть відкрити для себе справжню красу гір.</p>',
                'meta_title'       => 'Про Маунті — Сервіс подорожей Карпатами',
                'meta_description' => 'Дізнайтесь більше про команду Mounty та наш підхід до організації гірських походів.',
                'is_active'        => true,
            ]
        );
    }
}
