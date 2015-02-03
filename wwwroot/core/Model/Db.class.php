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
 * Db Class
 *
 * Database connection handler
 * @copyright   Comvation AG
 * @author      Michael Ritter <michael.ritter@comvation.com>
 * @package     contrexx
 * @subpackage  core_db
 */

namespace {
    /**
     * Factory callback for AdoDB NewConnection
     * 
     * This is in global namespace for backwards compatibility to PHP 5.3
     * $ADODB_NEWCONNECTION = array($this, 'adodbPdoConnectionFactory');
     * leads to a "function name must be a string"
     * @deprecated Use Doctrine!
     * @return \Cx\Core\Model\CustomAdodbPdo 
     */
    function cxAdodbPdoConnectionFactory() {
        $obj = new \Cx\Core\Model\CustomAdodbPdo(\Env::get('pdo'));
        return $obj;
    }
}

namespace Cx\Core\Model {

    /**
     * DB Exception
     *
     * @copyright   Comvation AG
     * @author      Michael Ritter <michael.ritter@comvation.com>
     * @package     contrexx
     * @subpackage  core_db
     */
    class DbException extends \Exception {}

    /**
     * Db Class
     *
     * Database connection handler
     * @copyright   Comvation AG
     * @author      Michael Ritter <michael.ritter@comvation.com>
     * @package     contrexx
     * @subpackage  core_db
     */
    class Db {
        
        /**
         * Contrexx instance
         * @var \Cx\Core\Core\Controller\Cx
         */
        protected $cx = null;
        
        /**
         * PDO instance
         * @var \PDO
         */
        protected $pdo = null;
        
        /**
         * AdoDB instance
         * @var \ADONewConnection 
         */
        protected $adodb = null;
        
        /**
         * Doctrine entity manager instance
         * @var \Doctrine\ORM\EntityManager 
         */
        protected $em = null;
        
        /**
         * Doctrine LoggableListener instance
         * @var \Gedmo\Loggable\LoggableListener 
         */
        protected $loggableListener = null;
        
        /**
         * Creates a new instance of the database connection handler
         * @param \Cx\Core\Core\Controller\Cx $cx Main class
         */
        public function __construct(\Cx\Core\Core\Controller\Cx $cx) {
            $this->cx = $cx;
        }
        
        /**
         * Sets the username for loggable listener
         * @param string $username Username data as string
         */
        public function setUsername($username) {
            $this->loggableListener->setUsername($username);
        }

        /**
         * Initializes the PDO connection
         * @global array $_DBCONFIG Database configuration
         * @global array $_CONFIG Configuration
         * @return \PDO PDO connection
         */
        public function getPdoConnection() {
            global $_DBCONFIG, $_CONFIG;

            if ($this->pdo) {
                return $this->pdo;
            }
            $objDateTimeZone = new \DateTimeZone($_CONFIG['timezone']);
            $objDateTime = new \DateTime('now', $objDateTimeZone);
            $offset = $objDateTimeZone->getOffset($objDateTime);
            $offsetHours = floor(abs($offset)/3600); 
            $offsetMinutes = round((abs($offset)-$offsetHours*3600) / 60); 
            $offsetString = ($offset > 0 ? '+' : '-').($offsetHours < 10 ? '0' : '').$offsetHours.':'.($offsetMinutes < 10 ? '0' : '').$offsetMinutes;

            $this->pdo = new \PDO(
                'mysql:dbname=' . $_DBCONFIG['database'] . ';charset=' . $_DBCONFIG['charset'] . ';host=' . preg_replace('/:/', ';port=', $_DBCONFIG['host']),
                $_DBCONFIG['user'],
                $_DBCONFIG['password'],
                array(
                    // Setting the connection character set in the DSN (see below new \PDO()) prior to PHP 5.3.6 did not work.
                    // We will have to manually do it by executing the SET NAMES query when connection to the database.
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$_DBCONFIG['charset'],
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET time_zone = \'' . $offsetString . '\'',
                )
            );
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
            \Env::set('pdo', $this->pdo);
            return $this->pdo;
        }

        /**
         * Returns the AdoDB connection
         * @deprecated Use Doctrine (getEntityManager()) instead
         * @global string $ADODB_FETCH_MODE
         * @return \ADONewConnection 
         */
        public function getAdoDb() {
            if ($this->adodb) {
                return $this->adodb;
            }
            // Make sure, \Env::get('pdo') is set
            $this->getPdoConnection();

            global $ADODB_FETCH_MODE, $ADODB_NEWCONNECTION;

            // open db connection
            \Env::get('ClassLoader')->loadFile(ASCMS_LIBRARY_PATH.'/adodb/adodb.inc.php');
            $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
            $ADODB_NEWCONNECTION = 'cxAdodbPdoConnectionFactory';
            $this->adodb = \ADONewConnection('pdo');

            $errorNo = $this->adodb->ErrorNo();
            if ($errorNo != 0) {
                if ($errorNo == 1049) {
                    throw new DbException('The database is unavailable');
                } else {
                    throw new DbException($this->adodb->ErrorMsg() . '<br />');
                }
                unset($this->adodb);
                return false;
            }
            return $this->adodb;
        }
        
        /**
         * Adds YAML directories to entity manager
         * @param array $paths List of paths
         */
        public function addSchemaFileDirectories(array $paths) {
            if (!$this->em) {
                $this->getEntityManager();
            }
            
            $drivers = $this->em->getConfiguration()->getMetadataDriverImpl()->getDrivers();
            $drivers['Cx']->addPaths($paths);
        }

        /**
         * Returns the doctrine entity manager
         * @global array $_DBCONFIG Database configuration
         * @return \Doctrine\ORM\EntityManager 
         */
        public function getEntityManager() {
            if ($this->em) {
                return $this->em;
            }

            global $_DBCONFIG, $objCache;

            $config = new \Doctrine\ORM\Configuration();

            $userCacheEngine = $objCache->getUserCacheEngine();
            if (!$objCache->getUserCacheActive()) {
                $userCacheEngine = \Cache::CACHE_ENGINE_OFF;
            }

            $arrayCache = new \Doctrine\Common\Cache\ArrayCache();
            switch ($userCacheEngine) {
                case \Cache::CACHE_ENGINE_APC:
                    $cache = new \Doctrine\Common\Cache\ApcCache();
                    $cache->setNamespace($_DBCONFIG['database'] . '.' . DBPREFIX);
                    break;
                case \Cache::CACHE_ENGINE_MEMCACHE:
                    $memcache = $objCache->getMemcache();
                    $cache = new \Doctrine\Common\Cache\MemcacheCache();
                    $cache->setMemcache($memcache);
                    $cache->setNamespace($this->db->getName() . '.' . $this->db->getTablePrefix());
                    break;
                case \Cache::CACHE_ENGINE_MEMCACHED:
                    $memcache = $objCache->getMemcache();
                    $cache = new \Doctrine\Common\Cache\MemcachedCache();
                    $cache->setMemcache($memcache);
                    $cache->setNamespace($this->db->getName() . '.' . $this->db->getTablePrefix());
                    break;
                case \Cache::CACHE_ENGINE_XCACHE:
                    $cache = new \Doctrine\Common\Cache\XcacheCache();
                    $cache->setNamespace($_DBCONFIG['database'] . '.' . DBPREFIX);
                    break;
                case \Cache::CACHE_ENGINE_FILESYSTEM:
                    $cache = new \Cx\Core_Modules\cache\lib\Doctrine\CacheDriver\FileSystemCache(ASCMS_CACHE_PATH);                    
                    break;
                default:
                    $cache = $arrayCache;
                    break;
            }
            \Env::set('cache', $cache);
//			As in Doctrine documentation and issue reports said, in 2.0 the resultcache implementation was incorrect, so better not to use
            $config->setMetadataCacheImpl($cache);
            $config->setQueryCacheImpl($cache);

            $config->setProxyDir(ASCMS_MODEL_PROXIES_PATH);
            $config->setProxyNamespace('Cx\Model\Proxies');
            
            /**
             * This should be set to true if workbench is present and active.
             * Just checking for workbench.config is not really a good solution.
             * Since ConfigurationFactory used by EM caches auto generation
             * config value, there's no possibility to set this later.
             */
            $config->setAutoGenerateProxyClasses(file_exists(ASCMS_DOCUMENT_ROOT.'/workbench.config'));
            
            $connectionOptions = array(
                'pdo' => $this->getPdoConnection(),
            );

            $evm = new \Doctrine\Common\EventManager();

            $chainDriverImpl = new \Doctrine\ORM\Mapping\Driver\DriverChain();
            $driverImpl = new \Doctrine\ORM\Mapping\Driver\YamlDriver(array(
                ASCMS_CORE_PATH.'/Core'.'/Model/Yaml',             // Component YAML files
            ));
            $chainDriverImpl->addDriver($driverImpl, 'Cx');

            //loggable stuff
            $loggableDriverImpl = $config->newDefaultAnnotationDriver(
                ASCMS_LIBRARY_PATH.'/doctrine/Gedmo/Loggable/Entity' // Document for ODM
            );
            $chainDriverImpl->addDriver($loggableDriverImpl, 'Gedmo\Loggable');

            $this->loggableListener = new \Cx\Core\Model\Model\Event\LoggableListener();
            $this->loggableListener->setUsername('currently_loggedin_user');
            // in real world app the username should be loaded from session, example:
            // Session::getInstance()->read('user')->getUsername();
            $evm->addEventSubscriber($this->loggableListener);

            //tree stuff
            $treeListener = new \Gedmo\Tree\TreeListener();
            $evm->addEventSubscriber($treeListener);
            $config->setMetadataDriverImpl($chainDriverImpl);

            //table prefix
            $prefixListener = new \DoctrineExtension\TablePrefixListener($_DBCONFIG['tablePrefix']);
            $evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $prefixListener);

            $config->setSqlLogger(new \Cx\Lib\DBG\DoctrineSQLLogger());

            $em = \Cx\Core\Model\Controller\EntityManager::create($connectionOptions, $config, $evm);

            //resolve enum, set errors
            $conn = $em->getConnection();
            $conn->setCharset($_DBCONFIG['charset']); 
            $conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
            $conn->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
            
            $this->em = $em;
            return $this->em;
        }
    }
}
