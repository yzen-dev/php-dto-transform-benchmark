<?php

namespace Tests\Lite;

use ClassTransformer\Hydrator;
use ClassTransformer\HydratorConfig;
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
use Tests\Lite\CuyzDTO\PurchaseDTO as CuyzPurchaseDTO;
use Tests\Lite\EventSauceDTO\PurchaseDTO as EventSaucePurchaseDTO;
use Tests\Lite\NutgramDTO\PurchaseDTO as NutgramPurchaseDTO;
use Tests\Lite\SpatieDTO\PurchaseDTO as SpatiePurchaseDTO;
use Tests\Lite\YzenDto\PurchaseDTO as YzenPurchaseDTO;
use Tests\SimpleContainer;
use Yiisoft\Hydrator\Hydrator as YiiHydrator;

/**
 * Class CheckBench
 *
 * @package Tests\Benchmark
 *
 * ./vendor/bin/phpbench run tests/Lite/LiteCheckBench.php --report=default
 */
class LiteCheckBench extends TestCase
{

    public static FileLoader $fileLoaderForJane;


    /**
     * @Revs(5000)
     */
    public function benchYzenCacheVersion(): void
    {
        $data = $this->getPurcheseObject();
        $object = Hydrator::init(new HydratorConfig(true))->create(YzenPurchaseDTO::class, $data);
        
        $this->assertEquals($data['user']['id'], $object->user->id);
    }
    
    /**
     * @Revs(5000)
     */
    public function benchYzenVersion(): void
    {
        $data = $this->getPurcheseObject();
        $object = Hydrator::init()->create(YzenPurchaseDTO::class, $data);
        $this->assertEquals($data['user']['id'], $object->user->id);
    }

    /**
     * @Revs(5000)
     */
    public function benchYiiHydratorVersion(): void
    {
        $data = $this->getPurcheseObject();

        $hydrator = new YiiHydrator(new SimpleContainer());
        $object = $hydrator->create(
            YzenPurchaseDTO::class,
            $data,
        );
        $this->assertEquals($data['user']['id'], $object->user->id);
    }


    /**
     * @Revs(5000)
     */
    public function benchSpatieVersion(): void
    {
        $data = $this->getPurcheseObject();
        $object =new SpatiePurchaseDTO($data);
        $this->assertEquals($data['user']['id'], $object->user->id);
    }

    /**
     * @Revs(5000)
     */
    public function benchEventSauceVersion(): void
    {
        $data = $this->getPurcheseObject();
        $mapper = new ObjectMapperUsingReflection();
        $object = $mapper->hydrateObject(EventSaucePurchaseDTO::class, $data);
        $this->assertEquals($data['user']['id'], $object->user->id);
    }

    /**
     * @Revs(5000)
     */
    public function benchSymfonyVersion(): void
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
     * @Revs(1000)
     */
    public function benchJaneVersion(): void
    {
        $data = $this->getPurcheseObject();

        $autoMapper = AutoMapper::create();
        $object = $autoMapper->map($data, YzenPurchaseDTO::class);

    }
    
    /**
     * @Revs(1000)
     */
    public function benchJaneCacheVersion(): void
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
        $object = $autoMapper->map($data, YzenPurchaseDTO::class);
    }

    /**
     * @Revs(5000)
     */
    public function benchNutgramVersion(): void
    {
        $data = $this->getPurcheseObject();
        (new \SergiX44\Hydrator\Hydrator())->hydrate(NutgramPurchaseDTO::class, $data);
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
