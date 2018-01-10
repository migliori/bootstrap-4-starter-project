<?php
use common\Utils;
use phpformbuilder\database\Mysql;

class CrudTwigExtension extends Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('alert', 'alert'),
            new Twig_SimpleFunction('jeditSelect', 'getJeditSelect'),
            new Twig_SimpleFunction('toBoolean', 'replaceWithBooleen'),
            new Twig_SimpleFunction('toDate', 'formatDate'),
            new Twig_SimpleFunction('toCustomSelectValue', 'getCustomSelectValue')
        );
    }

    public function getName()
    {
        return 'crud';
    }
}

function alert($content, $class)
{
    return Utils::alert($content, $class);
}

function replaceWithBooleen($value)
{
    return Utils::replaceWithBooleen($value);
}

function formatDate($date, $format)
{
    if(empty($date)) {

        return '';
    }
    try {
        $out = '';
        $date = new \DateTime($date);
        $date = $date->format(trim($format));
        $parsed = date_parse_from_format($format, $date);
        if($parsed['warning_count'] < 1 && $parsed['error_count'] < 1) {
            $out = $date;
        } else {
            $out = 'WRONG_DATE_FORMAT';
        }

    } catch(\Exception $e) {

        // echo  $e->getMessage();
       $out = 'WRONG_DATE_FORMAT';
    }

    return $out;
}

/*
$array_values = array(
    from
    from_table
    from_value
    from_field_1
    from_field_2
    custom_values => array(
        name => value,
        ...
    )
)
 */
function getJeditSelect($table, $select_data)
{
    if(!empty($select_data)) {
        // exit(var_dump($select_data));
        $js_code = '';
        foreach($select_data as $field => $array_values) {
            $values = array();
            if($array_values->from == 'from_table' && !empty($array_values->from_value)) {
                $from_value   = $array_values->from_value;
                $from_field_1 = $array_values->from_field_1;
                $from_field_2 = $array_values->from_field_2;
                $from_table   = $array_values->from_table;

                $fields_query = $from_value;
                if($from_field_1 != $from_value) {
                    $fields_query .= ', ' . $from_field_1;
                }
                if(!empty($from_field_2)) {
                    $fields_query .= ', ' . $from_field_2;
                }
                $qry = 'SELECT DISTINCT ' . $fields_query . ' FROM ' . $from_table;
                $db = new Mysql();
                $db->query($qry);
                $db_count = $db->rowCount();
                if(!empty($db_count)) {
                    while (! $db->endOfSeek()) {
                        $row = $db->row();
                        $value = $row->$from_value;
                        if($from_field_1 != $from_value) {
                            $display_value = $row->$from_field_1;
                        } else {
                            $display_value = $row->$from_value;
                        }
                        if(!empty($from_field_2)) {
                            $display_value .= ' ' . $row->$from_field_2;
                        }
                        $values[$value] = $display_value;
                    }
                }
            } else if($array_values->from == 'custom_values' && !empty($array_values->custom_values)) {
                foreach ($array_values->custom_values as $name => $value) {
                    $values[$name] = $value;
                }
            }
            if(!empty($values)) {
                $js_code .= '    $(\'.jedit-select[data-field="' . $field . '"]\').editable(\'' . ADMIN_URL . 'inc/jedit.php\', {' . "\n";
                $js_code .= '        cssclass      : \'form-inline\',' . "\n";
                $js_code .= '        type          : \'select\',' . "\n";
                $js_code .= '        data          : \'' . json_encode($values)  . '\',' . "\n";
                $js_code .= '        indicator     : \'<img src="' . ADMIN_URL . 'assets/images/ajax-loader.gif" alt="' . RECORDING . '">\',' . "\n";
                $js_code .= '        cancel        : \'' . CANCEL . '\',' . "\n";
                $js_code .= '        submit        : \'' . OK . '\',' . "\n";
                $js_code .= '        onsubmit: function() {' . "\n";
                $js_code .= '            $(this).closest(\'[class^="jedit-"]\').removeClass(\'active\');' . "\n";
                $js_code .= '        },' . "\n";
                $js_code .= '        onreset: function() {' . "\n";
                $js_code .= '            $(this).closest(\'[class^="jedit-"]\').removeClass(\'active\');' . "\n";
                $js_code .= '        },' . "\n";
                $js_code .= '        callback      : function (value, settings) {' . "\n";
                $js_code .= '            $(this).html(value);' . "\n";
                $js_code .= '        }' . "\n";
                $js_code .= '    });' . " \n\n";
            }
        }

        return $js_code;
    }
}

/**
 * get display value from real registered value
 * @param  string $table
 * @param  string $fieldname
 * @param  string $value     registered value
 * @return string            display value
 */
function getCustomSelectValue($table, $fieldname, $value)
{
    $json = file_get_contents(ADMIN_DIR . 'crud-data/' . $table . '-select-data.json');
    $select_data = json_decode($json, true);
    $values = $select_data[$fieldname]['custom_values'];
    foreach($values as $display_value => $custom_value) {
        if($custom_value == $value) {

            return $display_value;
        }
    }

    return false;
}



/*
$('.jedit-select').editable('inc/jedit.php', {
    cssclass: 'form-inline',
    type      : 'select',
    <?php
    /*$array['value 1'] =  'option 1';
    $array['value 2'] =  'option 2';
    $array['value 3'] =  'option 3';
    $array['selected'] =  'value 2';
    ?>
    data       : <?php // echo json_encode($array); ?>,
    indicator     : '<img src="images/ajax-loader.gif" alt="enregistrement ...">',
    tooltip       : 'Cliquer pour modifier ...',
    cancel        : 'ANNULER',
    submit        : 'OK',
    onblur: 'ignore',
    callback     : function (value, settings) {
        $(this).html(settings.data[value]);
    }
});*/