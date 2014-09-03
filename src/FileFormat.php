<?php /** File containing helper class FileFormat */

namespace CornyPhoenix\Tex;

/**
 * Helper class for TeX file formats.
 *
 * @package CornyPhoenix\Tex
 */
class FileFormat
{

    // TeX specific files
    const TEX = 'tex';
    const AUXILIARY = 'aux';
    const LOG = 'log';
    const SYNC_TEX = 'synctex.gz';

    // Binary
    const PDF = 'pdf';
    const DVI = 'dvi';
    const POST_SCRIPT = 'ps';

    // Bibliography
    const BIBLIOGRAPHY_ENTRIES = 'bbl';
    const BIBLIOGRAPHY_LOG = 'blg';

    // Index
    const INDEX = 'idx';
    const INDEX_LOG = 'ilg';
    const INDEX_AUXILIARY = 'ind';

    // Lists
    const LIST_OF_FIGURES = 'lof';
    const LIST_OF_TABLES = 'lot';
    const LIST_OF_LISTINGS = 'lol';
    const TABLE_OF_CONTENTS = 'toc';

    /**
     * Known file format descriptions
     *
     * @var array
     */
    private static $descriptions = array(
        self::TEX => 'TeX source file',
        self::AUXILIARY => 'TeX auxiliary file',
        self::LOG => 'logfile',
        self::SYNC_TEX => 'SyncTeX archive',
        self::PDF => 'Portable Document Format',
        self::DVI => 'DeVice Independent file format',
        self::POST_SCRIPT => 'PostScript format',
        self::BIBLIOGRAPHY_ENTRIES => 'Bibliography entry list',
        self::BIBLIOGRAPHY_LOG => 'Bibliography logfile',
        self::INDEX => 'Index file format',
        self::INDEX_LOG => 'Index logfile',
        self::INDEX_AUXILIARY => 'Index auxiliary file',
        self::LIST_OF_FIGURES => 'List of figures',
        self::LIST_OF_TABLES => 'List of tables',
        self::LIST_OF_LISTINGS => 'List of listings',
        self::TABLE_OF_CONTENTS => 'Table of contents',
    );

    /**
     * Describes a file format.
     * Returns <code>null</code>, if $format is unknown.
     *
     * @param string $format
     * @return string|null
     */
    public static function describe($format)
    {
        if (self::isKnownFormat($format)) {
            return self::$descriptions[$format];
        } else {
            return null;
        }
    }

    /**
     * Determines whether a format is known to TeX.
     *
     * @param string $format
     * @return bool
     */
    public static function isKnownFormat($format)
    {
        return isset(self::$descriptions[$format]);
    }

    /**
     * Finds the file format of a given path.
     *
     * @param string $path
     * @return string|null
     */
    public static function fromPath($path)
    {
        $basename = basename($path);
        $pos = strpos($basename, '.');
        if (false === $pos) {
            return null;
        } else {
            return substr($basename, $pos + 1);
        }
    }

    /**
     * Should never be instantiated.
     */
    private function __construct()
    {
    }
}
