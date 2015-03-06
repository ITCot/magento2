<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Framework\ObjectManager\Environment;

use Magento\Framework\ObjectManager\EnvironmentInterface;
use Magento\Framework\ObjectManager\FactoryInterface;
use Magento\Framework\App\Area;
use Magento\Framework\App\ObjectManager\ConfigLoader;

class Compiled extends AbstractEnvironment implements EnvironmentInterface
{
    /**#@+
     * Mode name
     */
    const MODE = 'compiled';

    protected $mode = self::MODE;
    /**#@- */

    /**
     * @var string
     */
    protected $configPreference = 'Magento\Framework\ObjectManager\Factory\Compiled';

    /**
     * @var ConfigLoader\Compiled
     */
    private $configLoader;

    /**
     * Creates factory
     *
     * @param array $arguments
     * @param string $factoryClass
     *
     * @return FactoryInterface
     */
    protected function createFactory($arguments, $factoryClass)
    {
        return new $factoryClass(
            $this->getDiConfig(),
            $arguments['shared_instances'],
            $arguments
        );
    }

    /**
     * Returns initialized compiled config
     *
     * @return \Magento\Framework\Interception\ObjectManager\ConfigInterface
     */
    public function getDiConfig()
    {
        if (!$this->config) {
            $this->config = new \Magento\Framework\Interception\ObjectManager\Config\Compiled(
                $this->getConfigData()
            );
        }

        return $this->config;
    }

    /**
     * Returns config data as array
     *
     * @return array
     */
    protected function getConfigData()
    {
        $this->getObjectManagerConfigLoader()->load(Area::AREA_GLOBAL);
    }

    /**
     * Returns new instance of compiled config loader
     *
     * @return ConfigLoader\Compiled
     */
    public function getObjectManagerConfigLoader()
    {
        if ($this->configLoader) {
            return $this->configLoader;
        }

        $this->configLoader = new ConfigLoader\Compiled();
        return $this->configLoader;
    }
}
