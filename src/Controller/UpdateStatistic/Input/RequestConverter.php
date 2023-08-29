<?php

declare(strict_types=1);

namespace App\Controller\UpdateStatistic\Input;

use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestConverter implements ParamConverterInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
    ) { }

    public function apply(HttpRequest $httpRequest, ParamConverter $configuration): bool
    {
        $request = $this->serializer->deserialize($httpRequest->getContent(), Request::class, 'json');
        $httpRequest->attributes->set($configuration->getName(), $request);
        $errors = $this->validator->validate($request);
        $httpRequest->attributes->set('validationErrors', $errors);
        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return Request::class === $configuration->getClass();
    }
}