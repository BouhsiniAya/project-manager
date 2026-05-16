<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// 1. Create Ghizlane if she doesn't exist (with the right password)
$ghizlane = User::where('email', 'admin2@test.com')->first();
if (!$ghizlane) {
    $ghizlane = User::create([
        'name' => 'Ghizlane',
        'email' => 'admin2@test.com',
        'password' => bcrypt('password123'),
        'role' => 'admin',
    ]);
} else {
    $ghizlane->update(['password' => bcrypt('password123')]);
}

// 2. Update job titles and profiles
$data = [
    'Alice Martin' => [
        'job_title' => 'Développeur Full-stack',
        'username' => 'alice_dev',
        'location' => 'Paris, France',
        'short_bio' => 'Passionnée par le web et les nouvelles technologies.'
    ],
    'Jean Dupont' => [
        'job_title' => 'Designer UI/UX',
        'username' => 'jean_design',
        'location' => 'Lyon, France',
        'short_bio' => 'Créateur d\'interfaces intuitives et élégantes.'
    ],
    'Thomas Petit' => [
        'job_title' => 'Développeur Backend',
        'username' => 'thomas_back',
        'location' => 'Bordeaux, France',
        'short_bio' => 'Expert en architecture serveur et bases de données.'
    ],
    'Sophie Bernard' => [
        'job_title' => 'Chef de projet',
        'username' => 'sophie_pm',
        'location' => 'Nantes, France',
        'short_bio' => 'Spécialiste de la gestion agile et du suivi d\'équipe.'
    ],
    'Amine' => [
        'job_title' => 'Analyste QA',
        'username' => 'amine_qa',
        'location' => 'Casablanca, Maroc',
        'short_bio' => 'Expert en tests automatisés.'
    ],
    'Kenza' => [
        'job_title' => 'Développeuse Mobile',
        'username' => 'kenza_dev',
        'location' => 'Rabat, Maroc',
        'short_bio' => 'Spécialiste iOS et Android.'
    ],
    'Ahmed' => [
        'job_title' => 'Développeur Mobile',
        'username' => 'ahmed_dev',
        'location' => 'Marrakech, Maroc',
        'short_bio' => 'Développeur Flutter passionné.'
    ],
    'Imane' => [
        'job_title' => 'Ingénieur DevOps',
        'username' => 'imane_ops',
        'location' => 'Tanger, Maroc',
        'short_bio' => 'Automatisation et Cloud.'
    ],
    'Ghizlane' => [
        'job_title' => 'Directrice de Projet',
        'location' => 'Fès, Maroc',
        'short_bio' => 'Supervise l\'ensemble de la plateforme Planify.'
    ]
];

foreach ($data as $name => $fields) {
    $user = User::where('name', 'like', '%' . $name . '%')->first();
    if ($user) {
        $user->update($fields);
        echo "Updated $name\n";
    }
}
