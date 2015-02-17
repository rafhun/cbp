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
 * EntityBase
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  model_base
 */

namespace Cx\Model\Base;

/**
 * Thrown by @link EntityBase::validate() if validation errors occur.
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  model_base
 */
class ValidationException extends \Exception {
    protected $errors;

    public function __construct(array $errors) {
        parent::__construct();
        $this->errors = $errors;
        $this->assignMessage();
    }

    private function assignMessage() {
        $str = '';
        foreach($this->errors as $field => $details) {
            $str .= $field.":\n";
            foreach($details as $id => $message) {
                $str .= "    $id: $message\n";
            }
        }
        $this->message = $str;
    }

    public function getErrors() {
        return $this->errors;
    }
}

/**
 * This class provides the magic of being validatable.
 * See EntityBase::$validators if you want to subclass it.
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  model_base
 */
class EntityBase {
    /**
     * Initialize this array as follows:
     * array(
     *     'columName' => Zend_Validate
     * )
     * @var array
     */
    protected $validators = null;

    /**
     * @throws ValidationException
     * @prePersist
     */
    public function validate() {
        if(!$this->validators)
            return;

        $errors = array();
        foreach($this->validators as $field => $validator) {
            $methodName = 'get'.ucfirst($field);
            $val = $this->$methodName();
            if($val) {
                if(!$validator->isValid($val)) {
                     $errors[$field] = $validator->getMessages();
                }
            }
        }
        if(count($errors) > 0)
            throw new ValidationException($errors);
    }
}
