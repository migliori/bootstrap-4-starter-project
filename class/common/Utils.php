<?php
namespace common;

use phpformbuilder\database\Mysql;

class Utils
{

    /* Components */

    public static function alert($content, $class)
    {
        $alert = '<div class="alert alert-dismissible ' . $class . '"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button><span class="text-semibold">' . $content . '</span></div>' . "\n";

        return $alert;
    }

    /**
     * @param  string $title            card title
     * @param  string $classname        Boootstrap card class (bg-success, bg-primary, bg-warning, bg-danger)
     * @param  string $heading_elements separated comma list : collapse, close
     */
    public static function startCard($title, $classname, $heading_elements = '', $has_body = true)
    {
        $start_card = '<div class="card ' . $classname . ' mb-4">' . "\n";
        if (!empty($title)) {
            $start_card .= '    <div class="card-header">' . $title . "\n";
            if (!empty($heading_elements)) {
                $heading_elements = array_map('trim', explode(',', $heading_elements));
                $start_card .= '        <div class="heading-elements">' . "\n";
                if (in_array('collapse', $heading_elements)) {
                    $random_id = uniqid();
                    $start_card .= '               <a class="dropdown-toggle" data-toggle="collapse" href="#' . $random_id . '" role="button" aria-expanded="false" aria-controls="' . $random_id . '"></a>' . "\n";
                }
                if (in_array('close', $heading_elements)) {
                    $start_card .= '               <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . "\n";
                }
                $start_card .= '           </ul>' . "\n";
                $start_card .= '        </div>' . "\n";
            }
            $start_card .= '    </div>' . "\n";
        }
        if ($has_body === true) {
            $collapsed = '';
            if (preg_match('`card-collapsed`', $classname)) {
                $collapsed = ' collapse';
            }
            $start_card .= '    <div class="card-body' . $collapsed . '"';
            if (isset($random_id)) {
                $start_card .= ' id="' . $random_id . '"';
            }
            $start_card .= '>' . "\n";
        }

        return $start_card;
    }

    public static function endCard($has_body = true)
    {
        $end_card = '';
        if ($has_body === true) {
            $end_card .= '    </div>' . "\n";
        }
        $end_card .= '</div>' . "\n";

        return $end_card;
    }

    /**
     * @param  string $title            panel title
     * @param  string $classname        Boootstrap panel class (bg-success, bg-primary, bg-warning, bg-danger)
     * @param  string $heading_elements separated comma list : collapse, reload, close
     * @param  string $content          panel body html content
     */
    public static function alertCard($title, $classname, $heading_elements = '', $content = '')
    {
        if (!empty($content)) {
            $has_body = true;
        } else {
            $has_body = false;
        }
        $card = self::startCard($title, $classname, $heading_elements, $has_body);
        $card .= $content;
        $card .= self::endCard($has_body);

        return $card;
    }

    /* Numbers */

    public static function formatNumber($nbre)
    {
        $nbre = number_format($nbre, 2, '.', ' ');

        /* on supprime '.00' à la fin si nécessaire */

        if (preg_match('`([0-9\s]+)\.00$`', $nbre, $out)) {
            $nbre = $out[1];
        }

        return $nbre;
    }

    public static function multiple($i, $nb)
    {
        $calcul = (round($i / $nb) - ($i / $nb));
        if ($calcul == "0") {
            return true; // $i est multiple de $nb
        } else {
            return false; // $i n'est pas multiple de $nb
        }
    }

    public static function pair($nb)
    {
        $calcul = (round($nb / 2) - ($nb / 2));
        if ($calcul == "0") {
            return true; // $nb est pair
        } else {
            return false; // $nb n'est pas impair
        }
    }

    /* Dates */

    public static function dateUsToFr($date)
    {
        if (SITE_LANG == 'en') {
            return $date;
        }
        sscanf($date, "%4s-%2s-%2s", $y, $mo, $d);

        return $d.'-'.$mo.'-'.$y;
    }

    public static function dateTimeToDate($dateTime)
    {
        $retour = preg_replace('/([0-9]{4}-[0-9]{2}-[0-9]{2}) [0-9]{2}:[0-9]{2}:[0-9]{2}/', '$1', $dateTime);

        return $retour;
    }

    public static function dateTimeToTime($dateTime)
    {
        $retour = preg_replace('/[0-9]{4}-[0-9]{2}-[0-9]{2} ([0-9]{2}:[0-9]{2}:[0-9]{2})/', '$1', $dateTime);

        return $retour;
    }

    public static function dateTimeToDateText($date_time, $lang = 'fr') // 2014-09-21 => dimanche 21 septembre 2014 OU sunday 21 september
    {
        $date = new \DateTime($date_time);
        if ($lang == 'fr') {
            $jour_semaine = self::traduireJour($date->format('N')); // N = jour de la semaine numérique (1 = lundi)
            $numero_jour = $date->format('j'); // Jour du mois sans les zéros initiaux
            $mois = self::traduireMois($date->format('n')); // Mois sans les zéros initiaux
            $annee = $date->format('Y');

            return $jour_semaine . ' ' . $numero_jour . ' ' . $mois . ' ' . $annee;
        } else { // en
            return $date->format('l j F');
        }
    }

    public static function traduireJour($numero)
    {
        $tabJour = array(1 => 'lundi', 2 => 'mardi', 3 => 'mercredi', 4 => 'jeudi', 5 => 'vendredi', 6 => 'samedi', 7 => 'dimanche');

        return $tabJour[(int) $numero]; // (int) supprime les zéros initiaux
    }

    public static function traduireMois($numero)
    {
    // pour les répertoires des factures, pas de multilingue
        $tabMois = array(1 => 'janvier', 2 => 'fevrier', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'aout', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'decembre');

        return $tabMois[(int) $numero]; // (int) supprime les zéros initiaux
    }

    public static function addYear()
    {
        $format = 'Y-m-d';
        $aujourdhui = date($format);
        $tab = explode('-', $aujourdhui);
        $tab[0] = $tab[0]+1;
        $dansUnAn = $tab[0] . '-' . $tab[1] . '-' . $tab[2];

        return $dansUnAn;
    }

    public static function translateMonth($number)
    {
        // pour les répertoires des factures, pas de multilingue
        $tabMois = array(1 => 'janvier', 2 => 'fevrier', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'aout', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'decembre');

        return $tabMois[(int) $number]; // (int) supprime les zéros initiaux
    }

    /* Strings */

    public static function sanitize($var)
    {
        $ancienNom = trim($var);
        $charset = 'utf-8';
        $nouveauNom = htmlentities($ancienNom, ENT_NOQUOTES, $charset);
        $nouveauNom = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $nouveauNom);
        $nouveauNom = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $nouveauNom);    // pour les ligatures e.g. '&oelig;'
        $nouveauNom = preg_replace('#\&[^;]+\;#', '', $nouveauNom);    // supprime les autres caractères
        $nouveauNom = preg_replace('`[ &~"#{( \'\[|\\^@)\]=}$¤*µ%,;:!?/§.]+`', '-', $nouveauNom);
        while (preg_match('`--`', $nouveauNom)) {
            $nouveauNom = preg_replace('`--`', '-', $nouveauNom);
        }
        $nouveauNom = trim(strtolower($nouveauNom), '-');

        return $nouveauNom;
    }

    public static function formatName($var) // for files, keep extension dot
    {
        $ancienNom = trim($var);
        $charset = 'utf-8';
        $nouveauNom = htmlentities($ancienNom, ENT_NOQUOTES, $charset);
        $nouveauNom = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml)\;#', '\1', $nouveauNom);
        $nouveauNom = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $nouveauNom);    // pour les ligatures e.g. '&oelig;'
        $nouveauNom = preg_replace('#\&[^;]+\;#', '', $nouveauNom);    // supprime les autres caractères
        $nouveauNom = preg_replace('`[ &~"#{( \'\[|\\^@)\]=}$¤*µ%,;:!?/§]+`', '-', $nouveauNom);
        while (preg_match('`--`', $nouveauNom)) {
            $nouveauNom = preg_replace('`--`', '-', $nouveauNom);
        }
        $nouveauNom = strtolower($nouveauNom);

        return $nouveauNom;
    }

    public static function hexaEncode($chaine) // encode email addresses
    {
        $longueur=strlen($chaine);
        $retour = '';
        for ($i=0; $i<$longueur; $i++) {
            $retour .= '&#x' . bin2hex(substr($chaine, $i, 1)) . ';';
        }

        return $retour;
    }

    /**
     * transform a lowercase string with underscores or hyphens to camelCase
     * @param  [type] $str
     * @param  array  $noStrip non-spacing additional characters
     * @return upperCamelCased string
     */
    public static function camelCase($str, array $noStrip = array())
    {
        $str = self::sanitize($str);
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-zA-Z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);

        return lcfirst($str);
    }

    public static function replaceAccents($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

        return $str;
    }

    public static function remplacerGuillemets($str = '', $addSlashes = true) // $str = chaine de remplacement
    {
        if ($addSlashes == true) {
            return addslashes(str_replace('"', '', $str));
        } else {
            return str_replace('"', '', $str);
        }
    }

    public static function truncateString($chaine, $nbreDeCaracteres)
    {
        if (strlen($chaine) <= $nbreDeCaracteres) {
            return $chaine;
        }
        $texte = wordwrap($chaine, $nbreDeCaracteres, ' coupure '); //on ajoute le mot 'coupure' après le dernier mot inclus jusqu'à n caractères,
        $pos = strpos($texte, ' coupure'); //on récupère la position du mot 'coupure'
        $texte = substr($texte, 0, $pos); //on coupe ce qui est après

        return $texte . $etc;
    }

    public static function icomoon($icon, $additional_class = '')
    {
        return '<svg class="icon ' . $icon . ' ' . $additional_class . '"><use xlink:href="' . ASSETS_URL . 'images/symbol-defs.svg#' . $icon . '"></use></svg>';
    }

    /* Data */

    public static function replaceWithBooleen($value)
    {
        if (!empty($value)) {
            return '<i class="' . ICON_CHECKMARK . ' icon-lg text-success"></i>';
        } else {
            return '<i class="' . ICON_CANCEL . ' icon-md text-danger"></i>';
        }
    }

    /* Attributes & classes */

    /**
    * Returns linearised attributes.
    * @param string $attr The element attributes
    * @return string Linearised attributes
    *                Exemple : size=30, required=required => size="30" required="required"
    */
    public static function getAttributes($attr)
    {
        if (empty($attr)) {
            return '';
        } else {
            $attr = preg_replace('`\s*=\s*`', '="', $attr) .  '"'; // adding quotes
            $attr = preg_replace_callback('`(.){1},\s*`', array('self', 'replaceCallback'), $attr);

            return ' ' . $attr;
        }
    }

    /**
    * Add new class to $attr.(see options).
    *
    * @param string $newclassname The new class
    * @param string $attr The element attributes
    * @return string $attr including new class.
    */
    public static function addClass($newclassname, $attr)
    {
        if (preg_match('`class="([^"]+)"`', $attr, $out)) {
            // if $attr already contains a class we keep it and add newclassname
            $new_class =  'class="' . $out[1] . ' ' . $newclassname . '"';

            return preg_replace('`class="([^"]+)"`', $new_class, $attr);
        } else {
            // if $attr contains no class we add elementClass
            return $attr . ' class="' . $newclassname . '"';
        }
    }

    /**
    * Used for getAttributes regex.
    */
    protected static function replaceCallback($motif)
    {
        /* if there's no antislash before the comma */
        if (preg_match('`[^\\\]`', $motif[1])) {
            return $motif[1] . '" ';
        } else {
            return ',';
        }
    }

    /* Arrays */

    /**
     * Look for a value in an associative array inside an indexed array
     * @param  array  $indexed_array
     * @param  string $key           key to look for
     * @param  string $value         value to match key
     * @return array                 indexes found in indexed array
     */
    public static function findInIndexedArray($indexed_array, $key, $value)
    {
        $index_array = array();
        foreach ($indexed_array as $index => $assoc_array) {
            if ($assoc_array[$key] === $value) {
                $index_array[] = $index;
            }
        }

        return $index_array;
    }


    /* =============================================
        META + SITE FUNCTIONS
    ============================================= */

    /**
     * build a h1 title
     * @param  Array $match Altorouter match
     * @return String       the H1 title
     */
    public static function buildPageTitle($match)
    {
        $h1 = '';
        $h2 = '';
        $rubrique = '';
        if (isset($match['params']['rubrique']) && !empty($match['params']['rubrique'])) {
            $rubrique = $match['params']['rubrique'];
        }
        if (isset($match['params']['categorie']) && !empty($match['params']['categorie'])) {
            $h1 .= $_SESSION['categorie_nom'];

            $cat = $match['params']['categorie'];

            // sc list
            if (!isset($match['params']['sc'])) {
                $tableau_sc = $_SESSION['tableau_sc'];
                if (isset($tableau_sc->$rubrique)) {
                    $sc_count = $tableau_sc->$rubrique->$cat->sc_count;
                    if ($sc_count > 0) {
                        $sc_list = '';
                        $length_exceeds = false;
                        for ($i=0; $i < $sc_count; $i++) {
                            if (strlen($sc_list) <= 100) {
                                $sc_list .= $tableau_sc->$rubrique->$cat->sc_nom[$i] . ', ';
                            } else {
                                $length_exceeds = true;
                            }
                        }
                        $h1 .= ': ' . rtrim($sc_list, ', ');
                        if ($length_exceeds === true) {
                            $h1 .= ', ...';
                        }
                    }
                }
            } else {
                $h1 .= ': ' . $_SESSION['sc_nom'];
            }

            if (!empty($rubrique)) {
                $h2 = '<a href="' . BASE_URL . $_SESSION['rubrique'] . '" title="' . $_SESSION['rubrique_nom'] . '" class="small small-caps text-muted d-block">' . $_SESSION['rubrique_nom'] . '</a>';
            }
        } elseif ($match['name'] == 'articles-recherche') {
            $h1 = lang('resultats-de-votre-recherche');
        } elseif ($match['name'] == 'wishlist') {
            $h1 = lang('ma-wishlist');
        } else {
            $h1 = $_SESSION['rubrique_nom'];
        }

        if (isset($match['params']['page']) && !empty($match['params']['page'])) {
            $h1 .= '<small class="ml-3">page ' . ltrim($match['params']['page'], 'p') . '</small>';
        }

        return array('h1' => $h1, 'h2' => $h2);
    }
}
