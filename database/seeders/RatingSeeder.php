<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\Listing;
use App\Models\User;

class RatingSeeder extends Seeder
{
    public function run()
    {
        $listings = Listing::where('status', 'approved')->get();
        $users = User::where('role', 'user')->get();

        if ($listings->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please seed Listings and Users first!');
            return;
        }

        $comments = [
            'Shërbim i shkëlqyer! Shumë profesional dhe të sjellshëm.',
            'Jam shumë i kënaqur me punën e tyre. Rekomandoj pa hezitim!',
            'Çmime të arsyeshme dhe cilësi e lartë. Do të kthehem përsëri.',
            'Stafi është i përgjegjshëm dhe i gatshëm të ndihmojë.',
            'Shërbim i shpejtë dhe efektiv. Faleminderit!',
            'Eksperiencë e mrekullueshme! Shumë profesional.',
            'Më pëlqeu shumë mënyra se si u trajtova.',
            'Cilësi e jashtëzakonshme! Vlen çdo cent.',
            'Më ndihmuan shumë. Shërbim 5 yjesh!',
            'Ambiente e pastër dhe staf mjaft miqësor.',
            null, // Some ratings without comments
            null,
        ];

        $ratingsCreated = 0;

        foreach ($listings as $listing) {
            $numRatings = rand(2, 6);
            
            for ($i = 0; $i < $numRatings; $i++) {
                $user = $users->random();
                
                // Avoid duplicate ratings
                if (Rating::where('listing_id', $listing->id)->where('user_id', $user->id)->exists()) {
                    continue;
                }

                Rating::create([
                    'listing_id' => $listing->id,
                    'user_id' => $user->id,
                    'rating' => rand(3, 5),
                    'comment' => $comments[array_rand($comments)],
                    'approved' => true,
                ]);
                
                $ratingsCreated++;
            }

            // Update listing rating average
            $listing->updateRatingAverage();
        }

        $this->command->info($ratingsCreated . ' ratings created and listing averages updated!');
    }
}