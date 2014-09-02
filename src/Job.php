<?php

namespace CornyPhoenix\Tex;

use InvalidArgumentException;

class Job
{

    /**
     * @var string
     */
    private $executablePath;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $directory;

    /**
     * @var string
     */
    private $inputFormat;

    /**
     * @var string
     */
    private $outputFormat;

    /**
     * An alternative jobname which will be passed to TeX.
     *
     * @var string|null
     */
    private $jobname;

    /**
     * The Mode in which the job will be executed.
     *
     * @var string
     */
    private $interactionMode;

    /**
     * @var string|null
     */
    private $outputDirectory;

    /**
     * @var bool
     */
    private $draftMode;

    /**
     * @var bool
     */
    private $shellEscape;

    /**
     * @var int|null
     */
    private $syncTex;

    /**
     * @param $executablePath
     * @param string $name
     * @param string $directory
     * @param $inputFormat
     * @param $outputFormat
     */
    public function __construct($executablePath, $name, $directory, $inputFormat, $outputFormat)
    {
        $this->executablePath = $executablePath;
        $this->name = $name;
        $this->directory = $directory;
        $this->inputFormat = $inputFormat;
        $this->outputFormat = $outputFormat;

        $this->setDefaults();
    }

    /**
     * @return string
     */
    public function getExecutablePath()
    {
        return $this->executablePath;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @return string
     */
    public function getInputFormat()
    {
        return $this->inputFormat;
    }

    /**
     * @return string
     */
    public function getOutputFormat()
    {
        return $this->outputFormat;
    }

    /**
     * @return string
     */
    public function getInputFileName()
    {
        return $this->name . '.' . $this->inputFormat;
    }

    /**
     * @return string
     */
    public function getOutputFileName()
    {
        return $this->name . '.' . $this->outputFormat;
    }

    /**
     * @return null|string
     */
    public function getJobname()
    {
        return $this->jobname;
    }

    /**
     * @param null|string $jobname
     * @return $this
     */
    public function setJobname($jobname)
    {
        $this->jobname = $jobname;
        return $this;
    }

    /**
     * @return bool
     */
    public function getDraftMode()
    {
        return $this->draftMode;
    }

    /**
     * @param bool $draftMode
     * @return $this
     */
    public function setDraftMode($draftMode)
    {
        $this->draftMode = boolval($draftMode);
        return $this;
    }

    /**
     * @return string
     */
    public function getInteractionMode()
    {
        return $this->interactionMode;
    }

    /**
     * @param string $interactionMode
     * @throws InvalidArgumentException
     * @return $this
     */
    public function setInteractionMode($interactionMode)
    {
        if (!InteractionMode::modeExists($interactionMode)) {
            throw new InvalidArgumentException('You specified a wring interaction mode "' . $interactionMode . '"');
        }

        $this->interactionMode = $interactionMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getOutputDirectory()
    {
        return $this->outputDirectory;
    }

    /**
     * @param string $outputDirectory
     * @return $this
     */
    public function setOutputDirectory($outputDirectory)
    {
        $this->outputDirectory = $outputDirectory;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getShellEscape()
    {
        return $this->shellEscape;
    }

    /**
     * @param boolean $shellEscape
     * @return $this
     */
    public function setShellEscape($shellEscape)
    {
        $this->shellEscape = boolval($shellEscape);
        return $this;
    }

    /**
     * @return int
     */
    public function getSyncTex()
    {
        return $this->syncTex;
    }

    /**
     * @param int|null $syncTex
     * @return $this
     */
    public function setSyncTex($syncTex)
    {
        if (null === $syncTex) {
            $this->syncTex = null;
        } else {
            $this->syncTex = intval($syncTex);
        }

        return $this;
    }

    /**
     * Sets default values on the job.
     */
    private function setDefaults()
    {
        $this->interactionMode = InteractionMode::NONSTOP_MODE;
        $this->outputDirectory = null;
        $this->jobname = null;
        $this->syncTex = null;
        $this->shellEscape = false;
        $this->draftMode = false;
    }
}
