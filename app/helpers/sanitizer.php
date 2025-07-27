<?php
namespace App\Helpers;

require_once __DIR__ . '/../../vendor/autoload.php';

use HTMLPurifier;
use HTMLPurifier_Config;

class Sanitizer
{
    public static function cleanHTML($dirtyHTML)
    {
        $config = HTMLPurifier_Config::createDefault();

        // Asigna un ID de definición para permitir extensiones
        $config->set('HTML.DefinitionID', 'custom_sanitizer');
        $config->set('HTML.DefinitionRev', 1);

        // Permitir etiquetas y atributos
        $config->set(
            'HTML.Allowed',
            'p,strong,em,u,ul,ol,li,br,h1,h2,h3,blockquote,code,pre,' .
            'a[href|target|rel],img[src|alt|width|height],' .
            'span[style],div[style]'
        );

        // Permitir propiedades CSS inline
        $config->set('CSS.AllowedProperties', [
            'color',
            'background-color',
            'font-weight',
            'font-style',
            'text-decoration',
            'text-align',
            'font-size'
        ]);

        // Permitir esquemas de URL
        $config->set('URI.AllowedSchemes', [
            'http' => true,
            'https' => true,
            'mailto' => true
        ]);

        // Permitir target="_blank"
        $config->set('Attr.AllowedFrameTargets', ['_blank']);

        // Extiende definición solo si se puede
        if ($def = $config->maybeGetRawHTMLDefinition()) {
            if (!isset($def->info['span'])) {
                $def->addElement('span', 'Inline', 'Inline', 'Common', ['style']);
            }
            if (!isset($def->info['div'])) {
                $def->addElement('div', 'Block', 'Flow', 'Common', ['style']);
            }
        }

        $purifier = new HTMLPurifier($config);

        return $purifier->purify($dirtyHTML);
    }


}




