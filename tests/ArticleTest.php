<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\Slugger;

class ArticleTest extends TestCase
{
    public function testSlugTiret(): void
    {
        $slug = new Slugger();
        $titre = "ahah le super test";
        $titreSlug = $slug->slugify($titre);
        $this->assertTrue($titre, 'ahah-le-super-test');
    }

    public function testSlugDelimiter(): void
    {
        $slug = new Slugger();
        $titre = "ahah le super test";
        $titreSlug = $slug->slugify($titre,'_');
        $this->assertNotEquals($titre, 'ahah-le-super-test');
    }
}
