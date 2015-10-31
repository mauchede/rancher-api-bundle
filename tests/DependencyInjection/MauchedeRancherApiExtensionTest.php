<?php

namespace Mauchede\RancherApiBundle\Tests\DependencyInjection;

use Mauchede\RancherApi\Resource\Project;
use Mauchede\RancherApiBundle\DependencyInjection\MauchedeRancherApiExtension;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Yaml\Yaml;

class MauchedeRancherApiExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the loading of one project.
     */
    public function testLoadWithOneProject()
    {
        $container = new ContainerBuilder();
        $extension = new MauchedeRancherApiExtension();

        $extension->load(array(Yaml::parse(__DIR__ . '/../Fixtures/one_project.yml')), $container);

        $client = $container->getDefinition('rancher_api.clients.1a5');
        $this->assertEquals(array('33637A6077E19F4F6F9E', 'uHcDeGfjZVjGksyCdohQghBRid2o4kwGrBHTLQWJ'), $client->getArguments());

        $project = $container->getDefinition('rancher_api.projects.1a5');
        $this->assertEquals(array(new Reference('rancher_api.clients.1a5'), 'get'), $project->getFactory());
        $this->assertEquals(array('http://127.0.0.1:8080/v1/projects/1a5', Project::class), $project->getArguments());
    }

    /**
     * Tests the loading of one project without access key.
     */
    public function testLoadWithOneProjectWithoutAccessKey()
    {
        $container = new ContainerBuilder();
        $extension = new MauchedeRancherApiExtension();

        $this->setExpectedException(InvalidConfigurationException::class, 'The child node "access_key" at path "mauchede_rancher_api.projects.1a5" must be configured.');
        $extension->load(array(Yaml::parse(__DIR__ . '/../Fixtures/project_without_access_key.yml')), $container);
    }

    /**
     * Tests the loading of one project without endpoint key.
     */
    public function testLoadWithOneProjectWithoutEndpointKey()
    {
        $container = new ContainerBuilder();
        $extension = new MauchedeRancherApiExtension();

        $this->setExpectedException(InvalidConfigurationException::class, 'The child node "endpoint" at path "mauchede_rancher_api.projects.1a5" must be configured.');
        $extension->load(array(Yaml::parse(__DIR__ . '/../Fixtures/project_without_endpoint.yml')), $container);
    }

    /**
     * Tests the loading of one project without secret key.
     */
    public function testLoadWithOneProjectWithoutSecretKey()
    {
        $container = new ContainerBuilder();
        $extension = new MauchedeRancherApiExtension();

        $this->setExpectedException(InvalidConfigurationException::class, 'The child node "secret_key" at path "mauchede_rancher_api.projects.1a5" must be configured.');
        $extension->load(array(Yaml::parse(__DIR__ . '/../Fixtures/project_without_secret_key.yml')), $container);
    }

    /**
     * Tests the loading of two projects.
     */
    public function testLoadWithTwoProjects()
    {
        $container = new ContainerBuilder();
        $extension = new MauchedeRancherApiExtension();

        $extension->load(array(Yaml::parse(__DIR__ . '/../Fixtures/two_projects.yml')), $container);

        $client = $container->getDefinition('rancher_api.clients.1a5');
        $this->assertEquals(array('33637A6077E19F4F6F9E', 'uHcDeGfjZVjGksyCdohQghBRid2o4kwGrBHTLQWJ'), $client->getArguments());

        $project = $container->getDefinition('rancher_api.projects.1a5');
        $this->assertEquals(array(new Reference('rancher_api.clients.1a5'), 'get'), $project->getFactory());
        $this->assertEquals(array('http://127.0.0.1:8080/v1/projects/1a5', Project::class), $project->getArguments());


        $client = $container->getDefinition('rancher_api.clients.1a6');
        $this->assertEquals(array('6286699A9146ACEC48F0', 'rakd3bZbcYpqpoaBJzP5e4XS752Tb29E66gGpcC8'), $client->getArguments());

        $project = $container->getDefinition('rancher_api.projects.1a6');
        $this->assertEquals(array(new Reference('rancher_api.clients.1a6'), 'get'), $project->getFactory());
        $this->assertEquals(array('http://127.0.0.1:8080/v1/projects/1a6', Project::class), $project->getArguments());
    }
}
