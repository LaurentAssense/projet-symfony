<?php

namespace Classes;

class Fournisseur {
    private string $nom;
    private string $address;

    public function __construct(string $nom, string $address) {
        $this->nom = $nom;
        $this->address = $address;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getAddress(): string {
        return $this->address;
    }
}
