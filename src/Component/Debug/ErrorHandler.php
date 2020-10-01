<?php

namespace Xand\Component\Debug;
use Xand\Component\Debug\Formatter\ExceptionFormatter;
use Xand\Component\Log\LoggerInterface;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * @var ExceptionFormatter
     */
    protected $exceptionFormatter;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var int
     */
    protected $scopedErrors = E_ALL;

    protected $onException;

    /**
     * ErrorHandler constructor.
     *
     * @param ExceptionFormatter|null $exceptionFormatter
     */
    public function __construct(ExceptionFormatter $exceptionFormatter = null)
    {
        $this->exceptionFormatter = null === $exceptionFormatter ? new ExceptionFormatter() : $exceptionFormatter;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return static
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @param int   $level
     *
     * @return static
     */
    public function scopedAt($level)
    {
        $this->scopedErrors = $level;

        return $this;
    }

    public static function register(ErrorHandlerInterface $handler = null)
    {

        if (null === $handler) {
            $handler = new static(new ExceptionFormatter());
        }

        register_shutdown_function([
            $handler, 'handleFatalError'
        ]);
        set_error_handler([
            $handler, 'handleError'
        ]);
        set_exception_handler([
            $handler, 'handleUncaughtException'
        ]);

    }

    public function onException($onException)
    {
        $this->onException = $onException;

        return $this;
    }

    public function handleFatalError()
    {
        if (null !== ($error = error_get_last()) && $error['type'] <= $this->scopedErrors)
            $this->handleUncaughtException(new \ErrorException($error['message']));
    }

    public function handleError($severity, $message, $file, $line)
    {
        if ($severity <= $this->scopedErrors)
            $this->handleUncaughtException(new \ErrorException($message));
    }

    public function handleUncaughtException(\Exception $e)
    {
        \call_user_func($this->onException, $e);
    }

    /**
	 * @param int	$severity
	 * 
	 * @return string
	 */
	public static function getFriendlyErrorType($severity)
	{
		switch ($severity) {
            case E_ERROR:
                return 'Error'; // 1
            case E_WARNING:
                return 'Warning'; // 2
            case E_PARSE:
                return 'Parse'; // 4
            case E_NOTICE:
                return 'Notice'; // 8
            case E_CORE_ERROR:
                return 'Core-Error'; // 16
            case E_CORE_WARNING:
                return 'Core Warning'; // 32
            case E_COMPILE_ERROR:
                return 'Compile Error'; // 64
            case E_COMPILE_WARNING:
                return 'Compile Warning'; // 128
            case E_USER_ERROR:
                return 'User Error'; // 256
            case E_USER_WARNING:
                return 'User Warning'; // 512
            case E_USER_NOTICE:
                return 'User Notice'; // 1024
            case E_STRICT:
                return 'Strict'; // 2048
            case E_RECOVERABLE_ERROR:
                return 'Recoverable Error'; // 4096
            case E_DEPRECATED:
                return 'Deprecated'; // 8192
            case E_USER_DEPRECATED:
                return 'User Deprecated'; // 16384
            default:
                return 'Error';
        }
	}
}