<?php

namespace Tests\Full;

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
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Tests\Full\Dto\PurchaseDto;
use Tests\Full\JanePhpDto\PurchaseDto as JanePhpDto;
use Tests\Full\SpatieDto\PurchaseDto as SpatiePurchaseDTO;
use Tests\Full\EventSauceDto\PurchaseDto as EventSauceDtoDTO;
use Tests\Full\SymphonyDto\PurchaseDto as SymphonyDto;
use Tests\Full\CuyzVelinorDto\PurchaseDto as CuyzVelinorDtoDto;

use Tests\SimpleContainer;
use Yiisoft\Hydrator\Hydrator as YiiHydrator;

/**
 * Class CheckBench
 *
 * @package Tests\Benchmark
 *
 * ./vendor/bin/phpbench run tests/Full/FullCheckBench.php --report=default
 */
class FullCheckBench extends TestCase
{

    public static FileLoader $fileLoaderForJane;


    /**
     * @Revs(5000)
     */
    public function benchYzenCacheVersion(): void
    {
        $data = $this->getPurcheseObject();
        $object = (new Hydrator(new HydratorConfig(true)))
            ->create(PurchaseDto::class, $data);
        
        $this->assertEquals($data['user']['id'], $object->user->id);
    }
    
    /**
     * @Revs(5000)
     */
    public function benchYzenVersion(): void
    {
        $data = $this->getPurcheseObject();
        $object = Hydrator::init()->create(PurchaseDto::class, $data);
        $this->assertEquals($data['user']['id'], $object->user->id);
    }

    /**
     * @Revs(5000)
     */
    public function benchEventSauceVersion(): void
    {
        $data = $this->getPurcheseObject();
        $mapper = new ObjectMapperUsingReflection();
        $object = $mapper->hydrateObject(EventSauceDtoDTO::class, $data);

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
    public function benchYiiHydratorVersion(): void
    {
        $data = $this->getPurcheseObject();

        $hydrator = new YiiHydrator(new SimpleContainer());
        $object = $hydrator->create(
            PurchaseDto::class,
            $data,
        );
        $this->assertEquals($data['user']['id'], $object->user->id);
    }

    /**
     * @Revs(5000)
     */
    public function benchSymphonyVersion(): void
    {
        $data = $this->getPurcheseObject();

        $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
        $serializer = new Serializer([$normalizer]);
        $object = $serializer->denormalize($data, SymphonyDto::class);
    }

    /**
     * @Revs(5000)
     */
    public function benchCuyzVersion(): void
    {
        $data = $this->getPurcheseObject();

        $object = (new \CuyZ\Valinor\MapperBuilder())
            ->mapper()
            ->map(CuyzVelinorDtoDto::class, \CuyZ\Valinor\Mapper\Source\Source::array($data));
    }

    /**
     * @Revs(1000)
     */
    public function benchJaneVersion(): void
    {
        $data = $this->getPurcheseObject();

        $autoMapper = AutoMapper::create();
        $object = $autoMapper->map($data, JanePhpDto::class);

    }

    /**
     * @Revs(5000)
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
        $object = $autoMapper->map($data, JanePhpDto::class);
        
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
                    'id' => 3,
                    'name' => 'book',
                    'price' => 5.5,
                    'description' => 'test description for book',
                    'count' => 333
                ],
                [
                    'id' => 4,
                    'name' => 'PC',
                    'price' => 100,
                    'description' => 'test description for PC',
                    'count' => 7
                ]
            ],
            'user' => [
                'id' => 1,
                'contact' => 'fake@mail.com',
                'balance' => 10012.23,
                'type' => 'admin',
                'realAddress' => 'test address',
                'createdAt' => '2023-04-10',
            ],
            'createdAt' => '2023-04-10',
            'address' => $this->getAddress()
        ];
    }

    private function getAddress()
    {
        return [
            "source" => "мск сухонска 11/-89",
            "result" => "г Москва, ул Сухонская, д 11, кв 89",
            "postal_code" => "127642",
            "country" => "Россия",
            "country_iso_code" => "RU",
            "federal_district" => "Центральный",
            "region_fias_id" => "0c5b2444-70a0-4932-980c-b4dc0d3f02b5",
            "region_kladr_id" => "7700000000000",
            "region_iso_code" => "RU-MOW",
            "region_with_type" => "г Москва",
            "region_type" => "г",
            "region_type_full" => "город",
            "region" => "Москва",
            "area_fias_id" => null,
            "area_kladr_id" => null,
            "area_with_type" => null,
            "area_type" => null,
            "area_type_full" => null,
            "area" => null,
            "city_fias_id" => null,
            "city_kladr_id" => null,
            "city_with_type" => null,
            "city_type" => null,
            "city_type_full" => null,
            "city" => null,
            "city_area" => "Северо-восточный",
            "city_district_fias_id" => null,
            "city_district_kladr_id" => null,
            "city_district_with_type" => "р-н Северное Медведково",
            "city_district_type" => "р-н",
            "city_district_type_full" => "район",
            "city_district" => "Северное Медведково",
            "settlement_fias_id" => null,
            "settlement_kladr_id" => null,
            "settlement_with_type" => null,
            "settlement_type" => null,
            "settlement_type_full" => null,
            "settlement" => null,
            "street_fias_id" => "95dbf7fb-0dd4-4a04-8100-4f6c847564b5",
            "street_kladr_id" => "77000000000283600",
            "street_with_type" => "ул Сухонская",
            "street_type" => "ул",
            "street_type_full" => "улица",
            "street" => "Сухонская",
            "house_fias_id" => "5ee84ac0-eb9a-4b42-b814-2f5f7c27c255",
            "house_kladr_id" => "7700000000028360004",
            "house_type" => "д",
            "house_type_full" => "дом",
            "house" => "11",
            "block_type" => null,
            "block_type_full" => null,
            "block" => null,
            "flat_fias_id" => "f26b876b-6857-4951-b060-ec6559f04a9a",
            "flat_type" => "кв",
            "flat_type_full" => "квартира",
            "flat" => "89",
            "flat_area" => "34.6",
            "square_meter_price" => "239953",
            "flat_price" => "8302374",
            "postal_box" => null,
            "fias_id" => "f26b876b-6857-4951-b060-ec6559f04a9a",
            "fias_code" => "77000000000000028360004",
            "fias_level" => "9",
            "kladr_id" => "7700000000028360004",
            "capital_marker" => "0",
            "okato" => "45280583000",
            "oktmo" => "45362000",
            "tax_office" => "7715",
            "tax_office_legal" => "7715",
            "timezone" => "UTC+3",
            "geo_lat" => "55.8782557",
            "geo_lon" => "37.65372",
            "beltway_hit" => "IN_MKAD",
            "beltway_distance" => null,
            "qc_geo" => 0,
            "qc_complete" => 0,
            "qc_house" => 2,
            "qc" => 0,
            "unparsed_parts" => null,
            "metro" => [
                [
                    "distance" => 1.1,
                    "line" => "Калужско-Рижская",
                    "name" => "Бабушкинская"
                ],
                [
                    "distance" => 1.2,
                    "line" => "Калужско-Рижская",
                    "name" => "Медведково"
                ],
                [
                    "distance" => 2.5,
                    "line" => "Калужско-Рижская",
                    "name" => "Свиблово"
                ]
            ]
        ];
    }
}
