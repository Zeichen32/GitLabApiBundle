<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Developer: Jens Averkamp
 * Date: 06.03.2015
 * Time: 14:15
 */

namespace Zeichen32\GitLabApiBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zeichen32\GitLabApiBundle\Zeichen32GitLabApiBundle;

class Zeichen32GitLabApiBundleTest extends TestCase {

    /**
     *
     */
    public function testBuild()
    {
        $container = $this->getMockBuilder(ContainerBuilder::class)
                          ->onlyMethods(['addCompilerPass'])
                          ->getMock();

        $container->expects($this->exactly(0))
                  ->method('addCompilerPass')
                  ->with($this->isInstanceOf(CompilerPassInterface::class));

        $bundle = new Zeichen32GitLabApiBundle();
        $bundle->build($container);
    }
}
