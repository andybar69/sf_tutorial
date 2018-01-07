<?php

namespace PlatformBundle\Service;


use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\IpUtils;

class AccessManager
{
    private $rootDir;
    private $em;

    public function __construct($rootDir, $em)
    {
        $this->rootDir = $rootDir;
        $this->em = $em;
    }

    public function getAllowedIPs()
    {
        $finder = new Finder();
        $finder->files()->in(dirname($this->rootDir))->name('allowed-ip-public.txt');
        foreach ($finder as $file) {
            $contents = $file->getContents();
        }
        $arr = explode(PHP_EOL, $contents);
        $arAllowedIPs = array_filter($arr);
        //dump($arAllowedIPs);

        return $arAllowedIPs;

    }

}