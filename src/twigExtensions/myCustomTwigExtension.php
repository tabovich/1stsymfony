<?php

namespace App\TwigExtensions;

use Twig\Extension\AbstractExtension as AbstractExtension;
use Twig\TwigFilter;

class MyTwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('defaultImage', [$this, 'defaultImage'])
        ];
    }
// la fonction defaultImage vérifie que si ce que l'on envoie est une valeur nulle, elle renvoie une image par defaut, sinon elle renvoit $path qui est l'image envoyé
    public function defaultImage(string $path): string {
        if (strlen(trim($path)) == 0) {
            return 'as.png';
        }
        return $path;
    }

}