<?php

namespace Classes;

class Client {
    private string $nom;
    private array $fournisseurs = [];

    public function __construct(string $nom) {
        $this->nom = $nom;
    }

    public function addFournisseur(Fournisseur $fournisseur): void {
        $this->fournisseurs[] = $fournisseur;
    }

    public function fiche(): string {
        $output = "Client: " . $this->nom . "\n";
        $output .= "Fournisseurs:\n";
        foreach ($this->fournisseurs as $fournisseur) {
            $output .= "- " . $fournisseur->getNom() . " (" . $fournisseur->getAddress() . ")\n";
        }
        return $output;
    }
}
