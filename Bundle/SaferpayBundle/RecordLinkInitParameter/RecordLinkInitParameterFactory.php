<?php

namespace Payment\Bundle\SaferpayBundle\RecordLinkInitParameter;

use Payment\Saferpay\Data\RecordLinkInitParameterWithDataInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

class RecordLinkInitParameterFactory
{
    /**
     * @var RecordLinkInitParameterWithDataInterface
     */
    protected $recordLinkInitParameter;

    /**
     * @param RecordLinkInitParameterWithDataInterface $payInitParameter
     * @param array $RecordLinkInitParameterData
     */
    public function __construct(RecordLinkInitParameterWithDataInterface $recordLinkInitParameter, array $recordLinkInitParameterData = array())
    {
        foreach ($recordLinkInitParameterData as $key => $value)
        {
            if (is_null($value)) 
            {
                continue;
            }
            $method = 'set'.ucfirst($key);
            if (!method_exists($recordLinkInitParameter, $method))
            {
                throw new InvalidArgumentException($method .' Method not found');
            }
            $recordLinkInitParameter->{$method}($value);
        }
        $this->recordLinkInitParameter = $recordLinkInitParameter;
    }

    /**
     * @return PayInitParameterWithDataInterface
     */
    public function createRecordLinkInitParameter()
    {
        return clone $this->recordLinkInitParameter;
    }
}