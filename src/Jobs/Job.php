<?php /** File containing class Job */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex\Jobs;

use CornyPhoenix\Tex\Exceptions\CompilationException;
use CornyPhoenix\Tex\Exceptions\LogicException;
use CornyPhoenix\Tex\Executables\ExecutableInterface;
use CornyPhoenix\Tex\FileFormat;
use CornyPhoenix\Tex\InteractionMode;
use CornyPhoenix\Tex\Log\Log;
use CornyPhoenix\Tex\Log\LogParser;
use CornyPhoenix\Tex\Repositories\RepositoryInterface;
use CornyPhoenix\Tex\Executables\Tex;
use CornyPhoenix\Tex\Executables\LaTex;
use InvalidArgumentException;

/**
 * Class representing a TeX Job.
 *
 * @package CornyPhoenix\Tex\Jobs
 */
class Job
{

    /**
     * Traits for more functionality.
     */
    use TexTrait;
    use LaTexTrait;
    use BibTexTrait;
    use BlobTrait;

    /**
     * @var ExecutableInterface[]
     * @internal
     */
    private static $executables = array();

    /**
     * The repository which contains this TeX Job.
     *
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Saves if this a run had an error.
     *
     * @var bool
     */
    private $havingErrors;

    /**
     * The output returned by the last process.
     *
     * @var string|null
     */
    private $lastOutput;

    /**
     * The file name for this TeX Job.
     *
     * @var string
     */
    private $name;

    /**
     * Format provided during creation.
     *
     * @var string
     */
    private $inputFormat;

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
     * Creates a new TeX Job by a source file path.
     *
     * @param \CornyPhoenix\Tex\Repositories\RepositoryInterface $repository
     * @param string $name
     * @param string $inputFormat
     */
    public function __construct(RepositoryInterface $repository, $name, $inputFormat)
    {
        $this->setDefaults();

        $this->repository = $repository;
        $this->name = $name;
        $this->inputFormat = $inputFormat;
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
     * Returns the format provided during creation.
     *
     * @return string
     */
    public function getInputFormat()
    {
        return $this->inputFormat;
    }

    /**
     * Returns the input file basename
     *
     * @return string
     */
    public function getInputBasename()
    {
        return $this->name . '.' . $this->inputFormat;
    }

    /**
     * Returns the file path of this TeX Job.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->repository->getDirectory() . '/' . $this->name;
    }

    /**
     * Returns the working directory of this TeX Job.
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->repository->getDirectory();
    }

    /**
     * Returns whether a run had an error.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return $this->havingErrors;
    }

    /**
     * Returns the formats currently provided by this TeX Job.
     *
     * @return string[]
     */
    public function getProvidedFormats()
    {
        return $this->repository->findFormatsByJob($this);
    }

    /**
     * Returns an OO interface for the LaTeX log.
     *
     * @throws LogicException
     * @return Log
     */
    public function createLog()
    {
        if (null === $this->lastOutput) {
            throw new LogicException('You have to run the job first.');
        }

        $parser = new LogParser($this->lastOutput);
        return $parser->parse();
    }

    /**
     * Returns the last output / the log as a string
     *
     * @throws LogicException
     * @return string
     */
    public function getLastOutput()
    {
        if (null === $this->lastOutput) {
            throw new LogicException('You have to run the job first.');
        }

        return $this->lastOutput;
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
    public function isDraftMode()
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
    public function isShellEscape()
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
     * Returns the blob string for a given output format.
     *
     * @param string $format
     * @return string
     * @throws \CornyPhoenix\Tex\Exceptions\LogicException
     */
    public function getBlob($format)
    {
        if (!in_array($format, $this->getProvidedFormats())) {
            throw new LogicException('There is no file with format `' . $format . '` existing.');
        }

        return $this->repository->getFileBlob($this->getName() . '.' . $format);
    }

    /**
     * Runs an executable on this TeX Job.
     *
     * @param string $executableClass
     * @param callable $callback
     * @throws \CornyPhoenix\Tex\Exceptions\CompilationException
     * @throws \CornyPhoenix\Tex\Exceptions\MissingExecutableException
     * @return $this
     */
    public function run($executableClass, callable $callback = null)
    {
        if (!$this->hasErrors()) {
            $executable = $this->findExecutableByClass($executableClass);

            // Get a process
            $process = $executable->runJob($this, $callback);

            // Get output for logging purposes
            $this->lastOutput = $process->getOutput();

            // Error handling
            if (1 === $process->getExitCode()) {
                $this->havingErrors = true; // Prevents further runs
                throw $this->createCompilationException();
            }
        }

        return $this;
    }

    /**
     * Cleans the job directory.
     *
     * Only TeX files will be deleted.
     * The input file will be saved.
     *
     * @return Job
     */
    public function clean()
    {
        foreach (glob($this->getPath() . '.*') as $file) {
            $format = FileFormat::fromPath($file);
            if ($format !== $this->getInputFormat() && FileFormat::isKnownFormat($format)) {
                unlink($file);
            }
        }

        return $this;
    }

    /**
     * Sets default values on the job.
     */
    protected function setDefaults()
    {
        $this->interactionMode = InteractionMode::NONSTOP_MODE;
        $this->outputDirectory = null;
        $this->jobname = null;
        $this->syncTex = null;
        $this->shellEscape = false;
        $this->draftMode = false;
        $this->havingErrors = false;
        $this->lastOutput = null;
    }

    /**
     * Finds the executable by a class name.
     *
     * @param string $executableClass
     * @return \CornyPhoenix\Tex\Executables\ExecutableInterface
     * @throws \CornyPhoenix\Tex\Exceptions\MissingExecutableException
     */
    private function findExecutableByClass($executableClass)
    {
        if (!isset(self::$executables[$executableClass])) {
            self::$executables[$executableClass] = new $executableClass();
        }

        return self::$executables[$executableClass];
    }

    /**
     * Creates a CompilationException.
     *
     * @return CompilationException
     */
    private function createCompilationException()
    {
        return new CompilationException(sprintf('An error occurred during compilation of job %s.', $this->getName()));
    }
}
