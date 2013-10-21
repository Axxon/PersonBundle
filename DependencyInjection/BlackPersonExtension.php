<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Bundle\PersonBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class BlackPersonExtension
 *
 * @package Black\Bundle\PersonBundle\DependencyInjection
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class BlackPersonExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \InvalidArgumentException
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor      = new Processor();
        $configuration  = new Configuration();
        $config         = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (!isset($config['db_driver'])) {
            throw new \InvalidArgumentException('You must provide the black_person.db_driver configuration');
        }

        try {
            $loader->load(sprintf('%s.xml', $config['db_driver']));
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException(
                sprintf('The db_driver "%s" is not supported by person', $config['db_driver'])
            );
        }

        foreach (array('mailer', 'contact') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $container->setAlias('black_person.mailer', $config['service']['mailer']);

        $this->remapParametersNamespaces(
            $config,
            $container,
            array(
                '' => array(
                    'db_driver'             => 'black_person.db_driver',
                    'person_class'          => 'black_person.person.model.class',
                    'person_manager'        => 'black_person.person.manager',
                    'contactpoint_class'    => 'black_person.contactpoint.model.class',
                    'postaladdress_class'   => 'black_person.postaladdress.model.class'
                )
            )
        );

        if (!empty($config['person'])) {
            $this->loadPerson($config['person'], $container, $loader);
        }

        if (!empty($config['contactpoint'])) {
            $this->loadContactPoint($config['contactpoint'], $container, $loader);
        }

        if (!empty($config['postaladdress'])) {
            $this->loadPostalAddress($config['postaladdress'], $container, $loader);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader    $loader
     */
    private function loadPerson(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        foreach (array('person', 'front_person') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            array(
                'form' => 'black_person.person.form.%s',
            )
        );
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader    $loader
     */
    private function loadContactPoint(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('contactPoint.xml');

        $this->remapParametersNamespaces(
            $config,
            $container,
            array(
                'form' => 'black_person.contactpoint.form.%s',
            )
        );
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param XmlFileLoader    $loader
     */
    private function loadPostalAddress(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('postalAddress.xml');

        $this->remapParametersNamespaces(
            $config,
            $container,
            array(
                'form' => 'black_person.postaladdress.form.%s',
            )
        );
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param array            $map
     */
    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     * @param array            $namespaces
     */
    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {

            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }
            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'black_person';
    }
}
