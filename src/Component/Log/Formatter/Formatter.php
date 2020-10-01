<?php

namespace Xand\Component\Log\Formatter;
use Xand\Component\Log\LogRecordInterface;
use Xand\Component\Log\LogLevel;

/**
 * Class Formatter
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Formatter implements FormatterInterface
{
	/**
	 * @param int $level
	 * 
	 * @return string
	 */
	public static function getFriendlyLogLevel($level)
	{
		switch($level) {
			case LogLevel::INFO :
				{
					return 'INFO';
				}
				break;
			case LogLevel::WARNING :
				{
					return 'WARNING';
				}
				break;
			case LogLevel::ERROR :
				{
					return 'ERROR';
				}
				break;
            case LogLevel::FATAL:
                {
                    return 'FATAL ERROR';
                }
                break;
            default :
            case LogLevel::DEBUG :
                {
                    return 'DEBUG';
                }
                break;
		}
	}

    /**
     * {@inheritdoc}
     */
	public function format(LogRecordInterface $record)
	{
		return sprintf(
		    '[%s][%s] %s',
			date('Y-m-d/H:i:s'),
			static::getFriendlyLogLevel($record->getLevel()),
			$record->getMessage()
        );
	}
}