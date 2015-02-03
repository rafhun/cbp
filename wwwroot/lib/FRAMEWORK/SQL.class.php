<?php

/**
 * Contrexx
 *
 * @link      http://www.contrexx.com
 * @copyright Comvation AG 2007-2014
 * @version   Contrexx 4.0
 * 
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Contrexx" is a registered trademark of Comvation AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

/**
 * SQL
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_framework
 */

/**
 * Provides SQL building functions.
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_framework
 */
class SQL
{
    /**
     * Generates insert SQL
     * @param string $table the table name
     * @param array $columns array(
     *     <column_name> => <data> 
     *                 | array(
     *             'val' => string, #the value
     *             [ 'omitEmpty' => boolean ] #skip fields with empty value (null or empty string)? defaults to false
     *         )
     *     )
     *     [ , ... ]
     * @param array $options global options. optional.
     *              array(
     *                  'escape' => boolean #whether strings are escaped automatically
     *              )
     */
    public static function insert($table, $columns, $options=array()) 
    {
        $escape = false;
        if(isset($options['escape']))
           $escape = $options['escape'];
        
        $sql  = 'INSERT INTO `'.DBPREFIX."$table` ";
        $sql .= self::columnPart($columns, $escape);
        return $sql;
    }

    /**
     * Generates update SQL
     * @param string $table the table name
     * @param array $columns array(
     *     <column_name> => <data> 
     *                 | array(
     *             'val' => string, #the value
     *             [ 'omitEmpty' => boolean ] #skip fields with empty value (null or empty string)? defaults to false
     *         )
     *     )
     *     [ , ... ]
     * @param array $options global options. optional.
     *              array(
     *                  'escape' => boolean #whether strings are escaped automatically
     *              )
     */
    public static function update($table, $columns, $options=array())
    {
        $escape = false;
        if(isset($options['escape']))
            $escape = $options['escape'];

        $sql  = 'UPDATE `'.DBPREFIX."$table` ";
        $sql .= self::columnPart($columns, $escape);
        return $sql;        
    }

    protected static function columnPart($columns, $escape) 
    {
        $result = "SET \n";

        $firstCol = true;
        foreach($columns as $column => $data) {
            $value = '';
            if(!is_array($data)) { //raw data provided
                $value = self::apostrophizeIfString($data, $escape);
            }
            else { //hooray, array.
                $value = $data['val'];
                if($data['omitEmpty'] === true) { //skip null and empty strings
                    if(null === $value || '' === $value) {
                        continue;
                    }
                }
                $value = self::apostrophizeIfString($value, $escape);
            }
            $result .= '    '.($firstCol ? '' : ',') ."`$column` = $value\n";
            $firstCol = false;
        }
        return $result;
    }

    protected static function apostrophizeIfString($value, $escape) 
    {
        if(is_string($value)) { //escape strings
            if($escape)
                $value = contrexx_raw2db($value);
            return "'$value'";
        }
        return $value;
    }
}
