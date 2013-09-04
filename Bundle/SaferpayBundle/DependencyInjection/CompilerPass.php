<?php

namespace Payment\Bundle\SaferpayBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @throws \RuntimeException
     */
    public function process(ContainerBuilder $container)
    {
        $saferpayServiceId = 'payment.saferpay';
        $httpClientFactoryServiceId = 'payment.saferpay.httpclient.factory';
        $payInitParameterFactoryServiceId = 'payment.saferpay.payinitparameter.factory';
        $authorizationInitParameterFactoryServiceId = 'payment.saferpay.authorizationinitparameter.factory';
        $recordLinkInitParameterFactoryServiceId = 'payment.saferpay.recordLinkinitparameter.factory';

        if(
            !$container->hasDefinition($saferpayServiceId) OR
            !$container->hasDefinition($httpClientFactoryServiceId) OR
            !$container->hasDefinition($payInitParameterFactoryServiceId) OR 
            !$container->hasDefinition($authorizationInitParameterFactoryServiceId) OR
            !$container->hasDefinition($recordLinkInitParameterFactoryServiceId) 
        ){
            return;
        }

        $httpClientFactoryDefinition = $container->getDefinition($httpClientFactoryServiceId);
        $httpClientFactoryDefinition->addArgument(
            new Reference($container->getParameter('payment.saferpay.httpclient.serviceid'))
        );

        $payInitParameterFactoryDefinition = $container->getDefinition($payInitParameterFactoryServiceId);
        $payInitParameterFactoryDefinition->addArgument(
            new Reference($container->getParameter('payment.saferpay.payinitparameter.serviceid'))
        );
        $payInitParameterFactoryDefinition->addArgument(
            $container->getParameter('payment.saferpay.payinitparameter.defaults')
        );


        $authorizationInitParameterFactoryDefinition = $container->getDefinition($authorizationInitParameterFactoryServiceId);
        $authorizationInitParameterFactoryDefinition->addArgument(
            new Reference($container->getParameter('payment.saferpay.authorizationinitparameter.serviceid'))
        );
        $authorizationInitParameterFactoryDefinition->addArgument(
            $container->getParameter('payment.saferpay.authorizationinitparameter.defaults')
        );        

        $recordLinkInitParameterFactoryDefinition = $container->getDefinition($recordLinkInitParameterFactoryServiceId);
        $recordLinkInitParameterFactoryDefinition->addArgument(
            new Reference($container->getParameter('payment.saferpay.recordlinkinitparameter.serviceid'))
        );
        $recordLinkInitParameterFactoryDefinition->addArgument(
            $container->getParameter('payment.saferpay.recordlinkinitparameter.defaults')
        );


        $loggerServiceId = $container->getParameter('payment.saferpay.logger.serviceid');
        if($container->hasAlias($loggerServiceId)){
            $loggerServiceId = $container->getAlias($loggerServiceId);
        }

        if(!$container->hasDefinition($loggerServiceId)){
            return;
        }

        $saferpayDefinition = $container->getDefinition($saferpayServiceId);
        $saferpayDefinition->addMethodCall('setLogger', array(
            new Reference($loggerServiceId)
        )); 
    }
}