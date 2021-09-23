<?php

namespace App;

use App\Tasks\Infrastructure\Persistence\Doctrine\ODM\Types\TaskIdType;
use App\Comments\Infrastructure\Persistence\Doctrine\ODM\Types\CommentIdType;
use App\Users\Infrastructure\Persistence\Doctrine\ODM\Types\UserIdType;
use App\Users\Infrastructure\Persistence\Doctrine\ODM\Types\UserLoginType;
use Doctrine\ODM\MongoDB\Types\Type;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\Event\EventUseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.yaml');
        $container->import('../config/{packages}/'.$this->environment.'/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/services.yaml')) {
            $container->import('../config/{services}.yaml');
            $container->import('../config/{services}_'.$this->environment.'.yaml');
        } elseif (is_file($path = \dirname(__DIR__).'/config/services.php')) {
            (require $path)($container->withPath($path), $this);
        }

        Type::registerType('comment:comment_id', CommentIdType::class);
        Type::registerType('task:task_id', TaskIdType::class);
        Type::registerType('users:user_id', UserIdType::class);
        Type::registerType('users:user_login', UserLoginType::class);
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/'.$this->environment.'/*.yaml');
        $routes->import('../config/{routes}/*.yaml');

        if (is_file(\dirname(__DIR__).'/config/routes.yaml')) {
            $routes->import('../config/{routes}.yaml');
        } elseif (is_file($path = \dirname(__DIR__).'/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }

    protected function build(ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(UseCaseInterface::class)
            ->addTag('ninja_bugs.service_bus.command.handler')
            ->setPublic(true);

        $container->registerForAutoconfiguration(QueryUseCaseInterface::class)
            ->addTag('ninja_bugs.service_bus.query.handler')
            ->setPublic(true);

        $container->registerForAutoconfiguration(EventUseCaseInterface::class)
            ->addTag('ninja_bugs.service_bus.event.handler')
            ->setPublic(true);
    }
}
