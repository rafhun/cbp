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
 * NewsML
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_feed
 * @todo        Edit PHP DocBlocks!
 */

/**
 * NewsML
 *
 * NewsML interface
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @access      public
 * @version     1.0.0
 * @package     contrexx
 * @subpackage  module_feed
 */
class NewsML
{
    public $_xmlDocument;
    public $_currentXmlElement;
    public $_arrParentXmlElement = array();
    public $arrTplPlaceholders = array();
    public $arrCategories = array();
    public $_arrProviders = array();
    public $_arrDocuments = array();
    public $_arrExcludeFiles = array('.', '..', 'index.php', 'index.html');
    public $_inNITF = false;
    public $_xmlContentHTMLTag = '';
    public $_inParagraph = false;
    public $_tmpParagraph = array();
    public $_xmlParserCharacterEncoding;
    public $standardMessageCount = 10;
    public $administrate = false;
    public $_inCDATA = false;


    function __construct($administrate = false)
    {
        $this->administrate = $administrate;
        $this->_xmlParserCharacterEncoding = CONTREXX_CHARSET;
        $this->initCategories();
    }


    /**
    * Set news
    *
    * Set the news message of the newsML category
    *
    * @access public
    * @param array $arrNewsMLCategories
    * @param string &$code
    * @global object $objDatabase
    */
    function setNews($arrNewsMLCategories, &$code)
    {
        $arrTplPlaceholders = $this->arrTplPlaceholders;
        if (count($arrTplPlaceholders)>0) {
            foreach ($arrNewsMLCategories as $category) {
                $arrMatches = preg_grep('/^'.$category.'$/i', $arrTplPlaceholders);
                if (count($arrMatches)>0) {
                    $categoryIds = array_keys($arrMatches);
                    $categoryId = $categoryIds[0];
                    $this->readDocuments($categoryId);
                    $code = str_replace("{NEWSML_".$category."}", $this->parseDocuments($categoryId), $code);
                }
            }
        }
    }


    /**
    * Parse NewsML documents
    *
    * Parse the NewsML documents of the category $categoryId and return the parsed html code
    *
    * @access public
    * @param integer $categoryId
    * @global array $_CORELANG
    * @return string html code
    */
    function parseDocuments($categoryId)
    {
        global $_CORELANG;

        $arrDocuments = $this->getDocuments($categoryId);
        $arrDocumentIds = array();
        foreach ($arrDocuments as $documentId => $arrDocument) {
            $arrDocumentIds[$documentId] = $arrDocument['thisRevisionDate'];
        }
        arsort($arrDocumentIds);

        $code = $this->arrCategories[$categoryId]['template'];

        $arrWeekDays = explode(',', $_CORELANG['TXT_DAY_ARRAY']);
        $arrMonths = explode(',', $_CORELANG['TXT_MONTH_ARRAY']);

        $output = "";
        $nr = 0;
        if (count($arrDocuments)>0) {
            foreach (array_keys($arrDocumentIds) as $documentId) {
                if ($nr == $this->arrCategories[$categoryId]['limit']) {
                    break;
                }

                $text = str_replace(array('<p>', '</p>'), '', $arrDocuments[$documentId]['dataContent']);
                $date = $arrWeekDays[date('w', $arrDocuments[$documentId]['thisRevisionDate'])].', '.date('j', $arrDocuments[$documentId]['thisRevisionDate']).'. '.$arrMonths[date('n', $arrDocuments[$documentId]['thisRevisionDate'])-1].' '.date('Y', $arrDocuments[$documentId]['thisRevisionDate']).' / '.date('G:i', $arrDocuments[$documentId]['thisRevisionDate']).' h';
                $dateLong = date(ASCMS_DATE_FORMAT, $arrDocuments[$documentId]['thisRevisionDate']);
                $dateShort = date(ASCMS_DATE_FORMAT_DATE, $arrDocuments[$documentId]['thisRevisionDate']);
                $output .= str_replace(
                    array(
                        '{ID}',
                        '{CATID}',
                        '{TITLE}',
                        '{DATE}',
                        '{LONG_DATE}',
                        '{SHORT_DATE}',
                        '{TEXT}'
                    ),
                    array(
                        $documentId,
                        $categoryId,
                        $arrDocuments[$documentId]['headLine'],
                        $date,
                        $dateLong,
                        $dateShort,
                        substr($text,0,100).'...'
                    ),
                    $code
                );

                if (isset($arrDocuments[$documentId]['photo'])) {
                    if ($arrDocuments[$documentId]['photo']['width'] > 100 || $arrDocuments[$documentId]['photo']['height'] > 75) {
                        $factorWidth = 100 / $arrDocuments[$documentId]['photo']['width'];
                        $factorHeight = 75 / $arrDocuments[$documentId]['photo']['height'];

                        if ($factorWidth < $factorHeight) {
                            $arrDocuments[$documentId]['photo']['width'] = 100;
                            $arrDocuments[$documentId]['photo']['height'] *= $factorWidth;
                        } else {
                            $arrDocuments[$documentId]['photo']['width'] *= $factorHeight;
                            $arrDocuments[$documentId]['photo']['height'] = 75;
                        }
                    }
                    $output = str_replace(
                        array(
                            '{IMAGE_SOURCE}',
                            '{IMAGE_LABEL}',
                            '{IMAGE_WIDTH}',
                            '{IMAGE_HEIGHT}'
                        ),
                        array(
                            $arrDocuments[$documentId]['photo']['source'],
                            $arrDocuments[$documentId]['photo']['label'],
                            $arrDocuments[$documentId]['photo']['width'],
                            $arrDocuments[$documentId]['photo']['height']
                        ),
                        $output
                    );
                    $output = preg_replace('/<--\sBEGIN\simage\s-->/', '', $output);
                    $output = preg_replace('/<--\sEND\simage\s-->/', '', $output);
                } else {
                    $output = preg_replace('/<--\sBEGIN\simage[\s\S]*END\simage\s-->/', '', $output);
                }
                $nr++;
            }
        }
        return $output;
    }

    /**
    * Initialize newsML categories
    * @access   private
    * @global   object  $objDatabase
    */
    function initCategories()
    {
        global $objDatabase;

        $this->arrCategories = array();
        $this->arrTplPlaceholders = array();

        $objCategories = $objDatabase->Execute("
            SELECT cat.id, cat.name, cat.subjectCodes, cat.showSubjectCodes,
                   cat.template, cat.`limit`, cat.`showPics`, cat.auto_update,
                   provider.name AS providerName,
                   provider.path, provider.providerId
              FROM ".DBPREFIX."module_feed_newsml_categories AS cat,
                   ".DBPREFIX."module_feed_newsml_providers AS provider
             WHERE cat.providerId=provider.id");
        if ($objCategories !== false) {
            while (!$objCategories->EOF) {
                $this->arrCategories[$objCategories->fields['id']] = array(
                    'name'              => $objCategories->fields['name'],
                    'subjectCodes'      => explode(',', $objCategories->fields['subjectCodes']),
                    'showSubjectCodes'  => $objCategories->fields['showSubjectCodes'],
                    'template'          => $objCategories->fields['template'],
                    'limit'             => $objCategories->fields['limit'],
                    'showPics'          => $objCategories->fields['showPics'],
                    'path'              => $objCategories->fields['path'],
                    'providerName'      => $objCategories->fields['providerName'],
                    'providerId'        => $objCategories->fields['providerId'],
                    'auto_update'       => (bool) $objCategories->fields['auto_update']
                );
                $this->arrTplPlaceholders[$objCategories->fields['id']] = preg_replace('/\s/', '_', $objCategories->fields['name']);
                $objCategories->MoveNext();
            }
        }
    }


    /**
    * Initialize providers
    *
    * Initialize the NewsML providers
    *
    * @access private
    * @global object $objDatabase
    */
    function _initProviders()
    {
        global $objDatabase;

        $objProviders = $objDatabase->Execute("SELECT id, name FROM ".DBPREFIX."module_feed_newsml_providers");
        if ($objProviders !== false) {
            while (!$objProviders->EOF) {
                $this->_arrProviders[$objProviders->fields['id']] = $objProviders->fields['name'];
                $objProviders->MoveNext();
            }
        }
    }

    /**
    * Get NewsML documents
    *
    * Get the NewsML documents of the category with the id $categoryId
    *
    * @access public
    * @param integer $categoryId
    * @global object $objDatabase
    * @return array Documents
    */
    function getDocuments($categoryId)
    {
        global $objDatabase;

        $arrDocuments = array();
        $subjectCodeDelimiter = '';

        if (   $this->arrCategories[$categoryId]['showSubjectCodes'] != 'all'
            && count($this->arrCategories[$categoryId]['subjectCodes']) > 0) {
            $subjectCodeDelimiter = 'AND (';
            foreach ($this->arrCategories[$categoryId]['subjectCodes'] as $subjectCode) {
                $subjectCodeDelimiter .= 'subjectCode '.($this->arrCategories[$categoryId]['showSubjectCodes'] == 'exclude' ? '!' : ''). '='.$subjectCode.($this->arrCategories[$categoryId]['showSubjectCodes'] == 'exclude' ? ' AND ' : ' OR ');
            }
            $subjectCodeDelimiter = substr($subjectCodeDelimiter, 0, strlen($subjectCodeDelimiter)-4).')';
        }

        $objDocuments = $objDatabase->Execute("SELECT
            id,
            publicIdentifier,
            providerId,
            dateId,
            newsItemId,
            revisionId,
            thisRevisionDate,
            urgency,
            subjectCode,
            headLine,
            dataContent
            FROM ".DBPREFIX."module_feed_newsml_documents
            WHERE providerId='".$this->arrCategories[$categoryId]['providerId']."' ".$subjectCodeDelimiter."
            AND newsItemId LIKE 'brz%'
            ORDER by thisRevisionDate DESC, dateId DESC, urgency
            ".(!$this->administrate ? "LIMIT ".$this->arrCategories[$categoryId]['limit'] : ""));
        if ($objDocuments !== false) {
            while (!$objDocuments->EOF) {
                $arrDocuments[$objDocuments->fields['id']] = array(
                    'dateId'            => $objDocuments->fields['dateId'],
                    'newsItemId'        => $objDocuments->fields['newsItemId'],
                    'revisionId'        => $objDocuments->fields['revisionId'],
                    'thisRevisionDate'  => $objDocuments->fields['thisRevisionDate'],
                    'publicIdentifier'  => $objDocuments->fields['publicIdentifier'],
                    'urgency'           => $objDocuments->fields['urgency'],
                    'subjectCode'       => $objDocuments->fields['subjectCode'],
                    'headLine'          => $objDocuments->fields['headLine'],
                    'dataContent'       => $objDocuments->fields['dataContent']
                );
                $pics = array();
                $objAssociated = $objDatabase->Execute("
                    SELECT pId_slave
                      FROM ".DBPREFIX."module_feed_newsml_association
                     WHERE pId_master='".$objDocuments->fields['publicIdentifier']."'
                     ORDER BY pId_slave DESC");
                if ($objAssociated !== false) {
                    while (!$objAssociated->EOF) {
                        $objPic = $objDatabase->SelectLimit("
                            SELECT properties, source
                              FROM ".DBPREFIX."module_feed_newsml_documents
                             WHERE publicIdentifier LIKE '".$objAssociated->fields['pId_slave']."%'
                               AND media_type='Photo'", 1);
                        if ($objPic !== false) {
                            if ($objPic->RecordCount() == 1) {
                                $arrTmpProperties = explode(';', $objPic->fields['properties']);
                                foreach ($arrTmpProperties as $property) {
                                    $arrPair = explode(':', $property);
                                    $arrProperties[base64_decode($arrPair[0])] = base64_decode($arrPair[1]);
                                }
                                $pics[$objAssociated->fields['pId_slave']] = array(
                                    'source'    => $this->arrCategories[$categoryId]['path'].'/'.$objPic->fields['source'],
                                    'label'     => isset($arrProperties['label']) ? $arrProperties['label'] : '',
                                    'width'     => isset($arrProperties['Width']) ? $arrProperties['Width'] : '',
                                    'height'    => isset($arrProperties['Height']) ? $arrProperties['Height'] : ''
                                );
                                if (   $pics[$objAssociated->fields['pId_slave']]['width'] == 85
                                    && $pics[$objAssociated->fields['pId_slave']]['height'] == 85) {
                                    $arrDocuments[$objDocuments->fields['id']]['photo'] = $pics[$objAssociated->fields['pId_slave']];
                                    break;
                                }
                            }
                        }
                        $objAssociated->MoveNext();
                    }
                    if (!isset($arrDocuments[$objDocuments->fields['id']]['photo']) && count($pics) > 0) {
                        reset($pics);
                        $arrDocuments[$objDocuments->fields['id']]['photo'] = current($pics);
                    }
                }
                $objDocuments->MoveNext();
            }
        }
        return $arrDocuments;
    }


    /**
     * Read NewsML documents
     *
     * Read the NewsML documents of the category with the id $categoryId from its data directory
     * and delete the documents after they are inserted into the database
     * @access public
     * @param integer $categoryId
     * @global object $objDatabase
     */
    function readDocuments($categoryId, $matchFilenamePattern = null)
    {
        global $objDatabase;

        $objDir = @opendir(ASCMS_DOCUMENT_ROOT.$this->arrCategories[$categoryId]['path']);
        if ($objDir) {
            $arrDocuments = array();

            $document = @readdir($objDir);
            while ($document) {
                if (!in_array($document, $this->_arrExcludeFiles) && strtolower(substr($document, -3)) == 'xml' && (!$matchFilenamePattern || preg_match($matchFilenamePattern, $document))) {
                    array_push($arrDocuments , $document);
                }
                $document = @readdir($objDir);
            }
            @closedir($objDir);

            \Cx\Lib\FileSystem\FileSystem::makeWritable(ASCMS_DOCUMENT_ROOT.$this->arrCategories[$categoryId]['path']);

            foreach ($arrDocuments as $document) {
                if ($this->_readDocument($categoryId, $document)) {
                    \Cx\Lib\FileSystem\FileSystem::makeWritable(ASCMS_DOCUMENT_ROOT.$this->arrCategories[$categoryId]['path'].'/'.$document);
                    @copy(ASCMS_DOCUMENT_ROOT.$this->arrCategories[$categoryId]['path'].'/'.$document, ASCMS_DOCUMENT_ROOT.'/si_online_archive/'.$document);
                    \Cx\Lib\FileSystem\FileSystem::makeWritable(ASCMS_DOCUMENT_ROOT.'/si_online_archive/'.$document);
                    \Cx\Lib\FileSystem\FileSystem::delete_file(ASCMS_DOCUMENT_ROOT.$this->arrCategories[$categoryId]['path'].'/'.$document);
                }
            }

//          print_r($this->_arrDocuments);

            foreach ($this->_arrDocuments as $dateId => $arrNewsItems) {
                foreach ($arrNewsItems as $newsItemId => $arrRevisions) {
                    krsort($arrRevisions, SORT_NUMERIC);
                    reset($arrRevisions);
                    $arrRevision = current($arrRevisions);

                    $revisionUpdateStatus = isset($arrRevision['revisionUpdateStatus']) ? $arrRevision['revisionUpdateStatus'] : '';

                    switch ($revisionUpdateStatus) {
                    case 'A':
                        $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_feed_newsml_documents WHERE providerId='".$this->arrCategories[$categoryId]['providerId']."' AND dateId=".$dateId." AND newsItemId='".$newsItemId."'");
                        break;

                    default:
                        $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_feed_newsml_documents WHERE providerId='".$this->arrCategories[$categoryId]['providerId']."' AND dateId=".$dateId." AND newsItemId='".$newsItemId."' AND revisionId != ".$arrRevision['revisionId']);
                        if (isset($arrRevision['dateId'])) {
                            $this->_addDocument($arrRevision['publicIdentifier'], $this->arrCategories[$categoryId]['providerId'], $dateId, $newsItemId, $arrRevision['revisionId'], $arrRevision['thisRevisionDate'], $arrRevision['urgency'], $arrRevision['subjectCode'], $arrRevision['headLine'], $arrRevision['dataContent'], $arrRevision['associatedNewsItems']);
                        }
                        break;
                    }
                }
            }
        }
    }

    /**
    * Add newsml document
    *
    * Add a new NewsML document to the database
    *
    * @access private
    * @param string $publicIdentifier
    * @param integer $providerId
    * @param integer $dateId
    * @param string $newsItemId
    * @param integer $revisionId
    * @param integer $thisRevisionDate
    * @param integer $urgency
    * @param integer $subjectCode
    * @param string $headLine
    * @param string $dataContent
    * @global object $objDatabase
    * @return boolean true on success, false on failure
    */
    function _addDocument($publicIdentifier, $providerId, $dateId, $newsItemId, $revisionId, $thisRevisionDate, $urgency, $subjectCode, $headLine, $dataContent, $associatedNewsItems)
    {
        global $objDatabase;

        $objResult = $objDatabase->SelectLimit("SELECT id FROM ".DBPREFIX."module_feed_newsml_documents WHERE publicIdentifier='".$publicIdentifier."'", 1);
        if ($objResult !== false && $objResult->RecordCount() == 0) {
            if (isset($dataContent['properties'])) {
                $arrProp = array();

                foreach ($dataContent['properties'] as $key => $value) {
                    $arrProp[] = base64_encode($key).":".base64_encode($value);
                }

                $properties = implode(';', $arrProp);
            } else {
                $properties = '';
            }

            if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_feed_newsml_documents (
                publicIdentifier,
                providerId,
                dateId,
                newsItemId,
                revisionId,
                thisRevisionDate,
                urgency,
                subjectCode,
                headLine,
                dataContent,
                media_type,
                source,
                properties
                ) VALUES (
                '".$publicIdentifier."',
                '".$providerId."',
                ".$dateId.",
                '".$newsItemId."',
                ".$revisionId.",
                ".$thisRevisionDate.",
                ".$urgency.",
                ".$subjectCode.",
                '".$headLine."',
                '".$dataContent['data']."',
                '".$dataContent['mediaType']."',
                '".$dataContent['source']."',
                '".$properties."'
                )") !== false) {

                if (count(isset($associatedNewsItems)) > 0) {
                    foreach ($associatedNewsItems as $associatedNewsItem) {
                        $objDatabase->Execute("INSERT INTO ".DBPREFIX."module_feed_newsml_association (`pId_master`, `pId_slave`) VALUES ('".$publicIdentifier."', '".$associatedNewsItem."')");
                    }
                }

                return true;
            }
        }
        return false;
    }

    /**
    * Read NewsML document
    *
    * Read the NewsML document $document of the category with the id $categoryId
    * and put it into the database
    *
    * @access private
    * @param integer $categoryId
    * @param string $document
    * @global object $objDatabase
    * @return boolean true on success, false on failure
    */
    function _readDocument($categoryId, $document)
    {
        $xmlFilePath  = ASCMS_DOCUMENT_ROOT.$this->arrCategories[$categoryId]['path'].'/'.$document;

        $this->_currentXmlElement = null;
        $this->_xmlDocument = null;

        $xml_parser = xml_parser_create($this->_xmlParserCharacterEncoding);
        xml_set_object($xml_parser,$this);
        xml_set_element_handler($xml_parser,"_xmlStartTag","_xmlEndTag");
        xml_set_character_data_handler($xml_parser, "_xmlCharacterDataTag");

        $documentContent = @file_get_contents($xmlFilePath);
        if ($documentContent !== false) {
            xml_parse($xml_parser, $documentContent);
            xml_parser_free($xml_parser);

            if (isset($this->_xmlDocument['NEWSML'])) {
                if (isset($this->_xmlDocument['NEWSML']['NEWSITEM'][0])) {
                    foreach ($this->_xmlDocument['NEWSML']['NEWSITEM'] as $newsItem) {
                        $this->_addNewsItem($newsItem, $categoryId);
                    }
                } else {
                    $this->_addNewsItem($this->_xmlDocument['NEWSML']['NEWSITEM'], $categoryId);
                }

                return true;
            }
        }
        return false;
    }

    function _addNewsItem(&$newsItem, $categoryId)
    {
        global $objDatabase;

        $newsItem = $this->_getNewsItem($newsItem);

        //$instruction = addslashes($newsItem['NEWSMANAGEMENT']['INSTRUCTION']);

        if (!isset($this->_arrDocuments[$newsItem['dateId']][$newsItem['newsItemId']])) {
            $objDocuments = $objDatabase->Execute("SELECT
                publicIdentifier,
                revisionId
                FROM ".DBPREFIX."module_feed_newsml_documents
                WHERE providerId='".$this->arrCategories[$categoryId]['providerId']."' AND dateId=".$newsItem['dateId']." AND newsItemId='".$newsItem['newsItemId']."'
                ORDER BY dateId, newsItemId, revisionId");
            if ($objDocuments !== false) {
                while (!$objDocuments->EOF) {
                    $this->_arrDocuments[$newsItem['dateId']][$newsItem['newsItemId']][$objDocuments->fields['revisionId']] = array(
                        'revisionId'        => $objDocuments->fields['revisionId'],
                        'publicIdentifier'  => $objDocuments->fields['publicIdentifier']
                    );
                    $objDocuments->MoveNext();
                }
            }
        }

        if (!isset($this->_arrDocuments[$newsItem['dateId']][$newsItem['newsItemId']][$newsItem['revisionId']])) {
            $this->_arrDocuments[$newsItem['dateId']][$newsItem['newsItemId']][$newsItem['revisionId']] = array(
                'revisionId'            => $newsItem['revisionId'],
                'publicIdentifier'      => $newsItem['publicIdentifier'],
                'previousRevisionId'    => $newsItem['previousRevisionId'],
                'revisionUpdateStatus'  => $newsItem['revisionUpdateStatus'],
                'dateId'                => $newsItem['dateId'],
                'newsItemId'            => $newsItem['newsItemId'],
                'thisRevisionDate'      => $newsItem['thisRevisionDate'],
                'urgency'               => $newsItem['urgency'],
                'associatedNewsItems'   => isset($newsItem['associatedNewsItems']) ? $newsItem['associatedNewsItems'] : array(),
                'subjectCode'           => $newsItem['newsComponent']['subjectCode'],
                'headLine'              => $newsItem['newsComponent']['headLine'],
                'dataContent'           => $this->_getContentOfNewsComponent($newsItem['newsComponent'])
            );
        }
    }

    function _getContentOfNewsComponent($newsComponent)
    {
        $arrContent = array(
            'properties' => array(),
            'mediaType' => '',
            'source'    => ''
        );

        foreach ($newsComponent['newsComponent'] as $contentItem) {
            if (isset($contentItem['role'])) {
                switch ($contentItem['role']) {
                    case 'Main':
                        if ($contentItem['contentItem']['mediaType'] == 'Photo' && $contentItem['contentItem']['is_ref']) {
                            $arrContent['source'] = $contentItem['contentItem']['data'];
                        } else {
                            $arrContent['data'] = $contentItem['contentItem']['data'];
                        }

                        $arrContent['mediaType'] = $contentItem['contentItem']['mediaType'];
                        break;

                    case 'Caption':
                        $arrContent['properties']['label'] = $contentItem['contentItem']['data'];
                        break;

                    default:
                        break;
                }
            } else {
                if (isset($contentItem['data'])) {
                    $arrContent['data'] = $contentItem['data'];
                } else {
                    $arrContent['data'] = $contentItem['contentItem']['data'];
                }
            }

            if (isset($contentItem['contentItem']['properties'])) {
                foreach ($contentItem['contentItem']['properties'] as $property => $value) {
                    $arrContent['properties'][$property] = $value;
                }
            }
        }

        return $arrContent;
    }

    function _getNewsItem($newsItem)
    {
        $arrNewsItem = array();

        // NewsItem identification
        $arrNewsItem['dateId'] = intval($newsItem['IDENTIFICATION']['NEWSIDENTIFIER']['DATEID']['cdata']);
        $arrNewsItem['newsItemId'] = addslashes($newsItem['IDENTIFICATION']['NEWSIDENTIFIER']['NEWSITEMID']['cdata']);
        $arrNewsItem['revisionId'] = intval($newsItem['IDENTIFICATION']['NEWSIDENTIFIER']['REVISIONID']['cdata']);
        $arrNewsItem['publicIdentifier'] = addslashes($newsItem['IDENTIFICATION']['NEWSIDENTIFIER']['PUBLICIDENTIFIER']['cdata']);
        $arrNewsItem['previousRevisionId'] = intval($newsItem['IDENTIFICATION']['NEWSIDENTIFIER']['REVISIONID']['attrs']['PREVIOUSREVISION']);
        $arrNewsItem['revisionUpdateStatus'] = $newsItem['IDENTIFICATION']['NEWSIDENTIFIER']['REVISIONID']['attrs']['UPDATE'];

        // NewsItem management
        $arrNewsItem['urgency'] = intval($newsItem['NEWSMANAGEMENT']['URGENCY']['attrs']['FORMALNAME']);
        $arrTime = array();
        if (preg_match('/^([0-9]{4})([0-9]{2})([0-9]{2})T([0-9]{2})([0-9]{2})([0-9]{2})/', $newsItem['NEWSMANAGEMENT']['THISREVISIONCREATED']['cdata'], $arrTime)) {
            $arrNewsItem['thisRevisionDate'] = mktime($arrTime[4], $arrTime[5], $arrTime[6], $arrTime[2], $arrTime[3], $arrTime[1]);
        } else {
            $arrNewsItem['thisRevisionDate'] = time();
        }

        if (isset($newsItem['NEWSMANAGEMENT']['ASSOCIATEDWITH'])) {
            $arrNewsItem['associatedNewsItems'] = array();
            if (isset($newsItem['NEWSMANAGEMENT']['ASSOCIATEDWITH'][0])) {
                foreach ($newsItem['NEWSMANAGEMENT']['ASSOCIATEDWITH'] as $item) {
                    array_push($arrNewsItem['associatedNewsItems'], $item['attrs']['NEWSITEM']);
                }
            } else {
                array_push($arrNewsItem['associatedNewsItems'], $newsItem['NEWSMANAGEMENT']['ASSOCIATEDWITH']['attrs']['NEWSITEM']);
            }
        }

        //$instruction = addslashes($newsItem['NEWSMANAGEMENT']['INSTRUCTION']);

        // NewsItem newscomponent
        $arrNewsItem['newsComponent'] = $this->_getNewsComponent($newsItem['NEWSCOMPONENT']);

        return $arrNewsItem;
    }

    function _getNewsComponent($newsComponent)
    {
        $arrNewsComponent = array();

        if (isset($newsComponent['DESCRIPTIVEMETADATA'])) {
            // SubjectDetail describes the kind of SubjectMatter. For example: World cup, National cup
            //if (isset($newsComponent['DESCRIPTIVEMETADATA']['SUBJECTCODE']['SUBJECTDETAIL']['attrs']['FORMALNAME'])) {
            //  $arrNewsComponent['subjectCode'] = intval($newsComponent['DESCRIPTIVEMETADATA']['SUBJECTCODE']['SUBJECTDETAIL']['attrs']['FORMALNAME']);
            //} else
            if (isset($newsComponent['DESCRIPTIVEMETADATA']['SUBJECTCODE']['SUBJECTMATTER']['attrs']['FORMALNAME'])) {
                $arrNewsComponent['subjectCode'] = intval($newsComponent['DESCRIPTIVEMETADATA']['SUBJECTCODE']['SUBJECTMATTER']['attrs']['FORMALNAME']);
            } else {
                $arrNewsComponent['subjectCode'] = intval($newsComponent['DESCRIPTIVEMETADATA']['SUBJECTCODE']['SUBJECT']['attrs']['FORMALNAME']);
            }
        }

        if (isset($newsComponent['NEWSLINES'])) {
            if (isset($newsComponent['NEWSLINES']['HEADLINE'][0])) {
                foreach ($newsComponent['NEWSLINES']['HEADLINE'] as $cdata) {
                    $headLine .= addslashes($cdata)."|||";
                }
            } else {
                $headLine = addslashes($newsComponent['NEWSLINES']['HEADLINE']['cdata']);
            }
            $arrNewsComponent['headLine'] = $headLine;
        }

        if (isset($newsComponent['ROLE']['attrs']['FORMALNAME'])) {
            $arrNewsComponent['role'] = addslashes($newsComponent['ROLE']['attrs']['FORMALNAME']);
        }

        if (isset($newsComponent['CONTENTITEM'])) {
            if (isset($newsComponent['CONTENTITEM'][0])) {
                $contentItem = array();
                foreach ($newsComponent['CONTENTITEM'] as $contentItemElement) {
                    array_push($contentItem, $this->_getContentItem($contentItemElement));
                }
            } else {
                $contentItem = $this->_getContentItem($newsComponent['CONTENTITEM']);
            }
            $arrNewsComponent['contentItem'] = $contentItem;
        } elseif (isset($newsComponent['NEWSCOMPONENT'])) {
            if (isset($newsComponent['NEWSCOMPONENT'][0])) {
                $subNewsComponent = array();
                foreach ($newsComponent['NEWSCOMPONENT'] as $newsComponentElement) {
                    array_push($subNewsComponent, $this->_getNewsComponent($newsComponentElement));
                }
            } else {
                $subNewsComponent = $this->_getNewsComponent($newsComponent['NEWSCOMPONENT']);
            }
            $arrNewsComponent['newsComponent'] = $subNewsComponent;
        } elseif (isset($newsComponent['NEWSITEM'])) {
            if (isset($newsComponent['NEWSITEM'][0])) {
                $newsItem = array();
                foreach ($newsComponent['NEWSITEM'] as $newsItemElement) {
                    array_push($newsItem, $this->_getNewsItem($newsItemElement));
                }
            } else {
                $newsItem = $this->_getNewsItem($newsComponent['NEWSITEM']);
            }
            $arrNewsComponent['newsItem'] = $newsItem;
        } elseif (isset($newsComponent['NEWSITEMREF'])) {
            if (isset($newsComponent['NEWSITEMREF'][0])) {
                $newsItemRef = array();
                foreach ($newsComponent['NEWSITEMREF'] as $newsItemRefElement) {
                    array_push($newsItemRef, $this->_getNewsItemRef($newsItemRefElement));
                }
            } else {
                $newsItemRef = $this->_getNewsItemRef($newsComponent['NEWSITEMREF']);
            }
            $arrNewsComponent['newsItemRef'] = $newsItemRef;
        }

        return $arrNewsComponent;
    }

    function _getContentItem($contentItem)
    {
        $arrContentItem = array();

        $arrContentMediaTypes = array(
            'types'     => array(
                'Text',
                'Graphic',
                'Photo',
                'Audio',
                'Video',
                'ComplexData'
            ),
            'default'   => 'Text'
        );

        if (isset($contentItem['FORMAT']['attrs']['FORMALNAME'])) {
            $arrContentItem['format'] = addslashes($contentItem['FORMAT']['attrs']['FORMALNAME']);
        }
        $arrContentItem['mediaType'] = (isset($contentItem['MEDIATYPE']['attrs']['FORMALNAME']) && in_array($contentItem['MEDIATYPE']['attrs']['FORMALNAME'], $arrContentMediaTypes['types'])) ? addslashes($contentItem['MEDIATYPE']['attrs']['FORMALNAME']) : $arrContentMediaTypes['default'];

        switch ($arrContentItem['mediaType']) {
            case 'Graphic':
            case 'Photo':
                $arrContentItem['is_ref'] = true;
                $arrContentItem['data'] = addslashes($contentItem['attrs']['HREF']);
                break;

            case 'Text':
            default:
                $arrContentItem['data'] = (isset($arrContentItem['format']) && $arrContentItem['format'] == 'NITF') ? $this->_getNITF($contentItem['DATACONTENT']['NITF']) : addslashes($contentItem['DATACONTENT']['cdata']);
                break;
        }

        if (isset($contentItem['CHARACTERISTICS']['PROPERTY'])) {
            if (isset($contentItem['CHARACTERISTICS']['PROPERTY'][0])) {
                foreach ($contentItem['CHARACTERISTICS']['PROPERTY'] as $arrProperty) {
                    $arrContentItem['properties'][$arrProperty['attrs']['FORMALNAME']] = $arrProperty['attrs']['VALUE'];
                }
            } else {
                $arrContentItem['properties'] = array($contentItem['CHARACTERISTICS']['PROPERTY']['attrs']['FORMALNAME'] => $contentItem['CHARACTERISTICS']['PROPERTY']['attrs']['VALUE']);
            }
        }

        return $arrContentItem;
    }

    function _getNITF($nitfContent)
    {
        $content = '';
        foreach ($nitfContent['cdata'] as $arrdata) {
            $content .= "<p>".$arrdata['data']."</p>";
        }

        return addslashes($content);
    }

    /**
     * @param   mixed   $newsItemRef
     * @return  string                  The empty string
     * @todo    Remove unused $newsItemRef argument
     */
    function _getNewsItemRef($newsItemRef)
    {
        return '';
    }

    /**
    * Delete NewsML document
    *
    * Delete the NewsML document with the id $documentId
    *
    * @access public
    * @param integer $documentId
    * @global object $objDatabase
    * @return boolen true on success, false on failure
    */
    function deleteDocument($documentId)
    {
        global $objDatabase;

        $status = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_feed_newsml_documents WHERE id='".$documentId."'");
        if ($status !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * Delete NewsML category
    *
    * Deletethe NewsML category specified by the $categoryId
    *
    * @access public
    * @param integer $categoryId
    * @global object $objDatabase
    * @return boolean true on success, false on failure
    */
    function deleteCategory($categoryId)
    {
        global $objDatabase;

        if ($objDatabase->Execute("DELETE FROM ".DBPREFIX."module_feed_newsml_categories WHERE id=".$categoryId) !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * Add category
    *
    * Add a new NewsML category
    *
    * @access public
    * @param integer $providerId
    * @param string $categoryName
    * @param array $arrSubjectCodes
    * @param string $subjectCodeMethod
    * @param string $templateHtml
    * @param integer $msgCount
    * @param string $showPics
    * @global object $objDatabase
    * @return boolean true on success, false on failure
    */
    function addCategory($providerId, $categoryName, $arrSubjectCodes, $subjectCodeMethod, $templateHtml, $msgCount, $showPics)
    {
        global $objDatabase;

        if ($objDatabase->Execute("INSERT INTO ".DBPREFIX."module_feed_newsml_categories (
                    providerId,
                    name,
                    subjectCodes,
                    showSubjectCodes,
                    template,
                    `limit`,
                    `showPics`
                    ) VALUES (
                    ".$providerId.",
                    '".$categoryName."',
                    '".implode(',', $arrSubjectCodes)."',
                    '".$subjectCodeMethod."',
                    '".$templateHtml."',
                    ".$msgCount.",
                    '".$showPics."')") !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * Update category
    *
    * Update a NewsML category
    *
    * @access public
    * @param integer $categoryId
    * @param integer $providerId
    * @param string $categoryName
    * @param array $arrSubjectCodes
    * @param string $subjectCodeMethod
    * @param string $templateHtml
    * @param integer $msgCount
    * @param string $showPics
    * @global object $objDatabase
    * @return boolean true on success, false on failure
    */
    function updateCategory($categoryId, $providerId, $categoryName, $arrSubjectCodes, $subjectCodeMethod, $templateHtml, $msgCount, $showPics)
    {
        global $objDatabase;

        if ($objDatabase->Execute("UPDATE ".DBPREFIX."module_feed_newsml_categories
            SET providerId=".$providerId.",
                name='".$categoryName."',
                subjectCodes='".implode(',', $arrSubjectCodes)."',
                showSubjectCodes='".$subjectCodeMethod."',
                template='".$templateHtml."',
                `limit`=".$msgCount.",
                `showPics`='".$showPics."'
            WHERE id=".$categoryId) !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * Get provider menu
    *
    * Return a drop-down menu with the providers
    *
    * @access public
    * @param integer $selectedProviderId
    * @param string $attrs
    * @return string drop-down menu
    */
    function getProviderMenu($selectedProviderId, $attrs)
    {
        $this->_initProviders();

        $menu = "<select $attrs>\n";
        foreach ($this->_arrProviders as $providerId => $providerName) {
            $menu .=
                '<option value="'.$providerId.'"'.
                ($providerId == $selectedProviderId ? ' selected="selected"' : '').
                '>'.$providerName."</option>\n";
        }
        $menu .= "</select>\n";
        return $menu;
    }

    /**
    * Get subject code methods menu
    *
    * Get subject code methods menu
    *
    * @access public
    * @param integer $categoryId
    * @param string $attrs
    * @global array $_ARRAYLANG
    * @return string menu
    */
    function getSubjectCodesMenu($categoryId, $attrs)
    {
        global $_ARRAYLANG;

        $subjectCodeMethod = isset($this->arrCategories[$categoryId]['showSubjectCodes']) ? $this->arrCategories[$categoryId]['showSubjectCodes'] : 'all';
        $menu = "<select ".$attrs.">\n";
        $menu .= "<option value=\"all\"".($subjectCodeMethod == "all" ? " selected=\"selected\"" : "").">".$_ARRAYLANG['TXT_FEED_SHOW_ALL']."</option>\n";
        $menu .= "<option value=\"only\"".($subjectCodeMethod == "only" ? " selected=\"selected\"" : "").">".$_ARRAYLANG['TXT_FEED_ONLY_DISPLAY_SELECTED']."</option>\n";
        $menu .= "<option value=\"exclude\"".($subjectCodeMethod == "exclude" ? " selected=\"selected\"" : "").">".$_ARRAYLANG['TXT_FEED_DISPLAY_ONLY_INDICATED_ONES']."</option>\n";
        $menu .= "</select>\n";

        return $menu;
    }

    /**
    * XML parser start tag
    * @access   private
    * @param    mixed   $parser
    * @param    string  $name
    * @param    array   $attrs
    * @todo     Remove unused $parser argument
    */
    function _xmlStartTag($parser, $name, $attrs)
    {
        $this->_inCDATA = false;

        if (isset($this->_currentXmlElement)) {
            if ($this->_inNITF) {
                if ($this->_inParagraph) {
                    $this->_xmlContentHTMLTag = strtolower($name);
                } else {
                    if ($name == "BODY.CONTENT") {
                        $this->_inParagraph = true;
                    }
                }
            } else {
                if ($name == "NITF") {
                    $this->_inNITF = true;
                }

                if (!isset($this->_currentXmlElement[$name])) {
                    $this->_currentXmlElement[$name] = array();
                    $this->_arrParentXmlElement[$name] = &$this->_currentXmlElement;
                    $this->_currentXmlElement = &$this->_currentXmlElement[$name];
                } else {
                    if (!isset($this->_currentXmlElement[$name][0])) {
                        $arrTmp = $this->_currentXmlElement[$name];
                        unset($this->_currentXmlElement[$name]);// = array();
                        $this->_currentXmlElement[$name][0] = $arrTmp;
                    }

                    array_push($this->_currentXmlElement[$name], array());
                    $this->_arrParentXmlElement[$name] = &$this->_currentXmlElement;
                    $this->_currentXmlElement = &$this->_currentXmlElement[$name][count($this->_currentXmlElement[$name])-1];
                }
            }
        } else{
            $this->_xmlDocument[$name] = array();
            $this->_currentXmlElement = &$this->_xmlDocument[$name];
        }

        if (count($attrs)>0) {
            foreach ($attrs as $key => $value) {
                $this->_currentXmlElement['attrs'][$key] = $value;
            }
        }
    }

    /**
    * XML parser character data tag
    * @access   private
    * @param    mixed   $parser
    * @param    string  $cData
    * @todo     Remove unused $parser argument
    */
    function _xmlCharacterDataTag($parser, $cData)
    {
        if (strlen(trim($cData))) {
            if ($this->_inParagraph) {
//              if (!empty($this->_xmlContentHTMLTag)) {
                if ($this->_inCDATA) {
                    $this->_tmpParagraph[count($this->_tmpParagraph)-1]['data'] .= $cData;
                } else {
                    array_push(
                        $this->_tmpParagraph,
                        array(
                            'type'  => $this->_xmlContentHTMLTag,
                            'data'  => $cData
                        )
                    );

                    $this->_inCDATA = true;
                }
                    //array_push($this->_tmpParagraph, array($this->_xmlContentHTMLTag => .= '<'.$this->_xmlContentHTMLTag.'>'.$cData.'</'.$this->_xmlContentHTMLTag.'>';
//              } else {
//                  array_push(
//                      $this->_tmpParagraph,
//                      array(
//                          'type'  => '',
//                          'data'  => $cData
//                      )
//                  );
//                  //$this->_tmpParagraph .= $cData;
//              }
            } else {
                if (!isset($this->_currentXmlElement['cdata'])) {
                    $this->_currentXmlElement['cdata'] = $cData;
                } else {
                    $this->_currentXmlElement['cdata'] .= $cData;
                }
            }
        }
    }

    /**
    * XML parser end tag
    *
    * @access   private
    * @param    mixed   $parser
    * @param    string  $name
    * @todo     Remove unused $parser argument
    */
    function _xmlEndTag($parser, $name)
    {
        $this->_inCDATA = false;

        if ($this->_inNITF) {
            if ($name == "BODY.CONTENT") {
                $this->_inParagraph = false;
                $this->_xmlContentHTMLTag = '';

//              if (!isset($this->_currentXmlElement['cdata'])) {
//                  $this->_currentXmlElement['cdata'] = "";
//              }
                $this->_currentXmlElement['cdata'] = $this->_tmpParagraph;
                $this->_tmpParagraph = array();
            }

            if ($name == "NITF") {
                $this->_inNITF = false;
            }
        } else {
            $this->_currentXmlElement = &$this->_arrParentXmlElement[$name];
            unset($this->_arrParentXmlElement[$name]);
        }
    }

    /*
    * These functions are for future usage
    *
    function _execNewsManagementInstruction($providerId)
    {
        global $objDatabase;

        $arrNewsMLDocuments = array();

        $objNewsMLDocument = $objDatabase->Execute("SELECT
            publicIdentifier,
            dateId,
            newsItemId,
            revisionId
            FROM ".DBPREFIX."module_feed_newsml_documents
            WHERE providerId=".$providerId."
            ORDER BY dateId, newsItemId, revisionId");
        if ($objNewsMLDocument !== false) {
            while (!$objNewsMLDocument->EOF) {
                $arrNewsMLDocuments[$objNewsMLDocument->fields['dateId']][$objNewsMLDocument->fields['newsItemId']][$objNewsMLDocument->fields['revisionId']] = array(
                    'publicIdentifier'  => $objNewsMLDocument->fields['publicIdentifier'],
                    //'instruction'     => $objNewsMLDocument->
                    'status'            => true
                );
                $objNewsMLDocument->MoveNext();
            }
        }

        foreach ($arrNewsMLDocuments as $dateId => $arrNewsItems) {
            foreach ($arrNewsItems as $newsItemId => $arrRevisions) {
                foreach ($arrRevisions as $revisionId => $arrRevision) {
                    if ($arrRevision['status']) {
                        $this->_SDA_newsManagementInstruction();
                    }
                }
            }
        }
        print_r($arrNewsMLDocuments);
    }

    function _SDA_newsManagementInstruction($instruction)
    {

        switch ($instruction) {
        case 'Rectify': // indicates that the current story replaces all previous versions of the story.

            break;

        case 'Update': // indicates an update, which adds relevant information that is missing in earlier revisions.

            break;

        case 'Delete': // instructs to remove all revisions of the referenced story (full retraction of a news item).

            break;

        case 'LiftEmbargo': // instructs to release a story from embargo.

            break;
        }
    }
    */
}
?>
