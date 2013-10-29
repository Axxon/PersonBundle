<?php
/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PersonBundle\Util;

/**
 * Class Countries
 *
 * @package Black\Bundle\PersonBundle\Util
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Countries
{
    /**
     * @return array
     */
    public static function getEUCountries()
    {
        return array(
            "AT" => "Austria",
            "BE" => "Belgium",
            "BG" => "Bulgaria",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "EE" => "Estonia",
            "FI" => "Finland",
            "FR" => "France",
            "DE" => "Germany",
            "GR" => "Greece",
            "HU" => "Hungary",
            "IE" => "Ireland",
            "IT" => "Italy",
            "LV" => "Latvia",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MT" => "Malta",
            "NL" => "Netherlands",
            "PL" => "Poland",
            "PT" => "Portugal",
            "RO" => "Romania",
            "SK" => "Slovakia (Slovak Republic)",
            "SI" => "Slovenia",
            "ES" => "Spain",
            "SE" => "Sweden",
            "GB" => "United Kingdom",
            "CH" => "Switzerland"
        );
    }
}
