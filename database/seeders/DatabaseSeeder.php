<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@cinema.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        $sampleMovies = [
            [
                'title' => 'Inception',
                'description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'release_year' => 2010,
                'rating' => 8.8,
                'image' => null,
            ],
            [
                'title' => 'Interstellar',
                'description' => 'When Earth becomes uninhabitable in the future, a farmer and ex-NASA pilot, Joseph Cooper, is tasked to pilot a spacecraft, along with a team of researchers, to find a new planet for humans.',
                'release_year' => 2014,
                'rating' => 8.7,
                'image' => null,
            ],
            [
                'title' => 'The Dark Knight',
                'description' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'release_year' => 2008,
                'rating' => 9.0,
                'image' => null,
            ],
            [
                'title' => 'Pulp Fiction',
                'description' => 'The lives of two mob hitmen, a boxer, a gangster and his wife, and a pair of diner bandits intertwine in four tales of violence and redemption.',
                'release_year' => 1994,
                'rating' => 8.9,
                'image' => null,
            ],
            [
                'title' => 'The Matrix',
                'description' => 'When a beautiful stranger leads computer hacker Neo to a forbidding underworld, he discovers the shocking truth--the life he knows is the elaborate deception of an evil cyber-intelligence.',
                'release_year' => 1999,
                'rating' => 8.7,
                'image' => null,
            ],
            [
                'title' => 'Oppenheimer',
                'description' => 'The story of American scientist J. Robert Oppenheimer and his role in the development of the atomic bomb.',
                'release_year' => 2023,
                'rating' => 8.9,
                'image' => null,
            ],
            [
                'title' => 'Dune: Part Two',
                'description' => 'Paul Atreides unites with Chani and the Fremen while seeking revenge against the conspirators who destroyed his family.',
                'release_year' => 2024,
                'rating' => 8.6,
                'image' => null,
            ],
            [
                'title' => 'Gladiator',
                'description' => 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.',
                'release_year' => 2000,
                'rating' => 8.5,
                'image' => null,
            ],
            [
                'title' => 'Avatar',
                'description' => 'A paraplegic Marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.',
                'release_year' => 2009,
                'rating' => 7.9,
                'image' => null,
            ],
            [
                'title' => 'Spirited Away',
                'description' => 'During her family\'s move to the suburbs, a sullen 10-year-old girl wanders into a world ruled by gods, witches, and spirits, and where humans are changed into beasts.',
                'release_year' => 2001,
                'rating' => 8.6,
                'image' => null,
            ],
        ];

        foreach ($sampleMovies as $movieData) {
            Movie::firstOrCreate(
                ['title' => $movieData['title']],
                $movieData
            );
        }
    }
}
