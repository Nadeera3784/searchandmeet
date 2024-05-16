<?php

namespace Database\Seeders;

use App\Enums\Agent\AgentRoles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'name' => 'Aka samara',
                'email' => 'aka@digitalmediasolutions.com.au',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => Str::random(10),
                'timezone_id' => 22,
                'country_id' => rand(1, 246),
                'role' => AgentRoles::admin,
                'status' => 1,
            ],
        ];

        foreach ($admins as $admin) {
            User::create($admin);
        }

        $agents = array(
            array('name' => 'Irene Urbano','email' => 'betsay.urbano@gmail.com'),
            array('name' => 'Anj Penaffer','email' => 'anjpenaflor@gmail.com'),
            array('name' => 'Cecile Casupanan','email' => 'cecillecasupanan@tradechina.com'),
            array('name' => 'Susanty Huang','email' => 'susantyhuang03@gmail.com'),
            array('name' => 'Rovil Tejereso','email' => 'rovil@chinadigitalexpo.com'),
            array('name' => 'Francis Neri','email' => 'francisneri@tradechina.com'),
            array('name' => 'Laarni Dawn Tupas','email' => 'dhawnybess@gmail.com'),
            array('name' => 'Kaye Marie Gaudan','email' => 'kayemariegaudan11@gmail.com'),
            array('name' => 'Fanny Jane Vida','email' => 'samjane.vidal2009@gmail.com'),
            array('name' => 'Kristylyn Marian Ferrolino','email' => 'kristylynferrolino31@gmail.com'),
            array('name' => 'Ma. Pauline Undangan','email' => 'pundangan@gmail.com'),
            array('name' => 'Kent Sariel Ferrolino','email' => 'ferrolinokent@gmail.com'),
            array('name' => 'Anne Cruz','email' => 'mrynncrz12@gmail.com'),
            array('name' => 'Karen Ann Recirdo','email' => 'kaarecirdo1989@gmail.com'),
            array('name' => 'Gemma Legaspi','email' => 'Legaspigem@gmail.com'),
            array('name' => 'Dennis Fernandez','email' => 'ampalayagarden@gmail.com'),
            array('name' => 'Glennmark Palma','email' => 'glennmarkpalma@tradechina.com'),
            array('name' => 'Cyrene Gold Lagura','email' => 'cyrenegoldlagura@tradechina.com'),
            array('name' => 'Marjie Vista','email' => 'marjievista@tradechina.com'),
            array('name' => 'Ridmi Bandara','email' => 'ridmi@tradechina.com'),
            array('name' => 'Gaurav Mahla','email' => 'gaurav@chinadigitalexpo.com'),
            array('name' => 'Thishani Pinto','email' => 'thishani@chinadigitalexpo.com'),
            array('name' => 'Arlene Fabreo','email' => 'arlene@chinadigitalexpo.com'),
            array('name' => 'Shruti Trivedi','email' => 'shruti@chinadigitalexpo.com'),
            array('name' => 'Anika Jayasekara','email' => 'anika@chinadigitalexpo.com'),
            array('name' => 'Melissa Espejo','email' => 'melissa@tradechina.com'),
            array('name' => 'Katherine Espejo','email' => 'katherineespejo@tradechina.com'),
            array('name' => 'Magali Sofia Vivares','email' => 'msvivares@tradechina.com'),
            array('name' => 'Sabrina Atala','email' => 'sabrinajezmin@tradechina.com'),
            array('name' => 'Irina Carolina Bogado','email' => 'irina.bogado@tradechina.com'),
            array('name' => 'Paul Emigdio Franco','email' => 'paulemigdio@tradechina.com'),
            array('name' => 'Juan Manuel Calderon','email' => 'juanmanuel@tradechina.com'),
            array('name' => 'Maryori De La Cruz','email' => 'maryori@tradechina.com'),
            array('name' => 'Maximiliano Creatore','email' => 'maximimiliano@tradechina.com'),
            array('name' => 'Katerine Vilcahuaman','email' => 'katerine@chinadigitalexpo.com'),
            array('name' => 'Andrea Edith Castillo Arevalo','email' => 'andrea@chinadigitalexpo.com'),
            array('name' => 'Gelsomino Sofía','email' => 'gelsomino@chinadigitalexpo.com'),
            array('name' => 'María Sol Bourlot','email' => 'maria@chinadigitalexpo.com'),
            array('name' => 'Katia Scheid','email' => 'katiascheid@tradechina.com'),
            array('name' => 'Amany Omari','email' => 'amany@tradechina.com'),
            array('name' => 'Matheus Salome','email' => 'matheussalome@tradechina.com'),
            array('name' => 'Priscila De Andrade','email' => 'prisciladeandrade@tradechina.com'),
            array('name' => 'Fabianne Ykemoto','email' => 'fabianneykemoto@tradechina.com'),
            array('name' => 'Paulo Vinicius','email' => 'paulovinicius@tradechina.com'),
            array('name' => 'Caroline Cardoso','email' => 'carolinecardoso@tradechina.com'),
            array('name' => 'Catarina Machado','email' => 'catarinamachado@tradechina.com'),
            array('name' => 'Aryanne Reis','email' => 'aryannereis@tradechina.com'),
            array('name' => 'Kamylla de Oliveira','email' => 'kamylladeoliveira@tradechina.com'),
            array('name' => 'Jessica Lacorte','email' => 'jessicalacorte@tradechina.com'),
            array('name' => 'Sam Afghahi','email' => 'sam@chinadigitalexpo.com'),
            array('name' => 'Sam bader','email' => 'samar@chinadigitalexpo.com'),
            array('name' => 'Azamjon Makhamadaliev','email' => 'azamjon@chinadigitalexpo.com'),
            array('name' => 'Sajedeh Zarei','email' => ' sajedehchinadigitalexpo.com'),
            array('name' => 'Francis','email' => 'francis@chinadigitalexpo.com'),
            array('name' => 'P & Rafig G','email' => 'rafig@chinadigitalexpo.com'),
            array('name' => 'Marcin Nowak','email' => 'marcin@chinadigitalexpo.com'),
            array('name' => 'Izabela Pantuza','email' => 'izabelapantuza@tradechina.com'),
            array('name' => 'Aleli Fernandez','email' => 'aleli@o2oevents.com'),
        );

        foreach ($agents as $agent) {
            User::create(array_merge($agent, [
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
                'remember_token' => null,
                'timezone_id' => rand(1, 400),
                'country_id' => rand(1, 246),
                'role' => AgentRoles::agent,
                'status' => 1,
            ]));
        }
    }
}
