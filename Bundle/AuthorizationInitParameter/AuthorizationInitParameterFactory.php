<?php

namespace Payment\Bundle\SaferpayBundle\AuthorizationInitParameter;

use Payment\Saferpay\Data\AuthorizationParameterWithDataInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class AuthorizationInitParameterFactory
{
    /**
     * @var AutorisationInitParameterWithDataInterface
     */
    protected $authorisationInitParameter;

    /**
     * @param AutorisationInitParameterWithDataInterface $payInitParameter
     * @param array $autorisationInitParameterData
     */
    public function __construct(AuthorizationParameterWithDataInterface $authorisationInitParameter, array $authorisationInitParameterData = array())
    {
        foreach ($authorisationInitParameterData as $key => $value)
        {
            if (is_null($value)) 
            {
                continue;
            }
            $method = 'set'.ucfirst($key);
            if (!method_exists($authorisationInitParameter, $method))
            {
                throw new InvalidArgumentException($method .' Method not found');
            }
            $authorisationInitParameter->{$method}($value);
        }
        $this->authorisationInitParameter = $authorisationInitParameter;
    }

    /**
     * @return PayInitParameterWithDataInterface
     */
    public function createAuthorisationInitParameter()
    {
        return clone $this->authorisationInitParameter;
    }
}