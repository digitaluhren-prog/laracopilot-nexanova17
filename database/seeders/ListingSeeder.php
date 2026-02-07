<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\Category;
use App\Models\User;

class ListingSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();
        $users = User::where('role', 'user')->get();

        if ($categories->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Please seed Categories and Users first!');
            return;
        }

        $listings = [
            // Healthcare
            [
                'title' => 'Klinika Dentare Dr. Alban Hoxha',
                'description' => 'Klinikë moderne dentare me pajisje të fundit teknologjike. Ofrojmë shërbime të plota dentare: pastrimi, mbushje, implante, ortodonti, dhe kirurgji orale. Stafi ynë profesional ka eksperiencë mbi 15 vjeçare. Çmimet më konkurruese në treg me mundësi pagese me këste.',
                'category_id' => $categories->where('slug', 'shendetesi-dhe-mjekesi')->first()->id ?? 1,
                'city' => 'Tiranë',
                'address' => 'Rruga Myslym Shyri, Nr. 45',
                'phone' => '+355 69 234 5678',
                'email' => 'info@klinikahoxha.al',
                'website' => 'https://klinikahoxha.al',
                'status' => 'approved',
            ],
            [
                'title' => 'Farmacia Shqiponja - Hapura 24/7',
                'description' => 'Farmaci e pajisur me barna origjinale dhe produkte farmaceutike të certifikuara. Hapur 24 orë në ditë, 7 ditë në javë. Konsulencë falas nga farmacistët tanë të kualifikuar. Ofrojmë shërbim dorezimi në shtëpi për pacientë me vështirësi lëvizjeje.',
                'category_id' => $categories->where('slug', 'shendetesi-dhe-mjekesi')->first()->id ?? 1,
                'city' => 'Durrës',
                'address' => 'Bulevardi Dyrrah, Pranë Spitalit Rajonal',
                'phone' => '+355 52 234 567',
                'email' => 'farmacia.shqiponja@gmail.com',
                'website' => null,
                'status' => 'approved',
            ],
            [
                'title' => 'Laboratori Analitik MediLab',
                'description' => 'Laborator modern me aparatura të fundit për analizat klinike. Ofrojmë analizat e gjakut, urinës, biokimike, hormonale, dhe teste COVID-19. Rezultate të shpejta brenda 2-4 orësh. Çmime të përballueshme dhe profesionalizëm i lartë.',
                'category_id' => $categories->where('slug', 'shendetesi-dhe-mjekesi')->first()->id ?? 1,
                'city' => 'Vlorë',
                'address' => 'Rruga Sadik Zotaj, Nr. 12',
                'phone' => '+355 69 345 6789',
                'email' => 'medilab.vlore@outlook.com',
                'website' => 'https://medilab.al',
                'status' => 'approved',
            ],

            // Legal Services
            [
                'title' => 'Zyrë Avokatie Beqiri & Partnerë',
                'description' => 'Studio juridik me eksperiencë 20 vjeçare në të gjitha degët e së drejtës. Specializuar në të drejtën civile, penale, tregtare, dhe familjare. Përfaqësim në gjykatë dhe konsulencë ligjore për individë dhe biznese. Tarifë fleksibël sipas rastit.',
                'category_id' => $categories->where('slug', 'sherbime-juridike')->first()->id ?? 2,
                'city' => 'Tiranë',
                'address' => 'Rruga Dëshmorët e 4 Shkurtit, Pallati Eurostar, Kati 5',
                'phone' => '+355 69 456 7890',
                'email' => 'avokatbeqiri@gmail.com',
                'website' => 'https://avokatibeqiri.com',
                'status' => 'approved',
            ],
            [
                'title' => 'Noteritë Publike Gjoni',
                'description' => 'Shërbime noterike të gjitha llojeve: vërtetim dokumentesh, kontrata shitblerjeje, testamente, prokura, certifikata trashëgimie. Shërbim profesional dhe i shpejtë. Orari fleksibël me takim paraprak.',
                'category_id' => $categories->where('slug', 'sherbime-juridike')->first()->id ?? 2,
                'city' => 'Shkodër',
                'address' => 'Rruga 13 Dhjetori, Nr. 78',
                'phone' => '+355 69 567 8901',
                'email' => 'noter.gjoni@yahoo.com',
                'website' => null,
                'status' => 'approved',
            ],

            // Education
            [
                'title' => 'Qendra Mësimore "Diturie"',
                'description' => 'Mësim privat për fëmijë dhe të rritur në matematikë, fizikë, gjuhë angleze, gjermane, dhe italiane. Përgatitje për provimet e maturës shtetërore dhe universitare. Mësues të certifikuar me rezultate të garantuara. Grup i vogël deri 6 nxënës.',
                'category_id' => $categories->where('slug', 'arsim-dhe-kurse')->first()->id ?? 3,
                'city' => 'Korçë',
                'address' => 'Rruga Fan Noli, Nr. 23',
                'phone' => '+355 69 678 9012',
                'email' => 'qendra.diturie@gmail.com',
                'website' => 'https://diturie.edu.al',
                'status' => 'approved',
            ],
            [
                'title' => 'Akademia e Gjuhëve të Huaja "Polyglot"',
                'description' => 'Kurse intensive dhe standarde në gjuhët angleze, gjermane, italiane, frënge, dhe spanjole. Nivele nga A1 deri C2. Certifikata ndërkombëtare TOEFL, IELTS, Goethe. Klasa moderne me teknologji interaktive. Orare fleksibël (mëngjes, pasdite, mbrëmje).',
                'category_id' => $categories->where('slug', 'arsim-dhe-kurse')->first()->id ?? 3,
                'city' => 'Tiranë',
                'address' => 'Rruga Dervish Hima, Qendra Tregtare City Park, Kati 3',
                'phone' => '+355 69 789 0123',
                'email' => 'polyglot.academy@gmail.com',
                'website' => 'https://polyglot-academy.com',
                'status' => 'approved',
            ],

            // Construction
            [
                'title' => 'Ndërtim & Rinovim "AlbConstruct"',
                'description' => 'Kompani ndërtimi me 15 vjet eksperiencë. Ofrojmë shërbime të plota ndërtimi: shtëpi private, vila, pallate, rinovime, rikonstruksione. Ekip profesional inxhinierësh dhe punëtorësh të specializuar. Çmim konkurrues dhe cilësi e garantuar.',
                'category_id' => $categories->where('slug', 'ndertim-dhe-renovim')->first()->id ?? 4,
                'city' => 'Tiranë',
                'address' => 'Rruga e Kavajës, Km 5, Kashar',
                'phone' => '+355 69 890 1234',
                'email' => 'albconstruct@outlook.com',
                'website' => 'https://albconstruct.al',
                'status' => 'approved',
            ],
            [
                'title' => 'Hidraulik & Ngrohje "ThermoPlus"',
                'description' => 'Instalime dhe riparime hidraulike, termike, dhe gazsjellësi. Montim kondicionerësh, kaldajash, dhe sistemesh ngrohëse. Mirëmbajtje periodike dhe ndërhyrje urgjente 24/7. Garanci 2 vjeçare për të gjitha instalimet.',
                'category_id' => $categories->where('slug', 'ndertim-dhe-renovim')->first()->id ?? 4,
                'city' => 'Elbasan',
                'address' => 'Rruga Qemal Stafa, Nr. 34',
                'phone' => '+355 69 901 2345',
                'email' => 'thermoplus.elbasan@gmail.com',
                'website' => null,
                'status' => 'approved',
            ],

            // Automotive
            [
                'title' => 'Servis Auto "Techno Motors"',
                'description' => 'Servis i plotë automjetesh të gjitha markave. Diagnostikë me kompjuter, riparim motorri, kambioje, frenash, suspensionesh. Ndërrimi i vajit dhe filtrave. Staf i kualifikuar dhe pajisje moderne. Çmime të arsyeshme dhe garanci për punën e kryer.',
                'category_id' => $categories->where('slug', 'automjete-dhe-transport')->first()->id ?? 5,
                'city' => 'Durrës',
                'address' => 'Autostrada Tiranë-Durrës, Km 12, Fushë Krujë',
                'phone' => '+355 69 012 3456',
                'email' => 'technomotors@yahoo.com',
                'website' => 'https://technomotors.al',
                'status' => 'approved',
            ],
            [
                'title' => 'Larje Auto "Clean Car Express"',
                'description' => 'Larje dhe pastrimi profesional i automjeteve me produkte ekologjike. Shërbime: larje e jashtme dhe e brendshme, polishing, wax, pastrimi i motorit. Shërbim i shpejtë (15-30 minuta). Abonamente mujore me çmim të reduktuar.',
                'category_id' => $categories->where('slug', 'automjete-dhe-transport')->first()->id ?? 5,
                'city' => 'Vlorë',
                'address' => 'Rruga Skelë, Pranë Portit',
                'phone' => '+355 69 123 4567',
                'email' => 'cleancarexpress@gmail.com',
                'website' => null,
                'status' => 'approved',
            ],

            // Beauty & Wellness
            [
                'title' => 'Sallon Bukurie "Elegance"',
                'description' => 'Sallon i plotë bukurie për femra dhe meshkuj. Flokët: prerje, ngjyrosje, trajtim, styling. Thonjt: manikyr, pedikyr, gel, akril. Mjekër dhe flokë për meshkuj. Kozmetikë profesionale dhe trajtim i fytyrës. Ambient luksoz dhe relaksues.',
                'category_id' => $categories->where('slug', 'bukuri-dhe-mireqenie')->first()->id ?? 6,
                'city' => 'Tiranë',
                'address' => 'Rruga Mine Peza, Nr. 12',
                'phone' => '+355 69 234 5678',
                'email' => 'elegance.salon@gmail.com',
                'website' => 'https://elegance-salon.al',
                'status' => 'approved',
            ],
            [
                'title' => 'Qendra Sportive "Fitness Zone"',
                'description' => 'Palestër moderne me pajisje të fundit Technogym. Zona kardio, peshëngritje, grup fitness (aerobik, zumba, spinning, yoga). Instruktorë personalë të certifikuar. SPA dhe sauna. Hapura nga ora 06:00 - 23:00. Abonamente fleksibël mujore dhe vjetore.',
                'category_id' => $categories->where('slug', 'bukuri-dhe-mireqenie')->first()->id ?? 6,
                'city' => 'Fier',
                'address' => 'Rruga Abdyl Frashëri, Pallati "Europa"',
                'phone' => '+355 69 345 6789',
                'email' => 'fitness.zone.fier@gmail.com',
                'website' => 'https://fitnesszone.al',
                'status' => 'approved',
            ],

            // Food & Restaurants
            [
                'title' => 'Restorant Tradicional "Gjyshja ime"',
                'description' => 'Restorant i gatimit tradicional shqiptar me receta autentike. Specialitete: tavë kosi, fergese, byrek, pite, mishë të gatuara në hell. Ambjent familjar dhe mikpritës. Çmime të arsyeshme. Rezervime për grupe dhe ngjarje. Shërbim katering për festa.',
                'category_id' => $categories->where('slug', 'ushqim-dhe-pije')->first()->id ?? 7,
                'city' => 'Shkodër',
                'address' => 'Rruga Kol Idromeno, Nr. 56',
                'phone' => '+355 69 456 7890',
                'email' => 'gjyshja.ime@yahoo.com',
                'website' => null,
                'status' => 'approved',
            ],
            [
                'title' => 'Pastiçeri Artizanale "Dolce Vita"',
                'description' => 'Pastiçeri dhe ëmbëlsira të përgatitura me dashuri dhe receta italiane origjinale. Torta personalizuara për çdo rast, byrekë të shijshëm, petulla, krem karamelja. Produkte të freskëta çdo ditë. Porosi online dhe dorëzim falas në zonë.',
                'category_id' => $categories->where('slug', 'ushqim-dhe-pije')->first()->id ?? 7,
                'city' => 'Korçë',
                'address' => 'Bulevardi Republika, Nr. 87',
                'phone' => '+355 69 567 8901',
                'email' => 'dolcevita.korce@gmail.com',
                'website' => 'https://dolcevita-korce.com',
                'status' => 'approved',
            ],

            // Technology
            [
                'title' => 'Riparim Kompjuterash "Tech Service"',
                'description' => 'Riparim dhe mirëmbajtje kompjuterash, laptopësh, dhe tabletësh. Instalim sistemesh operative, software, antivirus. Pastrimi i viruseve, rikuperimi i të dhënave. Shërbim i shpejtë dhe i sigurt. Garanci për të gjitha riparimet.',
                'category_id' => $categories->where('slug', 'teknologji-dhe-it')->first()->id ?? 8,
                'city' => 'Tiranë',
                'address' => 'Rruga Barrikadave, Qendra "TEG", Kati 2',
                'phone' => '+355 69 678 9012',
                'email' => 'techservice.albania@gmail.com',
                'website' => 'https://techservice.al',
                'status' => 'approved',
            ],
            [
                'title' => 'Zhvillim Website & Aplikacione "WebPro"',
                'description' => 'Dizajn dhe zhvillim profesional i faqeve web, dyqaneve online (e-commerce), dhe aplikacioneve mobile. Portfolio e pasur me projekte të suksesshme. SEO, hosting, mirëmbajtje. Çmime konkurruese dhe afate të respektuara.',
                'category_id' => $categories->where('slug', 'teknologji-dhe-it')->first()->id ?? 8,
                'city' => 'Vlorë',
                'address' => 'Rruga Ismail Qemali, Nr. 45',
                'phone' => '+355 69 789 0123',
                'email' => 'info@webpro.al',
                'website' => 'https://webpro.al',
                'status' => 'approved',
            ],

            // Other Services
            [
                'title' => 'Agjenci Udhëtimi "Albania Tours"',
                'description' => 'Organizim turesh brenda dhe jashtë vendit. Paketa turistike për plazhe, male, qytete historike. Rezervim biletash ajrore dhe hotele. Viza dhe dokumentacion për udhëtim. Çmime të përballueshme dhe shërbim profesional 24/7.',
                'category_id' => $categories->where('slug', 'udhetim-dhe-turizem')->first()->id ?? 8,
                'city' => 'Durrës',
                'address' => 'Rruga Taulantia, Nr. 102',
                'phone' => '+355 69 890 1234',
                'email' => 'albaniatours@outlook.com',
                'website' => 'https://albaniatours.com',
                'status' => 'approved',
            ],
            [
                'title' => 'Stërvitje Private Personale "FitCoach"',
                'description' => 'Trajner personal i certifikuar me eksperiencë 10 vjeçare. Program stërvitjeje të personalizuara sipas qëllimeve tuaja (humbje peshe, fitim muskuj, kondicion fizik). Dietë dhe këshilla nutricionale. Stërvitje në palestër ose në shtëpi.',
                'category_id' => $categories->where('slug', 'bukuri-dhe-mireqenie')->first()->id ?? 6,
                'city' => 'Tiranë',
                'address' => 'Zona e Bllokut (Takim sipas marrëveshjes)',
                'phone' => '+355 69 901 2345',
                'email' => 'fitcoach.trainer@gmail.com',
                'website' => null,
                'status' => 'approved',
            ],
            [
                'title' => 'Fotografë Profesionale "Moments Studio"',
                'description' => 'Shërbime fotografike dhe video profesionale për dasma, fejesa, ditëlindje, ngjarje korporative. Pajisje moderne 4K, drone për pamje ajrore. Montazh profesional dhe album luksoz. Çmime konkurruese dhe punë e garantuar.',
                'category_id' => $categories->where('slug', 'sherbime-te-tjera')->first()->id ?? 8,
                'city' => 'Elbasan',
                'address' => 'Rruga Aqif Pasha, Nr. 67',
                'phone' => '+355 69 012 3456',
                'email' => 'moments.studio@gmail.com',
                'website' => 'https://momentsstudio.al',
                'status' => 'approved',
            ],
        ];

        foreach ($listings as $listingData) {
            Listing::create([
                'title' => $listingData['title'],
                'description' => $listingData['description'],
                'category_id' => $listingData['category_id'],
                'user_id' => $users->random()->id,
                'city' => $listingData['city'],
                'address' => $listingData['address'],
                'phone' => $listingData['phone'],
                'email' => $listingData['email'],
                'website' => $listingData['website'],
                'status' => $listingData['status'],
            ]);
        }

        $this->command->info('20 Albanian business listings created successfully!');
    }
}