<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UtilLibrary {

    public function __construct()
    {
    }

    public function isValidEmail($str)
    {
        return preg_match("/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/", $str);
    }

    // url
    public function isValidURL($str) 
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $str);
    }

    //mac address
    public function isMacAddress($str)
    {
        return preg_match("/([a-fA-F0-9]{2}[:|\-]?){6}/", $str);
    }

    // alpha only
    public function isAlpha($str) 
    {
        return preg_match("/[^a-zA-Z]*$/",$str);
    }

    // alpha plus space
    public function isAlphaSpace($str) 
    {
        return preg_match("/[^a-zA-Z\s]*$/",$str);
    }

    // alpha plus space plus chars
    public function isAlphaSpaceChars($str) 
    {
        return preg_match("/[^a-zA-Z\s\.\%\-]*$/",$str);
    }

    // numbers only
    public function isNumeric($str) 
    {
        return preg_match("/^[0-9]*$/",$str);
    }

    // alpha and numbers
    public function isAlphaNumeric($str) 
    {
        return preg_match('/^[a-zA-Z0-9]*$/',$str);
    }

    // alpha, numbers and space
    public function isAlphaNumericSpace($str) 
    {
        return preg_match('/^[a-zA-Z0-9\s]*$/',$str);
    }

    // alpha with ._- between
    public function isAlphaDash($str) 
    {
        return preg_match('/^[a-zA-Z0-9]+([._-][a-zA-Z0-9]+)*$/',$str);
    }

    // alpha with ._-!
    public function isName($str) 
    {
        return preg_match('/^[a-zA-Z0-9.\'\-\$]*$/',$str);
    }

    // alpha with ._-!
    public function isLabel($str) 
    {
        return preg_match('/^[a-zA-Z0-9.\s\'\-\$]*$/',$str);
    }

    // alpha with ._-!
    public function isTableName($str) 
    {
        return preg_match('/^[a-z0-9_]*$/',$str);
    }

    // alpha with ._-!
    public function isAddress($str) 
    {
        return preg_match('/^[#a-zA-Z0-9.\s\'\-\$]*$/',$str);
    }

    // alpha with ._-!
    public function isUserName($str) 
    {
        return preg_match('/^[a-zA-Z0-9!.\-_#\$]*$/',$str);
    }

    // alpha with !-_#$^*
    public function isPassword($str) 
    {
        return preg_match('/^[a-zA-Z0-9!-_#\$^\*]*$/',$str);
    }

    // urlpath
    public function isAlphaPath($str) 
    {
        return preg_match('/^[a-zA-Z0-9\/]*$/',$str);
    }

    // alpha, numbers, -_- and space
    public function isAlphaDashSpace($str) 
    {
        return preg_match('/^[a-zA-Z0-9\s]+([._-][a-zA-Z0-9\s]+)*$/',$str);
    }

    public function isCopyright($str) 
    {
        return preg_match('/^[a-zA-Z0-9\s&;,\._-]*$/',htmlentities($str));
    }
    
    public function isZipcode($str) 
    {
        return preg_match("/^[0-9]{5}$/", $str);
    }

    public function isGUID($str)
    {
        return preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/', $str); 
    }

    public function isNameLessThan($str, $length)
    {
        if (!$this->isName($str)) {
            return false;
        }
        return strlen($str)<=$length;
    }

    public function isLabelMoreThan($str, $length)
    {
        if (!$this->isLabel($str)) {
            return false;
        }
        return strlen($str) >= $length;
    }

    public function isLabelLessThan($str, $length)
    {
        if (!$this->isLabel($str)) {
            return false;
        }
        return strlen($str)<=$length;
    }

    public function isTableNameMoreThan($str, $length)
    {
        if (!$this->isTableName($str)) {
            return false;
        }
        return strlen($str) >= $length;
    }

    public function isTableNameLessThan($str, $length)
    {
        if (!$this->isTableName($str)) {
            return false;
        }
        return strlen($str)<=$length;
    }

    public function isDecimal($str, $integer, $decimal)
    {
        $regex = "^\d{0,".$integer."}(\.\d{0,".$decimal."})?$";
        return preg_match("/$regex/", $str);
    }

    public function isNumericLessThan($str, $value)
    {
        if (!$this->isNumeric($str)) {
            return false;
        }
        return ((int)$str < (int)$value);
    }

    public function isPhoneNumber($str)
    {
        return preg_match('/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/');
    }

    public function isDate($str)
    {
        return preg_match('/^[0-9]{4}(\-|\/)[0-9]{1,2}(\-|\/)[0-9]{1,2}(|\s+[0-9]{1,2}(|:[0-9]{1,2}(|:[0-9]{1,2})))$/', $str);
    }

    public function isValidDate($str)
    {
        return date_create($str);
    }

    /**
     * if array has keys (assoc), then it will return true
     * @param  [type]  $arr [description]
     * @return boolean      [description]
     */
    public function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    // format any date to American (0) or European (1) format and 24 hour time format (1) or AM/PM (0)
    public function fmtDateTime($date,$dfmt,$tfmt)
    {
        $mydate = date_create($date);
        if ($dfmt && $tfmt) return date_format($mydate, 'd/m/Y - H:i');
        if ($dfmt && !$tfmt) return date_format($mydate, 'd/m/Y - h:i A');
        if (!$dfmt && $tfmt) return date_format($mydate, 'm/d/Y - H:i');
        if (!$dfmt && !$tfmt) return date_format($mydate, 'm/d/Y - h:i A');
    }

    // format any date to American (0) or European (1) format
    public function fmtDate($date,$fmt) 
    {
        $mydate=date_create($date);
        if ($fmt) return date_format($mydate, 'd/m/Y');
        else return date_format($mydate, 'm/d/Y');
    }

    // format any time to American (0) or European (1) format
    public function fmtTime($time,$fmt)
    {
        $mytime=date_create($time);
        if ($fmt) return date_format($mytime, 'H:i');
        else return date_format($mytime, 'h:i A');
    }

    // returns us or international dates as yyyy-mm-dd for database insertion
    public function unfmtDate($date,$fmt=0)
    {
        // convert from European format before conversion
        if ($fmt) $date = substr($date,3,2)."/".substr($date,0,2)."/".substr($date,6);

        $mydate = date('Y-m-d',strtotime($date));
        return $mydate;
    }

    // returns any time string as 24-hour time
    public function unfmtTime($time) 
    {
        $mytime = date('H:i:s',strtotime($time));
        return $mytime;
    }

    public function unfmtDateTime($datetime, $fmt=0)
    {
        $splitPos = strpos($datetime, ' ');
        $date = $this->unfmtDate(substr($datetime, 0, $splitPos), $fmt);
        $time = $this->unfmtTime(substr($datetime, $splitPos + 1));
        return $date . ' ' . $time;
    }

    public function getGmt($datetimestr = null, $tz = null)
    {
        if (is_null($datetimestr)) {
            return gmdate('Y-m-d H:i:s', time());
        }

        if ($datetimestr && is_null($tz)) {
            return gmdate('Y-m-d H:i:s', strtotime($datetimestr));
        }

        if ($datetimestr && $tz) {
            $temp = date_create($datetimestr, timezone_open($tz));
            return gmdate('Y-m-d H:i:s', strtotime(date_format($temp, 'Y-m-d H:i:s')));
        }
    }

    /**
     * This will convert all the keys into camelcase (for working with models)
     * @param  [type] $array [description]
     * @return [type]        [description]
     */
    public function camelizeArrayKeys($array)
    {
        $result = [];
        foreach ($array as $key => $value) {
            $newKey = $this->camelize($key);
            if (is_array($value)) {
                $value = $this->camelizeArrayKeys($value);
            }

            $result[$newKey] = $value;
        }

        return $result;
    }

    // takes in under_score_string and returns underScoreString
    public function camelize($word, $needle = '_', $lcfirst = true)
    {
        $str = lcfirst(
            implode(
                '',
                array_map(
                    'ucfirst',
                    array_map(
                        'strtolower',
                        explode($needle, $word)
                    )
                )
            )
        );
        if ($lcfirst) {
            $str = lcfirst($str);
        } else {
            $str = ucfirst($str);
        }
        return $str;
    }

    // returns a random string of upper/lower and numbers
    public function generateFilename($length=12) 
    {
        $chars="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $fn = "";
        for($i=0; $i<$length; $i++) 
        { 
            $fn .= $chars{mt_rand(0,strlen($chars)-1)};
        }
        return $fn;
    }

    /**    
    *    Returns the offset from the origin timezone to the remote timezone, in seconds.
    *    @param $remote_tz;
    *    @param $origin_tz; If null the servers current timezone is used as the origin.
    *    @return int;
    */
    function get_timezone_offset($remote_tz, $origin_tz = null) {
        if($origin_tz === null) {
            if(!is_string($origin_tz = date_default_timezone_get())) {
                return false; // A UTC timestamp was returned -- bail out!
            }
        }
        $origin_dtz = new DateTimeZone($origin_tz);
        $remote_dtz = new DateTimeZone($remote_tz);
        $origin_dt = new DateTime("now", $origin_dtz);
        $remote_dt = new DateTime("now", $remote_dtz);
        $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
        return $offset;
    }

    /**
     *    Calculates bmi from user's height and weight based on units.
     *    @param array $units; Unit values for height and weight
     *    @param int $height;
     *    @param int $weight;
     *    @return int $bmi;
     */
    public function calculate_bmi($units,$height,$weight)
    {
        $bmi = '';
        if (!empty($units) && isset($height) && isset($weight)) {
            if($units['height'] == 'in') {
                //height in in
                $height /= 39.37;
            }
            if ($units['weight'] == "lbs") {
                //weight in lbs
                $weight /= 2.2046;
            }
            $bmi = round($weight / ($height * $height), 2);
        }
        return $bmi;
    }

    public function getUniqueDataArr($dataArr)
    {
        $uniqueDataArr = [];

        foreach ($dataArr as $data) {
            if (!array_key_exists($data['id'], $uniqueDataArr)) {
                $uniqueDataArr[$data['id']] = $data;
            }
        }

        return $uniqueDataArr;
    }

    public function switchToPdoParamType($dataType)
    {
        switch ($dataType) {
            case 'int':
            case 'tinyint':
                return PDO::PARAM_INT;
                break;
            case 'varchar':
            case 'mediumtext':
            case 'datetime':
            case 'timestamp':
            case 'decimal':
                return PDO::PARAM_STR;
                break;
            case 'boolean':
                return PDO::PARAM_BOOL;
                break;
            default:
                return PDO::PARAM_INT;
                break;
        }
    }

    public function camelCaseToUnderscore($str)
    {
        if ("address2" == $str) {
            return "address_2";
        }

        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
        $ret = $matches[0];

        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    public function getCsvData($file)
    {
        $csv = file_get_contents($file['tmp_name']);
        $rowList = array_map("str_getcsv", explode("\r", $csv));
    }
}
