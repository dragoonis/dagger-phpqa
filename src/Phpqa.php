<?php

declare(strict_types=1);

namespace DaggerModule;

use Dagger\Attribute\DaggerArgument;
use Dagger\Attribute\DaggerFunction;
use Dagger\Attribute\DaggerObject;
use Dagger\Client;
use Dagger\Container;
use Dagger\Directory;

#[DaggerObject]
class Phpqa
{
    public Client $client;

    #[DaggerFunction('phpstan')]
    public function phpstan(
        #[DaggerArgument('The value to echo')]
        Directory $source,
    ): string {
       return $this->client->container()
           ->from('jakzal/phpqa:latest')
           ->withMountedDirectory('/tmp/app', $source)
           ->withExec(['phpstan', 'analyse', '/tmp/app'])
           ->stdout();
    }

    #[DaggerFunction('phpunit')]
    public function phpunit(
        #[DaggerArgument('Path to your project')]
        Directory $source,
    ): string {
       return $this->client->container()
           ->from('php:8.3-cli-alpine')
           ->withMountedDirectory('/tmp/app', $source)
           ->withWorkdir('/tmp/app')
           ->withExec(['./vendor/bin/phpunit'])
           ->stdout();
    }   
    
    #[DaggerFunction('lint')]
    public function lint(
        #[DaggerArgument('The value to echo')]
        Directory $source,
    ): string {
       return $this->client->container()
           ->from('jakzal/phpqa:latest')
           ->withMountedDirectory('/tmp/app', $source)
           ->withExec(['parallel-lint', '/tmp/app'])
           ->stdout();
    }
    
    #[DaggerFunction('pest')]
    public function pest(
        #[DaggerArgument('The value to echo')]
        Directory $source,
    ): string {
       return $this->client->container()
           ->from('jakzal/phpqa:latest')
           ->withMountedDirectory('/tmp/app', $source)
           ->withExec(['parallel-lint', '/tmp/app'])
           ->stdout();
    }

}
