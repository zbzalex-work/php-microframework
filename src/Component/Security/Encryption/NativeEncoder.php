<?php

namespace Xand\Component\Security\Encryption;

/**
 * Class NativeEncoder
 *
//$encoder = new \Xand\Component\Security\Encryption\NativeEncoder("this my secret key");
//// To encode:
//$encoded = $encoder->encode("raw string");
//// Output:
//echo $encoded;
//// 	SSI
//// To decode:
//$encoded_bytes = NativeEncoder::string2bytes($encoded);
//echo $encoder->decode($encoded_bytes);
//// Output:
//// raw string
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class NativeEncoder
{
    /**
     * @var string
     */
    protected $key;

    /**
     * NativeEncoder constructor.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param string $raw
     *
     * @return mixed
     */
    public function encode($raw)
    {
        $v = static::string2bytes($raw);
        $vlen = \count($v);
        $k = static::string2bytes($this->key);
        $klen = \count($k);
        $i = 0;

        $result = [];
        do {
            $result[$i] = $v[$i] ^ $k[$i % $klen];
        } while(++$i < $vlen);

        //return $result;
        return static::bytes2string($result);
    }

    /**
     * @param array $bytes
     *
     * @return mixed
     */
    public function decode(array $bytes)
    {
        $v = $bytes;
        $vlen = \count($v);
        $k = static::string2bytes($this->key);
        $klen = \count($k);
        $result = [];
        $i = 0;
        do {
            $result[$i] = $v[$i] ^ $k[$i % $klen];
        } while(++$i < $vlen);

        return static::bytes2string($result);
    }

    /**
     * @param string $str
     *
     * @return array
     */
    public static function string2bytes($str)
    {
        $v = \unpack("C*", $str);
        $v = \array_values($v);

        return $v;
    }

    /**
     * @param array $bytes
     *
     * @return mixed
     */
    public static function bytes2string(array $bytes)
    {
        return \call_user_func_array("pack", \array_merge(["C*"], $bytes));
    }
}