<?php

namespace Mauchede\RancherApiBundle\DependencyInjection;

use Mauchede\RancherApi\Resource\Project;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * MauchedeRancherApiExtension is an extension for the Rancher API library.
 *
 * @author Morgan Auchede <morgan.auchede@gmail.com>
 */
class MauchedeRancherApiExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['projects'] as $name => $project) {
            $idClient = sprintf('rancher_api.clients.%s', $name);
            $idProject = sprintf('rancher_api.projects.%s', $name);

            $this->addClient($container, $idClient, $project['access_key'], $project['secret_key']);
            $this->addProject($container, $idProject, $idClient, $project['endpoint']);
        }
    }

    /**
     * Adds a new client definition.
     *
     * @param ContainerBuilder $container
     * @param string           $idClient
     * @param string           $accessKey
     * @param string           $secretKey
     */
    private function addClient(ContainerBuilder $container, $idClient, $accessKey, $secretKey)
    {
        $definition = new Definition('Mauchede\\RancherApi\\Client\\Client');
        $definition
            ->setArguments(array(
                $accessKey,
                $secretKey,
            ))
            ->setPublic(false);

        $container->setDefinition($idClient, $definition);
    }

    /**
     * Adds a new project definition.
     *
     * @param ContainerBuilder $container
     * @param string           $idProject
     * @param string           $idClient
     * @param string           $endpoint
     */
    private function addProject(ContainerBuilder $container, $idProject, $idClient, $endpoint)
    {
        $definition = new Definition('Mauchede\\RancherApi\\Resource\\Project');
        $definition
            ->setArguments(array(
                $endpoint,
                Project::class
            ))
            ->setFactory(array(
                new Reference($idClient),
                'get',
            ));

        $container->setDefinition($idProject, $definition);
    }
}
