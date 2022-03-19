<?php
function DayIndo()
{
    return array(1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu');
}

function getMonthIndo()
{
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    return $bulan;
}

function DateToDay($date)
{
    $HariIndo = array("Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu");
    $hari = date('N', strtotime($date));
    $result = $HariIndo[(int) $hari - 1];
    return ($result);
}

function DateToIndo($date)
{
    if ($date && $date != "0000-00-00") {
        $BulanIndo = array(
            "Januari", "Februari", "Maret",
            "April", "Mei", "Juni",
            "Juli", "Agustus", "September",
            "Oktober", "November", "Desember"
        );

        $tahun = date('Y', strtotime($date));
        $bulan = date('n', strtotime($date));
        $tgl = date('d', strtotime($date));

        $result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
    } else {
        $result = NULL;
    }

    return ($result);
}

function DateTimeToIndo($date)
{
    if ($date && $date != "0000-00-00") {
        $BulanIndo = array(
            "Januari", "Februari", "Maret",
            "April", "Mei", "Juni",
            "Juli", "Agustus", "September",
            "Oktober", "November", "Desember"
        );

        $tahun = date('Y', strtotime($date));
        $bulan = date('n', strtotime($date));
        $tgl = date('d', strtotime($date));
        $time = date('H:i:s', strtotime($date));

        $result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun . " " . $time;
    } else {
        $result = NULL;
    }

    return ($result);
}

function rupiahFormat($price, $decimal = 0)
{
    return "Rp. " . number_format((float) preg_replace('/[^0-9]/', '', $price), $decimal);
}

function feeType($type)
{
    $data = [1 => 'flat', 2 => 'procentage'];
    return $data[$type];
}
function concatDayAndDate($date)
{
    if (!empty($date) && $date != "0000-00-00") {
        return DateToDay($date) . ', ' . DateToIndo($date);
    } else {
        return '-';
    }
}

function how_to($channel_code)
{
    $how_to = [
        '0' => 'payment.slice.mandiri',
        '08' => 'payment.slice.mandiri',
        '29' => 'payment.slice.bca',
        '33' => 'payment.slice.danamon',
        '34' => 'payment.slice.bri',
        '35' => 'payment.slice.alfa',
        '36' => 'payment.slice.permata',
        '38' => 'payment.slice.bni',
    ];

    return (array_key_exists($channel_code, $how_to)) ? $how_to[$channel_code] : $how_to[0];
}

function idrFormat($price, $decimal = 2)
{
    return "IDR.&nbsp;" . number_format((float) preg_replace('/[^0-9]/', '', $price), $decimal);
}

function isDev()
{
    return (getenv("APP_ENV") == "local") ? TRUE : FALSE;
}

function dateRange($start, $end, $step = '+1 day', $format = 'Y-m-d')
{

    $dates = array();
    $current = strtotime($start);
    $last = strtotime($end);

    while ($current <= $last) {

        $dates[] = date($format, $current);
        $current = strtotime($step, $current);
    }

    return $dates;
}

function randromNumber($length = 4)
{
    return str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
}

function parse_xml_soap_mdr($string)
{
    $xml = @simplexml_load_string($string);
    
    if ($string != '') {
        $request = json_decode(json_encode($xml->xpath('//soapenv:Body')[0]));

        return $request;
    }
    
    return false;
}

function getComponentType()
{
    $component_type = array(
        1 => 'Profile', 'News', 'Product', 'Carrier', 'Contact', 'External Link'
    );

    return $component_type;
}

function getArticleType()
{
    $article_type = array(
        1 => 'Profile', 'News', 'Product', 'Carrier'
    );

    return $article_type;
}

function detailText($text, $limit)
{
    $text = strip_tags($text);

    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

function getDateSlug($date)
{
    $date_slug = date('Y/m/',strtotime($date));
    return $date_slug;
}
