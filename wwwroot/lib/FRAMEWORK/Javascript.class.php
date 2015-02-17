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
 * Javascript
 *
 * @author      Stefan Heinemann <sh@comvation.com>
 * @copyright   CONTREXX CMS - COMVATION AG
 * @package     contrexx
 * @subpackage  lib_framework
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Javascript
 *
 * @author      Stefan Heinemann <sh@comvation.com>
 * @copyright   CONTREXX CMS - COMVATION AG
 * @package     contrexx
 * @subpackage  lib_framework
 * @todo        Edit PHP DocBlocks!
 */
class JS
{
    /**
     * An offset that shall be used before all paths
     *
     * When the JS files are used e.g. in the cadmin
     * section, all paths need a '../' before the path.
     * This variable holds that offset.
     * @see setOffset($offset)
     * @access private
     * @static
     * @var string
     */
    private static $offset = "";

    /**
     * The array containing all the registered stuff
     *
     * @access private
     * @static
     * @var array
     */
    private static $active = array();

    /**
     * Holding the last error
     * @access private
     * @static
     * @var string
     */
    private static $error;

    /**
     * Available JS libs
     * These JS files are per default available
     * in every Contrexx CMS.
     * The format is the following:
     * array(
     *      scriptname : array (
     *          jsfiles :   array of strings containing
     *                      all needed javascript files
     *          cssfiles :  array of strings containing
     *                      all needed css files
     *          dependencies :  array of strings containing
     *                          all dependencies in the right
     *                          order
     *          specialcode :   special js code to be executed
     *          loadcallback:   function that will be executed with
     *                          the options as parameter when chosen
     *                          to activate that JS library, so the
     *                          options can be parsed
     *          makecallback:   function that will be executed when
     *                          the code is generated
     *      )
     * )
     * @access private
     * @static
     * @var array
     */
    private static $available = array(
        'prototype'     => array(
            'jsfiles'       => array(
                'lib/javascript/prototype.js'
            ),
        ),
        'scriptaculous' => array(
            'jsfiles'       => array(
                'lib/javascript/scriptaculous/scriptaculous.js'
            ),
            'dependencies'  => array(
                'prototype'
            ),
        ),
        'shadowbox'     => array(
            'jsfiles'       => array(
                'lib/javascript/shadowbox/shadowbox.js'
            ),
            'dependencies'  => array(
                'cx', // depends on jquery
            ),
            'specialcode'  => "
Shadowbox.loadSkin('classic', cx.variables.get('basePath', 'contrexx')+'lib/javascript/shadowbox/src/skin/');
Shadowbox.loadLanguage('en', cx.variables.get('basePath', 'contrexx')+'lib/javascript/shadowbox/src/lang');
Shadowbox.loadPlayer(['flv', 'html', 'iframe', 'img', 'qt', 'swf', 'wmp'], cx.variables.get('basePath', 'contrexx')+'lib/javascript/shadowbox/src/player');
cx.jQuery(document).ready(function(){
  Shadowbox.init();
})"
        ),
        'jquery'     => array(
            'versions' => array(
                '2.0.3' => array(
                    'jsfiles' => array(
                        'lib/javascript/jquery/2.0.3/js/jquery.min.js',
                     ),
                ),
                '2.0.2' => array(
                    'jsfiles' => array(
                        'lib/javascript/jquery/2.0.2/js/jquery.min.js',
                     ),
                ),
                '1.10.1' => array(
                    'jsfiles' => array(
                        'lib/javascript/jquery/1.10.1/js/jquery.min.js',
                     ),
                ),
                '1.9.1' => array(
                    'jsfiles' => array(
                        'lib/javascript/jquery/1.9.1/js/jquery.min.js',
                     ),
                ),
                '1.8.3' => array(
                    'jsfiles' => array(
                        'lib/javascript/jquery/1.8.3/js/jquery.min.js',
                     ),
                ),
                '1.7.3' => array(
                    'jsfiles' => array(
                        'lib/javascript/jquery/1.7.3/js/jquery.min.js',
                     ),
                ),
                '1.6.4' => array(
                    'jsfiles' => array(
                        'lib/javascript/jquery/1.6.4/js/jquery.min.js',
                     ),
                ),
                '1.6.1' => array(
            		'jsfiles'       => array(
                        'lib/javascript/jquery/1.6.1/js/jquery.min.js',
                     ),
                ),
            ),
            'specialcode' => '$J = jQuery;'
        ),
        'jquery-tools' => array(
            'jsfiles' => array(
                'lib/javascript/jquery/tools/jquery.tools.min.js',
            ),
            'dependencies' => array('jquery'),
        ),
        'jquery-imgareaselect' => array(
            'jsfiles'          => array(
                'lib/javascript/jquery/plugins/imgareaselect/jquery.imgareaselect.js',
            ),
            'cssfiles'         => array(
                'lib/javascript/jquery/plugins/imgareaselect/css/imgareaselect-animated.css',
            ),
            'dependencies' => array('jquery'),
        ),
        'jquery-jqplot' => array(
            'jsfiles'   => array(
                'lib/javascript/jquery/plugins/jqplot/jquery.jqplot.js',
                'lib/javascript/jquery/plugins/jqplot/plugins/jqplot.canvasTextRenderer.js',
                'lib/javascript/jquery/plugins/jqplot/plugins/jqplot.categoryAxisRenderer.js',
                'lib/javascript/jquery/plugins/jqplot/plugins/jqplot.barRenderer.js',
                'lib/javascript/jquery/plugins/jqplot/plugins/jqplot.highlighter.js',
                'lib/javascript/jquery/plugins/jqplot/plugins/jqplot.canvasAxisTickRenderer.js'
            ),
            'cssfiles'  => array(
                'lib/javascript/jquery/plugins/jqplot/jquery.jqplot.css',
            ),
            'dependencies' => array('jquery'),
        ),
        'jquery-bootstrap' => array(
            'jsfiles' => array(
                'lib/javascript/jquery/plugins/bootstrap/bootstrap.js',
            ),
            'cssfiles' => array(
                'lib/javascript/jquery/plugins/bootstrap/bootstrap.css',
            ),
            'dependencies' => array('jquery'),
        ),
        'ckeditor'     => array(
            'jsfiles'       => array(
                'lib/ckeditor/ckeditor.js',
            ),
            'dependencies' => array('jquery'),
        ),
        'jquery-cookie' => array(
            'jsfiles'       => array(
                'lib/javascript/jquery/cookie/jquery.cookie.js',
            ),
            'dependencies' => array('jquery'),
        ),
        // Required by HTML::getDatepicker() (modules/shop)!
        // (Though other versions will do just as well)
// TODO: remove & replace by cx call
        'jqueryui'     => array(
            'jsfiles'       => array(
                'lib/javascript/jquery/ui/jquery-ui-1.8.7.custom.min.js',
                'lib/javascript/jquery/ui/jquery-ui-timepicker-addon.js',
            ),
            'cssfiles'      => array(
                'lib/javascript/jquery/ui/css/jquery-ui.css'
            ),
            'dependencies'  => array(
                'cx', // depends on jquery
            ),
        ),
        //stuff to beautify forms.
        'cx-form'     => array(
            'jsfiles'       => array(
                'lib/javascript/jquery/ui/jquery.multiselect2side.js'
            ),
            'cssfiles'      => array(
                'lib/javascript/jquery/ui/css/jquery.multiselect2side.css'
            ),
            'dependencies'  => array(
                'jqueryui'
            ),
        ),

/*
Coming soon
Caution: JS/ALL files are missing. Also, this should probably be loaded through js:cx now.
        'jcrop' => array(
            'jsfiles'       => array(
                'lib/javascript/jcrop/js/jquery.Jcrop.min.js'
            ),
            'cssfiles'      => array(
                'lib/javascript/jcrop/css/jquery.Jcrop.css',
            ),
            'dependencies'  => array(
                'jquery',
            ),
            // When invoking jcrop, add code like this to create the widget:
            // cx.jQuery(window).load(function(){
            //   cx.jQuery("#my_image").Jcrop({ [option: value, ...] });
            // });
            // where option may be any of
            // aspectRatio   decimal
            //    Aspect ratio of w/h (e.g. 1 for square)
            // minSize       array [ w, h ]
            //    Minimum width/height, use 0 for unbounded dimension
            // maxSize       array [ w, h ]
            //    Maximum width/height, use 0 for unbounded dimension
            // setSelect     array [ x, y, x2, y2 ]
            //    Set an initial selection area
            // bgColor       color value
            //    Set color of background container
            // bgOpacity     decimal 0 - 1
            //    Opacity of outer image when cropping
        ),
*/
        'md5' => array(
            'jsfiles' => array(
                'lib/javascript/jquery/jquery.md5.js',
            ),
            'dependencies' => array('jquery'),
        ),
        'cx' => array(
            'jsfiles' => array(
                'lib/javascript/cx/contrexxJs.js',
                'lib/javascript/cx/contrexxJs-tools.js',
                'lib/javascript/jquery/jquery.includeMany-1.2.2.js' //to dynamically include javascript files
            ),
            'dependencies' => array(
                'md5', // depends on jquery
                'jquery-tools', // depends on jquery
            ),
            'lazyDependencies' => array('jqueryui'),
            //we insert the specialCode for the Contrexx-API later in getCode()
        ),
        'jstree' => array(
            'jsfiles' => array(
                'lib/javascript/jquery/jstree/jquery.jstree.js',
                'lib/javascript/jquery/hotkeys/jquery.hotkeys.js',
            ),
            'dependencies' => array('jquery', 'jquery-cookie'),
        ),

        // jQ UI input select enhancer. used in Content Manager 2
        'chosen' => array(
            'jsfiles' => array(
                'lib/javascript/jquery/chosen/jquery.chosen.js'
            ),
            'cssfiles' => array(
                'lib/javascript/jquery/chosen/chosen.css'
            ),
            'dependencies' => array('jquery'),
            'specialcode'  => '
                cx.jQuery(document).ready(function() {
                    if(cx.jQuery(".chzn-select").length > 0) {
                        cx.jQuery(".chzn-select").chosen({
                            disable_search: true
                        });
                    }
                });'
        ),
        'backend' => array(
            'jsfiles' => array(
                'cadmin/javascript/switching_content.js',
                'cadmin/javascript/tabs.js',
                'cadmin/javascript/set_checkboxes.js'
            )
        ),
        'user-live-search' => array(
            'jsfiles' => array(
                'lib/javascript/user-live-search.js',
            ),
            'dependencies' => array(
                'cx', // depends on jquery
                'jqueryui',
            ),
        ),
        'twitter-bootstrap' => array(
            'versions' => array(
                '3.1.0' => array(
                    'jsfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.1.0/js/bootstrap.min.js',
                     ),
                    'cssfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.1.0/css/bootstrap.min.css',
                     ),
                    'dependencies' => array('jquery' => '^([^1]\..*|1\.[^0-6]*\..*)$'), // jquery needs to be version 1.7.3 or higher
                ),
                '3.0.3' => array(
                    'jsfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.0.3/js/bootstrap.min.js',
                     ),
                    'cssfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.0.3/css/bootstrap.min.css',
                     ),
                    'dependencies' => array('jquery' => '^([^1]\..*|1\.[^0-6]*\..*)$'), // jquery needs to be version 1.7.3 or higher
                ),
                '3.0.2' => array(
                    'jsfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.0.2/js/bootstrap.min.js',
                     ),
                    'cssfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.0.2/css/bootstrap.min.css',
                     ),
                    'dependencies' => array('jquery' => '^([^1]\..*|1\.[^0-6]*\..*)$'), // jquery needs to be version 1.7.3 or higher
                ),
                '3.0.1' => array(
                    'jsfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.0.1/js/bootstrap.min.js',
                     ),
                    'cssfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.0.1/css/bootstrap.min.css',
                     ),
                    'dependencies' => array('jquery' => '^([^1]\..*|1\.[^0-6]*\..*)$'), // jquery needs to be version 1.7.3 or higher
                ),
                '3.0.0' => array(
                    'jsfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.0.0/js/bootstrap.min.js',
                     ),
                    'cssfiles' => array(
                        'lib/javascript/twitter-bootstrap/3.0.0/css/bootstrap.min.css',
                     ),
                    'dependencies' => array('jquery' => '^([^1]\..*|1\.[^0-6]*\..*)$'), // jquery needs to be version 1.7.3 or higher
                ),
                '2.3.2' => array(
                    'jsfiles' => array(
                        'lib/javascript/twitter-bootstrap/2.3.2/js/bootstrap.min.js',
                     ),
                    'cssfiles' => array(
                        'lib/javascript/twitter-bootstrap/2.3.2/css/bootstrap.min.css',
                        'lib/javascript/twitter-bootstrap/2.3.2/css/bootstrap-responsive.min.css',
                     ),
                    'dependencies' => array('jquery' => '^([^1]\..*|1\.[^0-6]*\..*)$'), // jquery needs to be version 1.7.3 or higher
                ),
            ),
        ),
    );

    /**
     * Holds the custom JS files
     * @static
     * @access private
     * @var array
     */
    private static $customJS = array();

    /**
     * Holds the template JS files
     * @static
     * @access private
     * @var array
     */
    private static $templateJS = array();

    /**
     * The custom CSS files
     * @static
     * @access private
     * @var array
     */
    private static $customCSS = array();

    /**
     * The custom Code
     * @static
     * @access private
     * @var array
     */
    private static $customCode = array();

    /**
     * The players of the shadowbox
     * @access private
     * @static
     * @var array
     */
    private static $shadowBoxPlayers = array('img', 'swf', 'flv', 'qt', 'wmp', 'iframe','html');

    /**
     * The language of the shadowbox to be used
     * @access private
     * @static
     * @var string
     */
    private static $shadowBoxLanguage = "en";

    /**
     * Remembers all js files already added in some way.
     *
     * @access private
     * @static
     * @var array
     */
    private static $registeredJsFiles = array();

    private static $re_name_postfix = 1;
    private static $comment_dict = array();

    /**
     * Array holding certain scripts we do not want the user to include - we provide
     * the version supplied with Contrexx instead.
     *
     * This was introduced to prevent the user from overriding the jQuery plugins included
     * by the Contrexx javascript framework.
     *
     * @see registerFromRegex()
     * @var array associative array ( '/regexstring/' => 'componentToIncludeInstead' )
     */
    protected static $alternatives = array(
        '/^jquery([-_]\d\.\d(\.\d)?)?(\.custom)?(\.m(in|ax))?\.js$/i' => 'jquery'
    );

    /**
     * Set the offset parameter
     * @param string
     * @static
     * @access public
     * @todo Setting the offset path could be done automatically. Implement such an algorithm
     *       and remove this method.
     */
    public static function setOffset($offset)
    {
        if (!preg_match('/\/$/', $offset)) {
            $offset .= '/';
        }
        self::$offset = $offset;
    }


    /**
     * Activate an available js file
     *
     * The options parameter is specific for the chosen
     * library. The library must define callback methods for
     * the options to be used.
     * @access public
     * @static
     * @param  string  $name
     * @param  array   $options
     * @param  bool    $dependencies
     * @return bool
     */
    public static function activate($name, $options = null, $dependencies = true)
    {
        $name = strtolower($name);
        $index = array_search($name, self::$active);
        if ($index !== false) {
            // Move dependencies to the end of the array, so that the
            // inclusion order is maintained.
            // Note that the entire array is reversed for code generation,
            // so dependencies are loaded first!
            // See {@see getCode()} below.
            unset(self::$active[$index]);
        }
        if (array_key_exists($name, self::$available) === false) {
            self::$error = $name.' is not a valid name for
                an available javascript type';
            return false;
        }
        $data = self::$available[$name];
        if (!empty($data['ref'])) {
            $name = $data['ref'];
            if (array_key_exists($name, self::$available)) {
                $data = self::$available[$name];
            } else {
                self::$error = $name.' unknown reference';
                return false;
            }
        }
        self::$active[] = $name;
        if (!empty($data['dependencies']) && $dependencies) {
            foreach ($data['dependencies'] as $dep) {
                self::activate($dep);
            }
        }
        if (isset($data['loadcallback']) && isset($options)) {
            self::$data['loadcallback']($options);
        }
        return true;
    }


    /**
     * Deactivate a previously activated js file
     * @param string $name
     * @access public
     * @static
     * @return bool
     */
    public static function deactivate($name)
    {
        $name = strtolower($name);
        $searchResult = array_search($name, self::$active);
        if ($searchResult === false)
        {
            self::$error = $name.' is not a valid name for
                an available javascript type';
            return false;
        }
        unset(self::$active[$searchResult]);
        return true;
    }


    /**
     * Register a custom JavaScript file
     *
     * Loads a new, individual JavaScript file that will be included in the page response.
     * If a file is registered that already exists as an available JavaScript library,
     * then this one will be loaded instead.
     * @param string $file The path of $file must be specified relative to the document root of the website.
     *     I.e. modules/foo/bar.js
     * @param bool $template is a javascript file which has been included from template
     *
     * External files are also suppored by providing a valid HTTP(S) URI as $file.
     * @return bool Returns TRUE if the file will be loaded, otherwiese FALSE.
     */
    public static function registerJS($file, $template = false)
    {
        // check whether the script has a query string and remove it
        // this is necessary to check whether the file exists in the filesystem or not
        $fileName = $file;
        $queryStringBegin = strpos($fileName, '?');
        if ($queryStringBegin) {
            $fileName = substr($fileName, 0, $queryStringBegin);
        }

        // if it is an local javascript file
        if (!preg_match('#^https?://#', $fileName)) {
            if (!file_exists(\Env::get('ClassLoader')->getFilePath(($fileName[0] == '/' ? ASCMS_PATH : ASCMS_DOCUMENT_ROOT.'/').$fileName))) {
                self::$error .= "The file ".$fileName." doesn't exist\n";
                return false;
            }
        }

        // add original file name with query string to custom javascripts array
        if (array_search($file, self::$customJS) !== false || array_search($file, self::$templateJS) !== false) {
            return true;
        }
        if ($template) {
            self::$templateJS[] = $file;
        } else {
            self::$customJS[] = $file;
        }
        return true;
    }

    /**
     * Register a custom css file
     *
     * Add a new, individual CSS file to the list.
     * The filename has to be relative to the document root.
     * @static
     * @access public
     * @return bool
     */
    public static function registerCSS($file)
    {
        if (!file_exists(\Env::get('ClassLoader')->getFilePath(ASCMS_DOCUMENT_ROOT.'/'.$file))) {
            self::$error = "The file ".$file." doesn't exist\n";
            return false;
        }

        if (array_search($file, self::$customCSS) === false) {
            self::$customCSS[] = $file;
        }
        return true;
    }


    /**
     * Register special code
     * Add special code to the List
     * @static
     * @access public
     * @return bool
     */
    public static function registerCode($code)
    {
        // try to see if this code already exists
        $code = trim($code);
        if (array_search($code, self::$customCode) === false) {
            self::$customCode[] = $code;
        }
        return true;
    }


    /**
     * Return the code for the placeholder
     * @access public
     * @static
     * @return string
     */
    public static function getCode()
    {
        $cssfiles = array();
// TODO: Unused
//        $jsfiles = array();
//        $specialcode = array();
        $lazyLoadingFiles = array();
        $retstring  = '';
        $jsScripts = array();
        if (count(self::$active) > 0) {
            // check for lazy dependencies, if there are lazy dependencies, activate cx
            // cx provides the lazy loading mechanism
            // this should be here because the cx variable have to be set before cx is initialized
            foreach (self::$active as $name) {
                $data = self::$available[$name];
                if (!empty($data['lazyDependencies'])) {
                    foreach ($data['lazyDependencies'] as $dependency) {
                        if (!in_array($dependency, self::$active)) {
                            // if the lazy dependency is not activated so far
                            $lazyLoadingFiles = array_merge($lazyLoadingFiles, self::$available[$dependency]['jsfiles']);
                        }
                        if (!empty(self::$available[$dependency]['cssfiles'])) {
                            $cssfiles = array_merge($cssfiles, self::$available[$dependency]['cssfiles']);
                        }
                    }
                }
            }
            if (!empty($lazyLoadingFiles)) {
                JS::activate('cx');
            }

            // set cx.variables with lazy loading file paths
            ContrexxJavascript::getInstance()->setVariable('lazyLoadingFiles', $lazyLoadingFiles, 'contrexx');
            
            // Note the "reverse" here.  Dependencies are at the end of the
            // array, and must be loaded first!
            foreach (array_reverse(self::$active) as $name) {
                $data = self::$available[$name];
                if (!isset($data['jsfiles']) && !isset($data['versions'])) {
                    self::$error = "A JS entry should at least contain one js file...";
                    return false;
                }
                // get js files which are specified or the js files from first version
                if (!isset($data['jsfiles'])) {
                    // get data from default version and load the files from there
                    $versionData = end($data['versions']);
                    $data = array_merge($data, $versionData);
                }
                $jsScripts[] = self::makeJSFiles($data['jsfiles']);
                if (!empty($data['cssfiles'])) {
                    $cssfiles = array_merge($cssfiles, $data['cssfiles']);
                }
                if (isset($data['specialcode']) && strlen($data['specialcode']) > 0) {
                    $jsScripts[] = self::makeSpecialCode(array($data['specialcode']));
                }
                if (isset($data['makecallback'])) {
                    self::$data['makecallback']();
                }
                // Special case contrexx-API: fetch specialcode if activated
                if ($name == 'cx') {
                    $jsScripts[] = self::makeSpecialCode(
                        array(ContrexxJavascript::getInstance()->initJs()));
                }
            }
        }

        $jsScripts[] = self::makeJSFiles(self::$customJS);
        
        // if jquery is activated, do a noConflict
        if (array_search('jquery', self::$active) !== false) {
        $jsScripts[] = self::makeSpecialCode('$J = cx.jQuery = jQuery.noConflict();');
        }
        $jsScripts[] = self::makeJSFiles(self::$templateJS);
        
        // no conflict for normal jquery version which has been included in template or by theme dependency
        $jsScripts[] = self::makeSpecialCode('if (typeof jQuery != "undefined") { jQuery.noConflict(); }');
        $retstring .= self::makeCSSFiles($cssfiles);
        $retstring .= self::makeCSSFiles(self::$customCSS);
        // Add javscript files
        $retstring .= implode(' ', $jsScripts);
        $retstring .= self::makeJSFiles(self::$customJS);
        $retstring .= self::makeSpecialCode(self::$customCode);
        return $retstring;
    }


    /**
     * Return the last error
     * @return string
     * @static
     * @access public
     */
    public static function getLastError()
    {
        return self::$error;
    }


    /**
     * Return the available libs
     * @access public
     * @static
     * @return array
     */
    public static function getAvailableLibs()
    {
        return self::$available;
    }


    /**
     * Make the code for the Javascript files
     * @param array $files
     * @return string
     * @static
     * @access private
     */
    private static function makeJSFiles($files)
    {
        global $_CONFIG;
        $code = "";

        foreach ($files as $file) {
            // The file has already been added to the js list
            if (array_search($file, self::$registeredJsFiles) !== false)
                continue;
            self::$registeredJsFiles[] = $file;
            $path = '';

            if (!preg_match('#^https?://#', $file)) {
                $path = self::$offset;
                if ($_CONFIG['useCustomizings'] == 'on' && file_exists(ASCMS_CUSTOMIZING_PATH.'/'.$file)) {
                    $path .= preg_replace('#'.ASCMS_DOCUMENT_ROOT.'/#', '', ASCMS_CUSTOMIZING_PATH) . '/';
                }
            }

            $path .= $file;
            $code .= "<script type=\"text/javascript\" src=\"".$path."\"></script>\n\t";
        }
        return $code;
    }


    /**
     * Make the code for the CSS files
     * @param array $files
     * @return string
     * @static
     * @access private
     */
    private static function makeCSSFiles($files)
    {
        global $_CONFIG;
        $code = "";
        foreach ($files as $file) {
            $path = self::$offset;
            if ($_CONFIG['useCustomizings'] == 'on' && file_exists(ASCMS_CUSTOMIZING_PATH.'/'.$file)) {
                $path .= preg_replace('#'.ASCMS_DOCUMENT_ROOT.'/#', '', ASCMS_CUSTOMIZING_PATH) . '/';
            }
            $path .= $file;
            $code .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$path."\" />\n\t";
        }
        return $code;
    }


    /**
     * Make the code section for
     * @access private
     * @param array $code
     * @return string
     * @static
     */
    private static function makeSpecialCode($code)
    {
        if (empty($code)) {
            return '';
        }
        
        $retcode = "<script type=\"text/javascript\">\n/* <![CDATA[ */\n";
        if (is_array($code)) {
            $retcode .= implode("\r\n", $code);
        } else {
            $retcode .= $code;
        }
        $retcode .= "\n/* ]]> */\n</script>\n";
        return $retcode;
    }


    public static function registerFromRegex($matchinfo)
    {
        $script = $matchinfo[1];
        $alternativeFound = false;
        //make sure we include the alternative if provided
        foreach(self::$alternatives as $pattern => $alternative) {
            if(preg_match($pattern, basename($script)) > 0) {
                if ($alternative != 'jquery') {
                    self::activate($alternative);
                    $alternativeFound = true;
                }
                break;
            }
        }
        //only register the js if we didn't activate the alternative
        if(!$alternativeFound)
            self::registerJS($script, true);
    }


    /**
     * Finds all <script>-Tags in the passed HTML content, strips them out
     * and puts them in the internal JAVASCRIPT placeholder store.
     * You can then retreive them all-in-one with JS::getCode().
     * @param string $content - Reference to the HTML content. Note that it
     *                          WILL be modified in-place.
     */
    public static function findJavascripts(&$content)
    {
        JS::grabComments($content);
        $content = preg_replace_callback('/<script .*?src=(?:"|\')([^"\']*)(?:"|\').*?\/?>(?:<\/script>)?/i', array('JS', 'registerFromRegex'), $content);
        JS::restoreComments($content);
    }
    
    /**
     * Get an array of libraries which are ready to load in different versions
     * @return array the libraries which are ready to configure for skin
     */
    public static function getConfigurableLibraries()
    {
        $configurableLibraries = array();
        foreach (self::$available as $libraryName => $libraryInfo) {
            if (isset($libraryInfo['versions'])) {
                $configurableLibraries[$libraryName] = $libraryInfo;
            }
        }
        return $configurableLibraries;
    }


    /**
     * Grabs all comments in the given HTML and replaces them with a
     * temporary string. Modifies the given HTML in-place.
     * @param string $content
     */
    private static function grabComments(&$content)
    {
        $content = preg_replace_callback('#<!--.*?-->#ms', array('JS', '_storeComment'), $content);
    }


    /**
     * Restores all grabbed comments (@see JS::grabComments()) and
     * puts them back in the given content. Modifies the given HTML in-place.
     * @param string $content
     */
    private static function restoreComments(&$content)
    {
        krsort(self::$comment_dict);
        foreach (self::$comment_dict as $key => $value) {
            $content = str_replace($key, $value, $content);
        }
    }


    /**
     * Internal helper for replacing comments. @see JS::grabComments()
     */
    private static function _storeComment($re)
    {
        $name = 'saved_comment_'.self::$re_name_postfix;
        self::$comment_dict[$name] = $re[0];
        self::$re_name_postfix++;
        return $name;
    }

}
