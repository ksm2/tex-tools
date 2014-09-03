<?php

namespace CornyPhoenix\Tex;

use CornyPhoenix\Tex\Executables\ExecutableInterface;
use CornyPhoenix\Tex\Jobs\Job;
use Symfony\Component\Process\ProcessBuilder;

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
     * @var ExecutableInterface
     */
    private $executable;

    /**
     * @param Executables\ExecutableInterface $executable
     */
    public function __construct(ExecutableInterface $executable)
    {
        parent::__construct();

        // Set application to execute
        $this->setExecutable($executable);
    }

    /**
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

        // Set input file
        $this->setWorkingDirectory($job->getDirectory());

        // Suffix
        $this->setOutputFormat();
        $this->setInputFile($job);

        return $this;
    }

    /**
     * @return ExecutableInterface
     */
    public function getExecutable()
    {
        return $this->executable;
    }

    /**
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
     * @param Job $job
     */
    private function setInputFile(Job $job)
    {
        $this->add($job->getName() . '.' . $this->executable->getInputFormat());
    }

    /**
     * Sets a an option in the arguments, like --$option=$value.
     * If $value is null, no option will be added.
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
     * Sets a an bool option in the arguments, like --$option.
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
