<?php

namespace Magestio\Redsys\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Language
 * @package Magestio\Redsys\Model
 */
class Language
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Language constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    protected $languages = [
        'es' => '001',
        'en' => '002',
        'ca' => '003',
        'fr' => '004',
        'de' => '005',
        'nl' => '006',
        'it' => '007',
        'sv' => '008',
        'pt' => '009',
        'pl' => '011',
        'gl' => '012',
        'eu' => '013',
    ];

    /**
     * @param string $languageWeb
     * @return string
     */
    public function getLanguageByCode($languageWeb)
    {
        if (isset($this->languages[$languageWeb])) {
            return $this->languages[$languageWeb];
        }
        return ConfigInterface::REDSYS_DEFAULT_LANGUAGE;
    }

    /**
     * @return string
     */
    public function getRedsysLanguage()
    {
        $languages = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_LANGUAGES, ScopeInterface::SCOPE_STORE);
        if ($languages == "0") {
            $languageTpv = "0";
        } else {
            $languageWeb = substr($this->scopeConfig->getValue('general/locale/code', ScopeInterface::SCOPE_STORE), 0, 2);
            $languageTpv = $this->getLanguageByCode($languageWeb);
        }
        return $languageTpv;
    }

}