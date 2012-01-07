<?php

namespace Xaddax\OpenDocumentBundle\Model;

use \OpenDocument_Storage_Zip;

/*
 * This file is part of the Xaddax\OpenDocumentBundle
 *
 * (c) Luis Cordova <cordoval@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * OpenDocument Manager.
 *
 * @author      Luis Cordova <cordoval@gmail.com>
 */
class OpenDocumentManager
{
    /**
     * Manifest namespace
     */
    const NS_MANIFEST = 'urn:oasis:names:tc:opendocument:xmlns:manifest:1.0';

    /**
     * text namespace URL
     */
    const NS_TEXT = 'urn:oasis:names:tc:opendocument:xmlns:text:1.0';

    /**
     * style namespace URL
     */
    const NS_STYLE = 'urn:oasis:names:tc:opendocument:xmlns:style:1.0';

    /**
     * fo namespace URL
     */
    const NS_FO = 'urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0';

    /**
     * office namespace URL
     */
    const NS_OFFICE = 'urn:oasis:names:tc:opendocument:xmlns:office:1.0';

    /**
     * svg namespace URL
     */
    const NS_SVG = 'urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0';

    /**
     * xlink namespace URL
     */
    const NS_XLINK = 'http://www.w3.org/1999/xlink';

    /**
     * Array of supported document types.
     *
     * @var array
     *
     * @usedby create()
     */
    public static $documenttypes = array(
        'text',
        'spreadsheet',
        'presentation',
        'drawing',
        'image',
        'chart',
    );

    public function __construct()
    {

    }

    /**
     * Creates and returns a new OpenDocument document object.
     *
     * @param string $type    Type of document to create: 'text', 'spreadsheet',
     *                        'drawing', 'chart', 'image', 'presentation'
     * @param string $file    Name of the file to be saved as
     * @param mixed  $storage Storage class or object to use. Object need to
     *                        implement OpenDocument_Storage
     *
     * @return OpenDocument_Document Document object
     *
     * @throws OpenDocument_Exception In case the type is unsupported, or
     *                                the document or storage class cannot
     *                                be loaded
     *
     * @see text()
     * @see spreadsheet()
     * @see presentation()
     * @see drawing()
     * @see chart()
     * @see image()
     *
     * @uses $documenttypes
     * @uses includeClassFile
     */
    public function create($type, $file = null, $storage = null)
    {
        if (!in_array($type, self::$documenttypes)) {
            throw new OpenDocument_Exception(
                'Unsupported document type ' . $type
            );
        }
        $class = 'OpenDocument_Document_' . ucfirst($type);

        if ($storage === null) {
            $storage = 'OpenDocument_Storage_Zip';
        }
        if (is_string($storage)) {
            $storage = new $storage();
            $storage->create($type, $file);
        } else if (!$storage instanceof OpenDocument_Storage) {
            throw new OpenDocument_Exception(
                'Storage must implement OpenDocument_Storage interface'
            );
        }

        return new $class($storage);
    }//public static function create(..)


    /**
     * Creates and returns a new text document.
     *
     * @param string $file    Name of file that will be saved
     * @param mixed  $storage Storage class or object to use
     *
     * @return OpenDocument_Document_Text
     *
     * @see create()
     */
    public function text($file = null, $storage = null)
    {
        return $this->create('text', $file, $storage);
    }

    /**
     * Open the given file
     *
     * @param string $file Name (path) of file to open
     *
     * @return OpenDocument_Document A document object
     *
     * @throw OpenDocument_Exception
     */
    public function open($file)
    {
        //FIXME: detect correct storage
        $storage = new OpenDocument_Storage_Zip();
        $storage->open($file);

        $mimetype = $storage->getMimeType();

        switch ($mimetype) {
        case 'application/vnd.oasis.opendocument.text':
            $class = 'OpenDocument_Document_Text';
            break;
        default:
            throw new OpenDocument_Exception(
                'Unsupported MIME type ' . $mimetype
            );
            break;
        }

        return new $class($storage);
    }//public static function open($file)


}