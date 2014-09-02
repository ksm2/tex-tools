<?php

namespace CornyPhoenix\Tex;

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
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        parent::__construct();

        $this->setJob($job);
    }

    /**
     * @param Job $job
     * @return $this
     */
    public function setJob(Job $job)
    {
        // Clear the job
        $this->clearArguments();

        // Set application to execute
        $this->setPrefix($job->getExecutablePath());

        // Set values
        $this->setArgumentValue(self::OPTION_JOBNAME, $job->getJobname());
        $this->setArgumentValue(self::OPTION_INTERACTION_MODE, $job->getInteractionMode());
        $this->setArgumentValue(self::OPTION_SYNC_TEX, $job->getSyncTex());
        $this->setArgumentValue(self::OPTION_OUTPUT_FORMAT, $job->getOutputFormat());
        $this->setArgumentValue(self::OPTION_OUTPUT_DIRECTORY, $job->getOutputDirectory());

        // Set bool arguments
        $this->setArgumentBool(self::OPTION_SHELL_ESCAPE, $job->getShellEscape());
        $this->setArgumentBool(self::OPTION_NO_SHELL_ESCAPE, !$job->getShellEscape());
        $this->setArgumentBool(self::OPTION_DRAFT_MODE, $job->getDraftMode());

        // Set input file
        $this->setWorkingDirectory($job->getDirectory());
        $this->add($job->getInputFileName());

        return $this;
    }

    /**
     * Sets a an option in the arguments, like --$option=$value.
     * If $value is null, no option will be added.
     *
     * @param string $option
     * @param mixed|null $value
     * @return JobProcessBuilder
     */
    public function setArgumentValue($option, $value)
    {
        if (null !== $value) {
            $this->add(sprintf('--%s=%s', $option, strval($value)));
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
    public function setArgumentBool($option, $bool)
    {
        if ($bool) {
            $this->add(sprintf('--%s', $option));
        }
        return $this;
    }

    /**
     * Clears all arguments. The prefix remains.
     */
    public function clearArguments()
    {
        $this->setArguments(array());
    }
}
