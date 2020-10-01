<?php

namespace Xand\Component\Security\Encoder;

/**
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface EncoderInterface
{
	/**
	 * @param string $raw
	 * @param string $salt
	 * 
	 * @return string
	 */
	public function encodePassword($raw, $salt);
	
	/**
	 * @param string $encoded
	 * @param string $raw
	 * @param string $salt
	 * 
	 * @return bool
	 */
	public function isPasswordValid($encoded, $raw, $salt);
}