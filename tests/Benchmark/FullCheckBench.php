<?php

namespace Tests\Benchmark;

use ClassTransformer\ClassTransformer;
use Doctrine\Common\Annotations\AnnotationReader;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use Jane\Component\AutoMapper\AutoMapper;
use Jane\Component\AutoMapper\Generator\Generator;
use Jane\Component\AutoMapper\Loader\FileLoader;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Tests\Benchmark\YzenDTO\PurchaseDTO as YzenPurchaseDTO;
use Tests\Benchmark\CuyzDTO\PurchaseDTO as CuyzPurchaseDTO;
use Tests\Benchmark\EventSauceDTO\PurchaseDTO as EventSaucePurchaseDTO;
use Tests\Benchmark\SpatieDTO\PurchaseDTO as SpatiePurchaseDTO;

/**
 * Class CheckBench
 *
 * @package Tests\Benchmark
 *
 * ./vendor/bin/phpbench run tests/Benchmark/CheckBench.php --report=default
 */
class FullCheckBench extends TestCase
{

    public static FileLoader $fileLoaderForJane;


    /**
     * @Revs(5000)
     */
    public function benchYzenVersion(): void
    {
        $data = $this->getPurcheseObject();
        ClassTransformer::transform(YzenPurchaseDTO::class, $data);

    }


    /**
     * @Revs(5000)
     */
    public function benchSpatieVersion(): void
    {
        $data = $this->getPurcheseObject();
        new SpatiePurchaseDTO($data);
    }

    /**
     * @Revs(5000)
     */
    public function benchEventSauceVersion(): void
    {
        $data = $this->getPurcheseObject();
        $mapper = new ObjectMapperUsingReflection();
        $s = $mapper->hydrateObject(EventSaucePurchaseDTO::class, $data);
    }

    /**
     * @Revs(5000)
     */
    public function benchSymphonyVersion(): void
    {
        $data = $this->getPurcheseObject();

        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
        $serializer = new Serializer([$normalizer]);
        $serializer->denormalize($data, YzenPurchaseDTO::class);
    }

    /**
     * @Revs(5000)
     */
    public function benchCuyzVersion(): void
    {
        $data = $this->getPurcheseObject();
        (new \CuyZ\Valinor\MapperBuilder())
            ->mapper()
            ->map(CuyzPurchaseDTO::class, \CuyZ\Valinor\Mapper\Source\Source::array($data));
    }

    /**
     * @Revs(10)
     */
    public function benchJaneVersion(): void
    {
        if (!isset(static::$fileLoaderForJane)) {
            $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
            static::$fileLoaderForJane = new FileLoader(new Generator(
                (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
                new ClassDiscriminatorFromClassMetadata($classMetadataFactory)
            ), __DIR__ . '/cache');

        }

        $data = $this->getPurcheseObject();

        $autoMapper = AutoMapper::create(true, static::$fileLoaderForJane);
        $autoMapper->map($data, YzenPurchaseDTO::class);
    }

    public function getPurcheseObject(): array
    {
        return [
            'products' => [
                [
                    'id' => 1,
                    'name' => 'phone',
                    'price' => 43.03,
                    'description' => 'test description for phone',
                    'count' => 123
                ],
                [
                    'id' => 2,
                    'name' => 'bread',
                    'price' => 10.56,
                    'description' => 'test description for bread',
                    'count' => 321
                ],
                [
                    'id' => 2,
                    'name' => 'book',
                    'price' => 5.5,
                    'description' => 'test description for book',
                    'count' => 333
                ]
            ],
            'user' => [
                'id' => 1,
                'email' => 'fake@mail.com',
                'balance' => 10012.23,
                'type' => 'admin',
                'real_address' => 'test address',
            ]
        ];
    }
}
