<?php

namespace Magestio\Redsys\Model\Ui;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magestio\Redsys\Gateway\Config\Bizum as Config;
use Magestio\Redsys\Model\ConfigInterface;
/**
 * Class BizumConfigProvider
 * @package Magestio\Redsys\Model\Ui
 */
final class BizumConfigProvider implements ConfigProviderInterface
{
    const CODE = 'bizum';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var SessionManagerInterface
     */
    private $session;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var AssetRepository
     */
    private $assetRepository;

    /**
     * ConfigProvider constructor.
     * @param Config $config
     * @param SessionManagerInterface $session
     * @param RequestInterface $request
     * @param AssetRepository $assetRepository
     */
    public function __construct(
        Config $config,
        SessionManagerInterface $session,
        RequestInterface $request,
        AssetRepository $assetRepository
    ) {
        $this->config = $config;
        $this->session = $session;
        $this->request = $request;
        $this->assetRepository = $assetRepository;
    }

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        $storeId = $this->session->getStoreId();

        return [
            'payment' => [
                self::CODE => [
                    'isActive' => $this->config->isActive($storeId),
                    'showIcon' => ($this->config->getValue("icon") == "1"),
                    'redirectUrl' => ConfigInterface::REDSYS_REDIRECT_URI,
                    'icons' => $this->createAsset('Magestio_Redsys::images/icon_bizum.png')->getUrl()
                ]
            ]
        ];
    }

    /**
     * Create a file asset that's subject of fallback system
     *
     * @param string $fileId
     * @param array $params
     * @return \Magento\Framework\View\Asset\File
     */
    public function createAsset($fileId, array $params = [])
    {
        $params = array_merge(['_secure' => $this->request->isSecure()], $params);
        return $this->assetRepository->createAsset($fileId, $params);
    }


}
