<?php /** File containing class Job */

namespace CornyPhoenix\Tex\Jobs;

use CornyPhoenix\Tex\Exceptions\LogicException;
use CornyPhoenix\Tex\Executables\ExecutableInterface;
use CornyPhoenix\Tex\FileFormat;
use CornyPhoenix\Tex\InteractionMode;
use CornyPhoenix\Tex\Results\ErrorResult;
use CornyPhoenix\Tex\Results\ResultInterface;
use InvalidArgumentException;

/**
 * Class representing a TeX Job.
 *
 * @package CornyPhoenix\Tex\Jobs
 */
class Job
{

    /**
     * @var ExecutableInterface[]
     * @internal
     */
    private static $executables = array();

    /**
     * Saves if this a run had an error.
     *
     * @var bool
     */
    private $hasErrors;

    /**
     * @var ResultInterface
     */
    private $result;

    /**
     * The file name for this TeX Job.
     *
     * @var string
     */
    private $name;

    /**
     * The working directory of this TeX Job.
     *
     * @var string
     */
    private $directory;

    /**
     * Format provided during creation.
     *
     * @var string
     */
    private $inputFormat;

    /**
     * Formats currently provided by this TeX Job.
     *
     * @var string[]
     */
    private $providedFormats;

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
     * The TeX output directory argument.
     *
     * @var string|null
     */
    private $outputDirectory;

    /**
     * The TeX draft mode argument.
     *
     * @var bool
     */
    private $draftMode;

    /**
     * The TeX shell escape argument.
     *
     * @var bool
     */
    private $shellEscape;

    /**
     * The SyncTeX argument.
     *
     * @var int|null
     */
    private $syncTex;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->setDefaults();
        $this->setPath($path);
    }

    /**
     * Returns the file name for this TeX Job.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the working directory of this TeX Job.
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Returns the format provided during creation.
     *
     * @return string
     */
    public function getInputFormat()
    {
        return $this->inputFormat;
    }

    /**
     * Returns whether a run had an error.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return $this->hasErrors;
    }

    /**
     * Returns the formats currently provided by this TeX Job.
     *
     * @return string[]
     */
    public function getProvidedFormats()
    {
        return $this->providedFormats;
    }

    /**
     * @throws LogicException
     * @return ResultInterface
     */
    public function getResult()
    {
        if (null === $this->result) {
            throw new LogicException('You have to run this job first.');
        }

        return $this->result;
    }

    /**
     * Returns an alternative jobname which will be passed to TeX.
     *
     * @return null|string
     */
    public function getJobname()
    {
        return $this->jobname;
    }

    /**
     * Sets an alternative jobname which will be passed to TeX.
     *
     * @param null|string $jobname
     * @return $this
     */
    public function setJobname($jobname)
    {
        $this->jobname = $jobname;
        return $this;
    }

    /**
     * Returns the TeX draft mode argument.
     *
     * @return bool
     */
    public function getDraftMode()
    {
        return $this->draftMode;
    }

    /**
     * Sets the TeX draft mode argument.
     *
     * @param bool $draftMode
     * @return $this
     */
    public function setDraftMode($draftMode)
    {
        $this->draftMode = boolval($draftMode);
        return $this;
    }

    /**
     * Returns the Mode in which the job will be executed.
     *
     * @return string
     */
    public function getInteractionMode()
    {
        return $this->interactionMode;
    }

    /**
     * Sets the Mode in which the job will be executed.
     *
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
     * Returns the TeX output directory argument.
     *
     * @return string
     */
    public function getOutputDirectory()
    {
        return $this->outputDirectory;
    }

    /**
     * Sets the TeX output directory argument.
     *
     * @param string $outputDirectory
     * @return $this
     */
    public function setOutputDirectory($outputDirectory)
    {
        $this->outputDirectory = $outputDirectory;
        return $this;
    }

    /**
     * Returns the TeX shell escape argument.
     *
     * @return boolean
     */
    public function getShellEscape()
    {
        return $this->shellEscape;
    }

    /**
     * Sets the TeX shell escape argument.
     *
     * @param boolean $shellEscape
     * @return $this
     */
    public function setShellEscape($shellEscape)
    {
        $this->shellEscape = boolval($shellEscape);
        return $this;
    }

    /**
     * Returns the SyncTeX argument.
     *
     * @return int
     */
    public function getSyncTex()
    {
        return $this->syncTex;
    }

    /**
     * Sets the SyncTeX argument.
     *
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
     * Runs an executable on this TeX Job.
     *
     * @param string $executableClass
     * @param callable $callback
     * @return $this
     */
    public function run($executableClass, callable $callback = null)
    {
        if (!$this->hasErrors) {
            $executable = $this->findExecutableByClass($executableClass);

            $process = $executable->runJob($this, $callback);
            if (1 === $process->getExitCode()) {
                $this->hasErrors = true;
                $this->result = $this->createErrorResult($process->getOutput());
            }
        }

        return $this;
    }

    /**
     * Adds more formats provided by this Job.
     *
     * @param string[] $formats
     */
    public function addProvidedFormats(array $formats)
    {
        $this->providedFormats = array_unique(array_merge($this->providedFormats, $formats));
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
        $this->hasErrors = false;
        $this->result = null;
    }

    /**
     * Returns the file path of this TeX Job.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->directory . '/' . $this->name;
    }

    /**
     * Sets the file path of this TeX Job.
     *
     * @param string $path
     * @return $this
     */
    private function setPath($path)
    {
        $this->inputFormat = FileFormat::fromPath($path);
        $this->directory = dirname($path);
        $this->name = $this->findNameByPath($path);

        $this->providedFormats = [$this->inputFormat];

        return $this;
    }

    /**
     * Finds the executable by a class name.
     *
     * @param string $executableClass
     * @return \CornyPhoenix\Tex\Executables\ExecutableInterface
     * @internal
     */
    private function findExecutableByClass($executableClass)
    {
        if (!isset(self::$executables[$executableClass])) {
            self::$executables[$executableClass] = new $executableClass();
        }

        return self::$executables[$executableClass];
    }

    /**
     * Creates an error result.
     *
     * @param string $output
     * @return ErrorResult
     */
    private function createErrorResult($output)
    {
        return new ErrorResult($output);
    }

    /**
     * Finds the Job name by an absolute file path.
     *
     * @param $path
     * @return string
     */
    private function findNameByPath($path)
    {
        $directoryLength = strlen($this->directory);
        $formatLength = strlen($this->inputFormat);
        $name = substr($path, $directoryLength + 1, strlen($path) - $directoryLength - $formatLength - 2);
        return $name;
    }
}
