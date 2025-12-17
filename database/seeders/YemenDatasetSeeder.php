<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Airline;
use App\Models\City;
use App\Models\Governorate;

class YemenDatasetSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = [
            'yemenia' => [
                'name_ar' => 'اليمنية',
                'name_en' => 'Yemenia',
                'code' => 'IY',
                'logo' => 'assets/images/yemenia_logo.png',
                'routes' => [
                    [
                        'from' => 'ADE',
                        'to' => 'GXF'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'SCT'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'AAY'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'RIY'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'CAI'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'JED'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'RUH'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'AMM'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'KRT'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'ADD'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'JIB'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'DXB'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'BOM'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'KWI'
                    ],
                    [
                        'from' => 'ADE',
                        'to' => 'DOH'
                    ],
                    [
                        'from' => 'GXF',
                        'to' => 'ADE'
                    ],
                    [
                        'from' => 'GXF',
                        'to' => 'CAI'
                    ],
                    [
                        'from' => 'GXF',
                        'to' => 'JED'
                    ],
                    [
                        'from' => 'SCT',
                        'to' => 'ADE'
                    ],
                    [
                        'from' => 'SCT',
                        'to' => 'AAY'
                    ],
                    [
                        'from' => 'SCT',
                        'to' => 'RIY'
                    ],
                    [
                        'from' => 'RIY',
                        'to' => 'ADE'
                    ],
                    [
                        'from' => 'RIY',
                        'to' => 'SCT'
                    ],
                    [
                        'from' => 'RIY',
                        'to' => 'DXB'
                    ],
                    [
                        'from' => 'RIY',
                        'to' => 'CAI'
                    ],
                    [
                        'from' => 'RIY',
                        'to' => 'JED'
                    ],
                    [
                        'from' => 'AAY',
                        'to' => 'ADE'
                    ],
                    [
                        'from' => 'AAY',
                        'to' => 'SCT'
                    ],
                    [
                        'from' => 'AXK',
                        'to' => 'ADE'
                    ]
                ]
            ],
            'queen_bilqis' => [
                'name_ar' => 'طيران الملكة بلقيس',
                'name_en' => 'Queen Bilqis Airways',
                'code' => 'QB',
                'logo' => 'assets/images/queen_bilqis_logo.png',
                'routes' => [
                    [
                        'from' => 'ADE',
                        'to' => 'CAI'
                    ],
                    [
                        'from' => 'CAI',
                        'to' => 'ADE'
                    ]
                ]
            ],
            'aden_air' => [
                'name_ar' => 'طيران عدن',
                'name_en' => 'Aden Air',
                'code' => 'AD',
                'logo' => 'assets/images/aden_air_logo.png',
                'routes' => [
                    [
                        'from' => 'ADE',
                        'to' => 'CAI'
                    ],
                    [
                        'from' => 'CAI',
                        'to' => 'ADE'
                    ]
                ]
            ]
        ];

        foreach ($airlines as $key => $a) {
            Airline::updateOrCreate(
                ['key' => $key],
                [
                    'name_ar' => $a['name_ar'] ?? $key,
                    'name_en' => $a['name_en'] ?? $key,
                    'code' => $a['code'] ?? null,
                    'logo' => $a['logo'] ?? null,
                    'meta' => [
                        'routes' => $a['routes'] ?? [],
                    ],
                ]
            );
        }

        $cities = [
            [
                'id' => 'ADE',
                'name_ar' => 'عدن',
                'name_en' => 'Aden',
                'type' => 'domestic',
                'country' => 'YE'
            ],
            [
                'id' => 'GXF',
                'name_ar' => 'سيئون',
                'name_en' => 'Seiyun',
                'type' => 'domestic',
                'country' => 'YE'
            ],
            [
                'id' => 'SCT',
                'name_ar' => 'سقطرى',
                'name_en' => 'Socotra',
                'type' => 'domestic',
                'country' => 'YE'
            ],
            [
                'id' => 'AAY',
                'name_ar' => 'الغيضة',
                'name_en' => 'Al Ghaydah',
                'type' => 'domestic',
                'country' => 'YE'
            ],
            [
                'id' => 'RIY',
                'name_ar' => 'الريان المكلا',
                'name_en' => 'Riyan Mukalla',
                'type' => 'domestic',
                'country' => 'YE'
            ],
            [
                'id' => 'AXK',
                'name_ar' => 'عتق',
                'name_en' => 'Ataq',
                'type' => 'domestic',
                'country' => 'YE'
            ],
            [
                'id' => 'CAI',
                'name_ar' => 'القاهرة',
                'name_en' => 'Cairo',
                'type' => 'international',
                'country' => 'EG'
            ],
            [
                'id' => 'JED',
                'name_ar' => 'جدة',
                'name_en' => 'Jeddah',
                'type' => 'international',
                'country' => 'SA'
            ],
            [
                'id' => 'RUH',
                'name_ar' => 'الرياض',
                'name_en' => 'Riyadh',
                'type' => 'international',
                'country' => 'SA'
            ],
            [
                'id' => 'AMM',
                'name_ar' => 'عمّان',
                'name_en' => 'Amman',
                'type' => 'international',
                'country' => 'JO'
            ],
            [
                'id' => 'KRT',
                'name_ar' => 'الخرطوم',
                'name_en' => 'Khartoum',
                'type' => 'international',
                'country' => 'SD'
            ],
            [
                'id' => 'ADD',
                'name_ar' => 'أديس أبابا',
                'name_en' => 'Addis Ababa',
                'type' => 'international',
                'country' => 'ET'
            ],
            [
                'id' => 'JIB',
                'name_ar' => 'جيبوتي',
                'name_en' => 'Djibouti',
                'type' => 'international',
                'country' => 'DJ'
            ],
            [
                'id' => 'DXB',
                'name_ar' => 'دبي',
                'name_en' => 'Dubai',
                'type' => 'international',
                'country' => 'AE'
            ],
            [
                'id' => 'BOM',
                'name_ar' => 'بومباي',
                'name_en' => 'Bombay',
                'type' => 'international',
                'country' => 'IN'
            ],
            [
                'id' => 'KWI',
                'name_ar' => 'الكويت',
                'name_en' => 'Kuwait',
                'type' => 'international',
                'country' => 'KW'
            ],
            [
                'id' => 'DOH',
                'name_ar' => 'الدوحة',
                'name_en' => 'Doha',
                'type' => 'international',
                'country' => 'QA'
            ]
        ];

        foreach ($cities as $c) {
            City::updateOrCreate(
                ['id' => strtoupper($c['id'])],
                [
                    'name_ar' => $c['name_ar'] ?? strtoupper($c['id']),
                    'name_en' => $c['name_en'] ?? strtoupper($c['id']),
                    'type' => $c['type'] ?? null,
                    'country' => $c['country'] ?? null,
                    'meta' => $c,
                ]
            );
        }

        $governorates = [
            [
                'id' => 1,
                'name_ar' => 'أبين',
                'name_en' => 'Abyan',
                'capital_ar' => 'زنجبار',
                'capital_en' => 'Zinjibar'
            ],
            [
                'id' => 2,
                'name_ar' => 'أمانة العاصمة',
                'name_en' => 'Amanat Al Asimah (Sana\'a City)',
                'capital_ar' => 'صنعاء',
                'capital_en' => 'Sana\'a'
            ],
            [
                'id' => 3,
                'name_ar' => 'إب',
                'name_en' => 'Ibb',
                'capital_ar' => 'إب',
                'capital_en' => 'Ibb'
            ],
            [
                'id' => 4,
                'name_ar' => 'البيضاء',
                'name_en' => 'Al Bayda',
                'capital_ar' => 'البيضاء',
                'capital_en' => 'Al Bayda'
            ],
            [
                'id' => 5,
                'name_ar' => 'الحديدة',
                'name_en' => 'Al Hudaydah',
                'capital_ar' => 'الحديدة',
                'capital_en' => 'Al Hudaydah'
            ],
            [
                'id' => 6,
                'name_ar' => 'الجوف',
                'name_en' => 'Al Jawf',
                'capital_ar' => 'الحزم',
                'capital_en' => 'Al Hazm'
            ],
            [
                'id' => 7,
                'name_ar' => 'المحويت',
                'name_en' => 'Al Mahwit',
                'capital_ar' => 'المحويت',
                'capital_en' => 'Al Mahwit'
            ],
            [
                'id' => 8,
                'name_ar' => 'المهرة',
                'name_en' => 'Al Mahrah',
                'capital_ar' => 'الغيضة',
                'capital_en' => 'Al Ghaydah'
            ],
            [
                'id' => 9,
                'name_ar' => 'الضالع',
                'name_en' => 'Ad Dali\'',
                'capital_ar' => 'الضالع',
                'capital_en' => 'Ad Dali\''
            ],
            [
                'id' => 10,
                'name_ar' => 'حجة',
                'name_en' => 'Hajjah',
                'capital_ar' => 'حجة',
                'capital_en' => 'Hajjah'
            ],
            [
                'id' => 11,
                'name_ar' => 'حضرموت',
                'name_en' => 'Hadramawt',
                'capital_ar' => 'المكلا',
                'capital_en' => 'Mukalla'
            ],
            [
                'id' => 12,
                'name_ar' => 'ريمة',
                'name_en' => 'Raymah',
                'capital_ar' => 'الجبين',
                'capital_en' => 'Al Jabin'
            ],
            [
                'id' => 13,
                'name_ar' => 'شبوة',
                'name_en' => 'Shabwah',
                'capital_ar' => 'عتق',
                'capital_en' => 'Ataq'
            ],
            [
                'id' => 14,
                'name_ar' => 'صعدة',
                'name_en' => 'Sa\'dah',
                'capital_ar' => 'صعدة',
                'capital_en' => 'Sa\'dah'
            ],
            [
                'id' => 15,
                'name_ar' => 'صنعاء',
                'name_en' => 'Sana\'a',
                'capital_ar' => 'صنعاء',
                'capital_en' => 'Sana\'a'
            ],
            [
                'id' => 16,
                'name_ar' => 'تعز',
                'name_en' => 'Taizz',
                'capital_ar' => 'تعز',
                'capital_en' => 'Taizz'
            ],
            [
                'id' => 17,
                'name_ar' => 'عدن',
                'name_en' => 'Aden',
                'capital_ar' => 'عدن',
                'capital_en' => 'Aden'
            ],
            [
                'id' => 18,
                'name_ar' => 'عمران',
                'name_en' => 'Amran',
                'capital_ar' => 'عمران',
                'capital_en' => 'Amran'
            ],
            [
                'id' => 19,
                'name_ar' => 'لحج',
                'name_en' => 'Lahij',
                'capital_ar' => 'الحوطة',
                'capital_en' => 'Al Houta'
            ],
            [
                'id' => 20,
                'name_ar' => 'مأرب',
                'name_en' => 'Ma\'rib',
                'capital_ar' => 'مأرب',
                'capital_en' => 'Ma\'rib'
            ],
            [
                'id' => 21,
                'name_ar' => 'سقطرى',
                'name_en' => 'Socotra',
                'capital_ar' => 'حديبو',
                'capital_en' => 'Hadibu'
            ],
            [
                'id' => 22,
                'name_ar' => 'ذمار',
                'name_en' => 'Dhamar',
                'capital_ar' => 'ذمار',
                'capital_en' => 'Dhamar'
            ]
        ];

        foreach ($governorates as $g) {
            Governorate::updateOrCreate(
                ['name_en' => $g['name_en'] ?? ''],
                [
                    'name_ar' => $g['name_ar'] ?? '',
                    'name_en' => $g['name_en'] ?? '',
                    'capital_ar' => $g['capital_ar'] ?? null,
                    'capital_en' => $g['capital_en'] ?? null,
                    'meta' => $g,
                ]
            );
        }
    }
}
