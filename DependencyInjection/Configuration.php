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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Black\Bundle\PersonBundle\DependencyInjection
 * @author  Alexandre Balmes <albalmes@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('black_person');

        $supportedDrivers = array('mongodb', 'orm');

        $rootNode
            ->children()

                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver must be either \'mongodb\', \'orm\'.')
                    ->end()
                ->end()

                ->scalarNode('person_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('contactpoint_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('postaladdress_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('person_manager')
                    ->defaultValue('Black\\Bundle\\PersonBundle\\Doctrine\\PersonManager')
                ->end()

            ->end();

        $this->addProfileSection($rootNode);
        $this->addContactPointSection($rootNode);
        $this->addPostalAddressSection($rootNode);
        $this->addServiceSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addProfileSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('person')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')->defaultValue('black_person_person_form')->end()
                                ->scalarNode('type')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\Type\\PersonType'
                                )->end()
                                ->scalarNode('person_list')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\ChoiceList\\PersonList'
                                )->end()
                                ->scalarNode('handler')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\Handler\\PersonFormHandler'
                                )->end()
                                ->scalarNode('gender_list')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\ChoiceList\\GenderList'
                                )->end()
                                ->scalarNode('honorific_prefix_list')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\ChoiceList\\HonorificPrefixList'
                                )->end()
                                ->scalarNode('front_name')->defaultValue('black_person_person_front_form')->end()
                                ->scalarNode('front_type')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\Type\\FrontPersonType'
                                )->end()
                                ->scalarNode('front_handler')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\Handler\\FrontPersonFormHandler'
                                )->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addContactPointSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('contactpoint')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\Type\\ContactPointType'
                                )->end()
                                ->scalarNode('contact_list')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\ChoiceList\\ContactList'
                                )->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addPostalAddressSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('postaladdress')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue(
                                    'Black\\Bundle\\PersonBundle\\Form\\Type\\PostalAddressType'
                                )->end()
                                ->scalarNode('address_list')->defaultValue(
                                    'Black\\Bundle\\CommonBundle\\Form\\ChoiceList\\AddressList'
                                )->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('mailer')->defaultValue('black_person.mailer.default')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
