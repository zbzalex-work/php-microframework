<?php

namespace Xand\Component\Debug\Formatter;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ExceptionFormatter
{
    /**
     * @param Exception	$e
     * @param mixed		$caused
     *
     * @return string
     */
    public function format(
        /*\Exception*/ $e,
                       $caused = false
    )
    {
        $stringBuffer   = [];
        $stringBuffer[] = sprintf('%s%s: %s',
            $caused ? ' Caused by ' : '',
            get_class($e),
            $e->getMessage()
        );

        $trace = $e->getTrace();

        $file = $e->getFile();
        $line = $e->getLine();

        while(true) {
            $stringBuffer[] = sprintf(' at %s%s%s(%s%s%s)',
                count($trace) && isset($trace[0]['class'])
                    ? str_replace('\\', '.', $trace[0]['class'])
                    : '',
                count($trace) && isset($trace[0]['class'])
                && isset($trace[0]['function'])
                    ? '.'
                    : '',
                count($trace) && isset($trace[0]['function'])
                    ? str_replace('\\', '.', $trace[0]['function'])
                    : '(main)',
                $line === null
                    ? $file : basename($file),
                $line === null
                    ? ''
                    : ':',
                $line === null
                    ? ''
                    : $line);

            if (false == $trace)
                break;

            $file = isset($trace[0]['file'])
                ? $trace[0]['file']
                : 'Unknown Source';

            $line = isset($trace[0]['file'])
            && isset($trace[0]['line'])
                ? $trace[0]['line']
                : null;

            array_shift($trace);
        }

        $output = implode("\n", $stringBuffer);
        if (null !== ($prev = $e->getPrevious())) $output .= "\n" . static::format($prev, 1);

        return $output;
    }
}