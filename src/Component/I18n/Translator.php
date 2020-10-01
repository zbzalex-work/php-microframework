<?php

namespace Xand\Component\I18n;
use Xand\Component\I18n\Exporter\ExporterInterface;
use Xand\Component\I18n\Formatter\Formatter;
use Xand\Component\I18n\Formatter\FormatterInterface;
use Xand\Component\I18n\Importer\ImporterInterface;
use Xand\Component\I18n\Store\Store;
use Xand\Component\I18n\Store\StoreInterface;

/**
 * Class Translator
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
class Translator implements TranslatorInterface
{
    /**
     * @var ImporterInterface
     */
    protected $importer;
    /**
     * @var StoreInterface
     */
    protected $store;

    /**
     * @var ExporterInterface
     */
    protected $exporter;

    /**
     * @var FormatterInterface
     */
    protected $formatter;

    /**
     * @var string
     */
    protected $fallbackLang;

    /**
     * Translator constructor.
     *
     * @param ImporterInterface         $importer
     * @param ExporterInterface         $exporter
     * @param StoreInterface|null       $store
     * @param FormatterInterface|null   $formatter
     * @param null|string               $fallbackLang
     */
    public function __construct(ImporterInterface $importer, ExporterInterface $exporter, StoreInterface $store = null,
        FormatterInterface $formatter = null, $fallbackLang = null)
    {
        $this->importer = $importer;
        $this->exporter = $exporter;
        $this->store = null === $store ? new Store() : $store;
        $this->formatter = null === $formatter ? new Formatter() : $formatter;
    }

    /**
     * @return string
     */
    public function getFallbackLang()
    {
        return $this->fallbackLang;
    }

    /**
     * @param string    $lang
     *
     * @return static
     */
    public function setFallbackLang($lang)
    {
        $this->fallbackLang = $lang;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        if (null === $this->fallbackLang)
            throw new \RuntimeException();

        $this->importer->import($this->fallbackLang, $this->store);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function translate($key, array $params = [])
    {
        if (null === $this->fallbackLang)
            throw new \RuntimeException();

        if ( ! $this->store->has($key)) {
            $translations = [];
            $translations[ $key ] = $key;

            $this->exporter->export($this->fallbackLang, $translations);
            $this->store->set($key, $key);
        }

        return $this->formatter->format($this->store->get($key), $params);
    }
}