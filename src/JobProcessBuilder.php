<?php /** File containing class JobProcessBuilder */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex;

use CornyPhoenix\Tex\Executables\ExecutableInterface;
use CornyPhoenix\Tex\Jobs\Job;
use Symfony\Component\Process\ProcessBuilder;

/**
 * ProcessBuilder for TeX Jobs.
 *
 * @package CornyPhoenix\Tex
 */
class JobProcessBuilder extends ProcessBuilder
{
    const OPTION_JOBNAME = 'jobname';
    const OPTION_INTERACTION_MODE = 'interaction';
    const OPTION_SYNC_TEX = 'synctex';
    const OPTION_OUTPUT_FORMAT = 'output-format';
    const OPTION_OUTPUT_DIRECTORY = 'output-directory';
    const OPTION_SHELL_ESCAPE = 'shell-escape';
    const OPTION_NO_SHELL_ESCAPE = 'no-shell-escape';
    const OPTION_DRAFT_MODE = 'draftmode';

    /**
     * The executable operating this process builder.
     *
     * @var ExecutableInterface
     */
    private $executable;

    /**
     * Creates a new TeX Job Process Builder.
     *
     * @param Executables\ExecutableInterface $executable
     */
    public function __construct(ExecutableInterface $executable)
    {
        parent::__construct();

        // Set application to execute
        $this->setExecutable($executable);
    }

    /**
     * Sets the processed TeX Job.
     *
     * @param Job $job
     * @return $this
     */
    public function setJob(Job $job)
    {
        // Clear the job
        $this->clearArguments();

        // Set values
        $this->setArgumentValue(self::OPTION_JOBNAME, $job->getJobname());
        $this->setArgumentValue(self::OPTION_INTERACTION_MODE, $job->getInteractionMode());
        $this->setArgumentValue(self::OPTION_SYNC_TEX, $job->getSyncTex());
        $this->setArgumentValue(self::OPTION_OUTPUT_DIRECTORY, $job->getOutputDirectory());

        // Set bool arguments
        $this->setArgumentBool(self::OPTION_SHELL_ESCAPE, $job->getShellEscape());
        $this->setArgumentBool(self::OPTION_NO_SHELL_ESCAPE, !$job->getShellEscape());
        $this->setArgumentBool(self::OPTION_DRAFT_MODE, $job->getDraftMode());

        $this->setOutputFormat();

        // Set input file
        $this->setInputFile($job);

        return $this;
    }

    /**
     * Returns the executable operating this process builder.
     *
     * @return ExecutableInterface
     */
    public function getExecutable()
    {
        return $this->executable;
    }

    /**
     * Sets the executable operating this process builder.
     *
     * @param ExecutableInterface $executable
     * @return $this
     */
    public function setExecutable(ExecutableInterface $executable)
    {
        $this->executable = $executable;
        $this->setPrefix($executable->getPath());

        return $this;
    }

    /**
     * Sets the output format argument.
     *
     * @return $this
     */
    private function setOutputFormat()
    {
        if (in_array($this->executable->getOutputFormats(), [FileFormat::PDF, FileFormat::DVI])) {
            $this->setArgumentValue(self::OPTION_OUTPUT_FORMAT, $this->executable->getOutputFormats());
        }

        return $this;
    }

    /**
     * Sets the input file processed.
     *
     * @param Job $job
     */
    private function setInputFile(Job $job)
    {
        $this->setWorkingDirectory($job->getDirectory());
        $this->add($job->getName() . '.' . $this->executable->getInputFormat());
    }

    /**
     * Sets an option in the arguments, like <pre>--$option=$value</pre>
     * If <code>$value</code> is <code>null</code>, no option will be added.
     *
     * @param string $option
     * @param mixed|null $value
     * @return JobProcessBuilder
     */
    private function setArgumentValue($option, $value)
    {
        if (null !== $value) {
            $this->add(sprintf('%s%s=%s', $this->executable->getOptionPrefix(), $option, strval($value)));
        }
        return $this;
    }

    /**
     * Sets a an bool option in the arguments, like <pre>--$option</pre>.
     *
     * @param string $option
     * @param bool $bool
     * @return JobProcessBuilder
     */
    private function setArgumentBool($option, $bool)
    {
        if ($bool) {
            $this->add(sprintf('%s%s', $this->executable->getOptionPrefix(), $option));
        }
        return $this;
    }

    /**
     * Clears all arguments. The prefix remains.
     */
    private function clearArguments()
    {
        $this->setArguments(array());
    }
}
