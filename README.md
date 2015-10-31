# RancherApiBundle

[Rancher API](http://github.com/mauchede/rancher-api) Bundle for the [Symfony](http://symfony.com/) Framework.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d7b10c15-f24e-4519-91b8-94c07cbab88c/big.png)](https://insight.sensiolabs.com/projects/d7b10c15-f24e-4519-91b8-94c07cbab88c)

## Installation

* Install Rancher API Bundle via [composer](https://getcomposer.org/):

```bash
composer require mauchede/rancher-api
```

* Enable the bundle in `AppKernel`:

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Mauchede\RancherApiBundle\MauchedeRancherApiBundle(),
            // ...
        );

        // ...
    }

    // ...
}
```

* Configure the projects in `config.yml`:

```yaml
rancher_api:
    projects:
        project_A:
            endpoint: #...
            access_key: #...
            secret_key: #...
        project_B:
            endpoint: #...
            access_key: #...
            secret_key: #...
```

__Note__: `endpoint` and the API Keys (`access_key` and `secret_key`) can be found in Rancher settings (`[Rancher URL]/settings/api`).

Project name (here `project_A` and `project_B`) does not match with the Rancher's project/environment: you are free to choose the best name.

## Usage

The Bundle will create a service `rancher_api.projects.[project_name]`. This service will be an instance of `Mauchede\RancherApi\Resource\Project`.

With the example of configuration, two services will be created:
* `rancher_api.projects.project_A`
* `rancher_api.projects.project_B`.

You can inject these services to another service or to use them in yours controllers.

## Contributing

1. Fork it.
2. Create your branch: `git checkout -b my-new-feature`.
3. Commit your changes: `git commit -am 'Add some feature'`.
4. Push to the branch: `git push origin my-new-feature`.
5. Submit a pull request.

## Links

* [How to Install 3rd Party Bundles](http://symfony.com/doc/current/cookbook/bundles/installation.html)
* [Rancher API](http://github.com/mauchede/rancher-api)
