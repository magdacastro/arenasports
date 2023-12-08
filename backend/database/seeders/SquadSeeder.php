<?php

namespace Database\Seeders;

use App\Models\Squad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SquadSeeder extends Seeder
{
    private array $data = [
        [
            "image" => "https://images.pexels.com/photos/11644798/pexels-photo-11644798.jpeg?auto=compress&cs=tinysrgb&w=600",
            "category" => "Futebol",
        ],
        [
            "image" => "https://images.pexels.com/photos/8858493/pexels-photo-8858493.jpeg?auto=compress&cs=tinysrgb&w=600",
            "category" => "Basquete",
        ],
        [
            "image" => "https://images.pexels.com/photos/17460018/pexels-photo-17460018/free-photo-of-exercicio-praticando-atividade-fisica-partida-jogo.jpeg?auto=compress&cs=tinysrgb&w=600",
            "category" => "Vôlei",
        ],
        [
            "image" => "https://images.pexels.com/photos/16639180/pexels-photo-16639180/free-photo-of-vista-traseira-tribunal-corte-de-justica-quadra.jpeg?auto=compress&cs=tinysrgb&w=600",
            "category" => "Tênis",
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect($this->data)->map(function (array $data): Squad {
            return Squad::create($data);
        });
    }
}
