<?php

namespace Payment\Bundle\SaferpayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class PaymentSaferpayExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $processor = new Processor();

        $config = $processor->process($configuration->getConfigTreeBuilder()->buildTree(), $configs);

        $container->setParameter('payment.saferpay.logger.serviceid', $config['logger']['serviceid']);
        $container->setParameter('payment.saferpay.httpclient.serviceid', $config['httpclient']['serviceid']);

        $container->setParameter('payment.saferpay.payinitparameter.serviceid', $config['payinitparameter']['serviceid']);
        $container->setParameter('payment.saferpay.payinitparameter.defaults', $config['payinitparameter']['data']);


        $container->setParameter('payment.saferpay.authorizationinitparameter.serviceid', $config['authorizationinitparameter']['serviceid']);
        $container->setParameter('payment.saferpay.authorizationinitparameter.defaults', $config['authorizationinitparameter']['data']);

        $container->setParameter('payment.saferpay.recordlinkinitparameter.serviceid', $config['recordlinkinitparameter']['serviceid']);
        $container->setParameter('payment.saferpay.recordlinkinitparameter.defaults', $config['recordlinkinitparameter']['data']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'payment_saferpay';
    }
}