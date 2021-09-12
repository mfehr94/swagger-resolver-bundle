<?php

declare(strict_types=1);

/*
 * This file is part of the SwaggerResolverBundle package.
 *
 * (c) Viktor Linkin <adrenalinkin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Linkin\Bundle\SwaggerResolverBundle\Tests\Resolver;

use EXSyst\Component\Swagger\Schema;
use Linkin\Bundle\SwaggerResolverBundle\Enum\ParameterTypeEnum;
use Linkin\Bundle\SwaggerResolverBundle\Resolver\SwaggerResolver;
use Linkin\Bundle\SwaggerResolverBundle\Validator\SwaggerValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 */
class SwaggerResolverTest extends TestCase
{
    public function testCanClearValidators(): void
    {
        $fieldName = 'description';
        $schema = new Schema([
            'properties' => new Schema([
                'type' => ParameterTypeEnum::STRING,
                'title' => $fieldName,
            ])
        ]);

        $sut = new SwaggerResolver($schema);

        $validatorMock = $this->createMock(SwaggerValidatorInterface::class);
        $validatorMock->expects(self::never())->method('supports');
        $sut->addValidator($validatorMock);

        $sut->clear();

        $sut->setDefined($fieldName);
        $sut->resolve([$fieldName => 'any text']);
    }
}
