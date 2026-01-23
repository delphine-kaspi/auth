<?php

namespace App\Service;

use App\Repository\ArtisteRepository;

class ParameterService
{

    public function __construct(private ArtisteRepository $artisteRepository)
    {
    }

    public function getArtistes(): array
    {
        return $this->artisteRepository->findAll();
        // return $this->artisteRepository->findBy(['property' => 'value']);
        // return $this->artisteRepository->findBy(['activation' => true ]);
    }

}