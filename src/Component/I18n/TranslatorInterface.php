<?php

namespace Xand\Component\I18n;

/**
 * Interface TranslatorInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface TranslatorInterface
{
    /**
     * @return string
     */
    public function getFallbackLang();

    /**
     * @param string    $lang
     */
    public function setFallbackLang($lang);

    public function load();

    /**
     * @param string                    $key
     * @param array<string, string>     $params
     *
     * @return string
     */
    public function translate($key, array $params = []);
}