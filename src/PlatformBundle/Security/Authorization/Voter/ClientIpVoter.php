<?php

namespace PlatformBundle\Security\Authorization\Voter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class ClientIpVoter implements VoterInterface
{
    private $container;
    private $accessManager;

    public function __construct(ContainerInterface $container, $manager)
    {
        $this->container     = $container;
        $this->accessManager = $manager;
    }

    public function supportsAttribute($attribute)
    {
        // you won't check against a user attribute, so return true
        return true;
    }

    public function supportsClass($class)
    {
        // your voter supports all type of token classes, so return true
        return true;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $request = $this->container->get('request');
        dump($request);
        $blacklistedIp = $this->accessManager->getAllowedIps();
        if (!in_array($request->getClientIp(), $blacklistedIp)) {
            return VoterInterface::ACCESS_DENIED;
        }

        return VoterInterface::ACCESS_ABSTAIN;
    }

}