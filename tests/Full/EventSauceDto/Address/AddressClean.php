<?php

namespace Tests\Full\EventSauceDto\Address;

use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 */
class AddressClean
{
    public function __construct(
        public ?string $source,
        public ?string $result,
        public ?string $postal_code,
        public ?string $country,
        public ?string $country_iso_code,
        public ?string $federal_district,
        public ?string $fias_code,
        public ?string $region_fias_id,
        public ?string $region_kladr_id,
        public ?string $region_iso_code,
        public ?string $region_with_type,
        public ?string $region_type,
        public ?string $region_type_full,
        public ?string $region,
        public ?string $area_fias_id,
        public ?string $area_kladr_id,
        public ?string $area_with_type,
        public ?string $area_type,
        public ?string $area_type_full,
        public ?string $area,
        public ?string $city_fias_id,
        public ?string $city_kladr_id,
        public ?string $city_with_type,
        public ?string $city_type,
        public ?string $city_type_full,
        public ?string $city,
        public ?string $city_area,
        public ?string $city_district_fias_id,
        public ?string $city_district_kladr_id,
        public ?string $city_district_with_type,
        public ?string $city_district_type,
        public ?string $city_district_type_full,
        public ?string $city_district,
        public ?string $settlement_fias_id,
        public ?string $settlement_kladr_id,
        public ?string $settlement_with_type,
        public ?string $settlement_type,
        public ?string $settlement_type_full,
        public ?string $settlement,
        public ?string $street_fias_id,
        public ?string $street_kladr_id,
        public ?string $street_with_type,
        public ?string $street_type,
        public ?string $street_type_full,
        public ?string $street,
        public ?string $house_fias_id,
        public ?string $house_kladr_id,
        public ?string $house_type,
        public ?string $house_type_full,
        public ?string $house,
        public ?string $block_type,
        public ?string $block_type_full,
        public ?string $block,
        public ?string $flat_type,
        public ?string $flat_fias_id,
        public ?string $flat_type_full,
        public ?string $flat,
        public ?string $flat_area,
        public ?string $square_meter_price,
        public ?string $flat_price,
        public ?string $postal_box,
        public ?string $fias_id,
        #[CastToType('integer')]
        public ?int $fias_level,
        public ?string $kladr_id,
        #[CastToType('integer')]
        public ?int $capital_marker,
        public ?string $okato,
        public ?string $oktmo,
        public ?string $tax_office,
        public ?string $tax_office_legal,
        public ?string $timezone,
        #[CastToType('float')]
        public ?float $geo_lat,
        #[CastToType('float')]
        public ?float $geo_lon,
        public ?string $beltway_hit,
        #[CastToType('integer')]
        public ?int $beltway_distance,
        #[CastToType('integer')]
        public ?int $qc,
        #[CastToType('integer')]
        public ?int $qc_geo,
        #[CastToType('integer')]
        public ?int $qc_complete,
        #[CastToType('integer')]
        public ?int $qc_house,
        public ?string $unparsed_parts,

        #[CastListToType(MetroDto::class)]
        public ?array $metro,
    ) {
    }

}
