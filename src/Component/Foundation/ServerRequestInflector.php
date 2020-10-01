<?php

namespace Xand\Component\Foundation;
use Xand\Component\Foundation\Http\HeadersInflector;

/**
 * Class ServerRequestInflector
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class ServerRequestInflector
{
    /**
     * @param array $files
     *
     * @return array
     */
    public static function getUploadedFiles(array $files)
    {
        $uploadedFiles = [];
        foreach($files as $name => $file) {

            if (is_array($file['name'])) {

                $i = 0;
                $total = count($file['name']);

                do
                {
                    $_file	= [];
                    foreach(array_keys($files[$name]) as $key) {
                        $_file[$key] = $files[$name][$key][$i];
                    }

                    $_uploadedFiles = static::getUploadedFiles([
                        $name	=>	$_file
                    ]);

                    foreach($_uploadedFiles[$name] as $_uploadedFile) {
                        $uploadedFiles[$name][] = $_uploadedFile;
                    }

                    $i++;

                } while( $i < $total );
            }
            else {
                $uploadedFiles[$name][]	= new UploadedFile($file['tmp_name'], $file['name'], $file['type'],
                    $file['size'], $file['error']);
            }
        }

        return $uploadedFiles;
    }

    /**
     * @param array $server
     *
     * @return array
     */
    public static function getHeaders(array $server)
    {
        $headers = [];

        if (\function_exists("apache_request_headers")) {
            foreach(\apache_request_headers() as $header => $value) {

                $header = HeadersInflector::normalize($header);

                if (!isset($headers[ $header ]))
                    $headers[ $header ] = [];
                $headers[ $header ][] = $value;
            }
        } else {
            foreach($server as $key => $value) {
                if (false === strpos($key, "HTTP_"))
                    continue;

                $header = HeadersInflector::normalize(substr($key, 5));
                if (!isset($headers[$header])) {
                    $headers[ $header ] = [];
                }

                $headers[$header][] = $value;
            }
        }

        /* @var array $headers */
        $headers = \array_change_key_case($headers, CASE_LOWER);

        return $headers;
    }
}