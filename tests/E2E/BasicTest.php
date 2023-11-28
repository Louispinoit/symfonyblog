<?php

namespace app\Tests\E2E;

use Symfony\Component\Panther\PantherTestCase;

class BasicTest extends PantherTestCase
{
    public function testEnvironnementIsOk(): void
    {
        $client = self::createPantherClient(); // Utilise les paramètres par défaut

        $crawler = $client->request('GET', '/');
        $client->takeScreenshot('path/to/screenshot.png');
        // Vérifie si la réponse est un succès

        // Vérifie si le sélecteur 'h1' existe
        $this->assertSelectorExists('h1');

        // Vérifie si le texte attendu est présent dans le sélecteur 'h1'
        $this->assertSelectorTextContains('h1', 'SymfonyBlog : Le blog crée de A à Z avec Symfony');
    }
}