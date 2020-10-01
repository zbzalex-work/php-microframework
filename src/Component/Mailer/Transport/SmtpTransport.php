<?php

namespace Xand\Component\Mailer\Transport;

/**
 * Class SmtpTransport
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class SmtpTransport extends Transport
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $port;

    /**
     * @var string
     */
    protected $enc;

    /**
     * Dsn constructor.
     *
     * @param string $host
     * @param string $port
     * @param string $enc
     */
    public function __construct($host, $port, $enc)
    {
        $this->host = $host;
        $this->port = $port;
        $this->enc = $enc;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return static
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     *
     * @return static
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return string
     */
    public function getEncryption()
    {
        return $this->enc;
    }

    /**
     * @param string $enc
     *
     * @return static
     */
    public function setEncryption($enc)
    {
        $this->enc = $enc;

        return $this;
    }
}