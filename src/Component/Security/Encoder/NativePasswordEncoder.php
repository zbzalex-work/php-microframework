<?php

namespace Xand\Component\Security\Encoder;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class NativePasswordEncoder implements EncoderInterface
{
	/**
	 * @param string $raw
	 * @param string $salt
	 * 
	 * @return string
	 */
	public function encodePassword($raw,$salt = null)
	{
		return \hash('sha256', \sprintf('%s$1%s$2', $raw, $salt));
	}
	
	/**
	 * @param string $encoded
	 * @param string $raw
	 * @param string $salt
	 * 
	 * @return string
	 */
	public function isPasswordValid($encoded, $raw, $salt = null)
	{
		return $encoded == $this->encodePassword($raw, $salt);
	}
}