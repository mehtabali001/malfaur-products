<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed hierarchical category tree (Levels 1 through 4) and map products.
     */
    public function run(): void
    {
        $treeData = [
            [
                'name' => 'Cutting Tools',
                'slug' => 'cutting-tools',
                'color' => 'orange',
                'icon' => 'tool',
                'sort_order' => 1,
                'children' => [
                    [
                        'name' => 'Reamers & Deburring',
                        'slug' => 'reamers-deburring',
                        'children' => [
                            [
                                'name' => 'Machine Reamers',
                                'slug' => 'machine-reamers',
                                'children' => [
                                    ['name' => 'Solid Carbide Spiral Flute', 'slug' => 'solid-carbide-spiral-flute'],
                                    ['name' => 'HSS-Co Straight Flute', 'slug' => 'hss-co-straight-flute'],
                                ]
                            ],
                            [
                                'name' => 'Hand Reamers',
                                'slug' => 'hand-reamers',
                                'children' => [
                                    ['name' => 'Adjustable Blade Hand Reamers', 'slug' => 'adjustable-blade-hand-reamers'],
                                ]
                            ],
                            ['name' => 'Chucking Reamers', 'slug' => 'chucking-reamers'],
                            ['name' => 'Bridge Reamers', 'slug' => 'bridge-reamers'],
                            ['name' => 'Deburring Tools & Blades', 'slug' => 'deburring-tools-blades'],
                        ]
                    ],
                    [
                        'name' => 'Countersinks & Counterbores',
                        'slug' => 'countersinks-counterbores',
                        'children' => [
                            [
                                'name' => '90° Countersinks',
                                'slug' => '90-deg-countersinks',
                                'children' => [
                                    ['name' => '3-Flute DIN 335 Form C', 'slug' => '3-flute-din-335-form-c'],
                                    ['name' => 'Single Flute Chatless', 'slug' => 'single-flute-chatless'],
                                ]
                            ],
                            ['name' => 'Flat Bottom Counterbores', 'slug' => 'flat-bottom-counterbores'],
                            ['name' => 'Reverse Countersinks', 'slug' => 'reverse-countersinks'],
                        ]
                    ],
                    [
                        'name' => 'Parting Off Blades & Cutters',
                        'slug' => 'parting-off-blades-cutters',
                        'children' => [
                            ['name' => 'Double-Ended Parting Blades', 'slug' => 'double-ended-parting-blades'],
                            ['name' => 'Carbide Insert Toolholders', 'slug' => 'carbide-insert-toolholders'],
                            ['name' => 'Slitting Saws', 'slug' => 'slitting-saws'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Measuring Equipment',
                'slug' => 'measuring-equipment',
                'color' => 'blue',
                'icon' => 'scale',
                'sort_order' => 2,
                'children' => [
                    [
                        'name' => 'Micrometers & Heads',
                        'slug' => 'micrometers-heads',
                        'children' => [
                            [
                                'name' => 'External Micrometers',
                                'slug' => 'external-micrometers',
                                'children' => [
                                    ['name' => 'Digital IP65 Ratchet Stop', 'slug' => 'digital-ip65-ratchet-stop'],
                                    ['name' => 'Vernier Carbide Anvil', 'slug' => 'vernier-carbide-anvil'],
                                ]
                            ],
                            ['name' => 'Digital Micrometers', 'slug' => 'digital-micrometers'],
                            ['name' => 'Depth Micrometers', 'slug' => 'depth-micrometers'],
                            ['name' => 'Micrometer Heads', 'slug' => 'micrometer-heads'],
                        ]
                    ],
                    [
                        'name' => 'Inside Measuring Instruments',
                        'slug' => 'inside-measuring-instruments',
                        'children' => [
                            ['name' => 'Precision Bore Gauges', 'slug' => 'precision-bore-gauges'],
                            ['name' => 'Three-Point Internal Micrometers', 'slug' => 'three-point-internal-micrometers'],
                            ['name' => 'Telescopic Gauges', 'slug' => 'telescopic-gauges'],
                        ]
                    ],
                    [
                        'name' => 'Calipers & Height Gauges',
                        'slug' => 'calipers-height-gauges',
                        'children' => [
                            ['name' => 'Vernier Calipers', 'slug' => 'vernier-calipers'],
                            ['name' => 'Digital Absolute Calipers', 'slug' => 'digital-absolute-calipers'],
                            ['name' => 'Precision Height Gauges', 'slug' => 'precision-height-gauges'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Standard Parts',
                'slug' => 'standard-parts',
                'color' => 'green',
                'icon' => 'settings',
                'sort_order' => 3,
                'children' => [
                    [
                        'name' => 'Spring Plungers',
                        'slug' => 'spring-plungers',
                        'children' => [
                            [
                                'name' => 'Threaded Ball Plungers',
                                'slug' => 'threaded-ball-plungers',
                                'children' => [
                                    ['name' => 'Stainless Steel Ball & Spring', 'slug' => 'stainless-steel-ball-spring'],
                                    ['name' => 'Heavy End Force Steel Plungers', 'slug' => 'heavy-end-force-steel-plungers'],
                                ]
                            ],
                            ['name' => 'Smooth Press-Fit Plungers', 'slug' => 'smooth-press-fit-plungers'],
                            ['name' => 'Hex Socket Plungers', 'slug' => 'hex-socket-plungers'],
                        ]
                    ],
                    [
                        'name' => 'Indexing Plungers & Positioning',
                        'slug' => 'indexing-plungers-positioning',
                        'children' => [
                            ['name' => 'Pull-Ring Indexing Plungers', 'slug' => 'pull-ring-indexing-plungers'],
                            ['name' => 'Knob Type Locating Pins', 'slug' => 'knob-type-locating-pins'],
                            ['name' => 'Rest Buttons & Support Screws', 'slug' => 'rest-buttons-support-screws'],
                        ]
                    ],
                    [
                        'name' => 'Fasteners & Bearings',
                        'slug' => 'fasteners-bearings',
                        'children' => [
                            ['name' => 'Precision Ground Dowel Pins', 'slug' => 'precision-ground-dowel-pins'],
                            ['name' => 'Linear Bushings & Bearings', 'slug' => 'linear-bushings-bearings'],
                            ['name' => 'Clamping Levers & Knobs', 'slug' => 'clamping-levers-knobs'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Aerospace Parts',
                'slug' => 'aerospace-parts',
                'color' => 'purple',
                'icon' => 'globe',
                'sort_order' => 4,
                'children' => [
                    [
                        'name' => 'Superalloys & High-Nickel',
                        'slug' => 'superalloys-high-nickel',
                        'children' => [
                            ['name' => 'Inconel 718 Round Bars', 'slug' => 'inconel-718-round-bars'],
                            ['name' => 'Hastelloy C-276 Tubes', 'slug' => 'hastelloy-c276-tubes'],
                            ['name' => 'Titanium Grade 5 (Ti-6Al-4V)', 'slug' => 'titanium-grade-5'],
                        ]
                    ],
                    [
                        'name' => 'Aviation Fittings & Consumables',
                        'slug' => 'aviation-fittings-consumables',
                        'children' => [
                            ['name' => 'AN/MS Hydraulic Fittings', 'slug' => 'an-ms-hydraulic-fittings'],
                            ['name' => 'Solid Shank Aircraft Rivets', 'slug' => 'solid-shank-aircraft-rivets'],
                            ['name' => 'High Pressure Flanges', 'slug' => 'high-pressure-flanges'],
                        ]
                    ],
                    [
                        'name' => 'Aerospace Fasteners & Seals',
                        'slug' => 'aerospace-fasteners-seals',
                        'children' => [
                            ['name' => 'Fluorosilicone High-Temp O-Rings', 'slug' => 'fluorosilicone-high-temp-o-rings'],
                            ['name' => 'Lockbolts & Collar Fasteners', 'slug' => 'lockbolts-collar-fasteners'],
                            ['name' => 'NAS Precision Shear Bolts', 'slug' => 'nas-precision-shear-bolts'],
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Raw Materials',
                'slug' => 'raw-materials',
                'color' => 'amber',
                'icon' => 'layers',
                'sort_order' => 5,
                'children' => [
                    [
                        'name' => 'Alloy Steels & Tubes',
                        'slug' => 'alloy-steels-tubes',
                        'children' => [
                            ['name' => '4130 Chrome Moly Streamline Tubes', 'slug' => '4130-chrome-moly-streamline-tubes'],
                            ['name' => 'EN24T High Tensile Round Bars', 'slug' => 'en24t-high-tensile-round-bars'],
                            ['name' => 'O1 Precision Ground Flat Stock', 'slug' => 'o1-precision-ground-flat-stock'],
                        ]
                    ],
                    [
                        'name' => 'Aluminium Profiles & Extrusions',
                        'slug' => 'aluminium-profiles-extrusions',
                        'children' => [
                            ['name' => 'Modular T-Slot Structural Rails', 'slug' => 'modular-t-slot-structural-rails'],
                            ['name' => 'Equal & Unequal Aluminium Angles', 'slug' => 'equal-unequal-aluminium-angles'],
                            ['name' => 'Architectural Aluminium Channels', 'slug' => 'architectural-aluminium-channels'],
                        ]
                    ],
                    [
                        'name' => 'Sheets, Plates & Foils',
                        'slug' => 'sheets-plates-foils',
                        'children' => [
                            ['name' => '5-Bar Aluminium Tread Plates', 'slug' => '5-bar-aluminium-tread-plates'],
                            ['name' => 'Precision Gauge Stainless Shims', 'slug' => 'precision-gauge-stainless-shims'],
                            ['name' => 'High-Purity Aluminium Foil', 'slug' => 'high-purity-aluminium-foil'],
                        ]
                    ],
                ]
            ],
        ];

        foreach ($treeData as $rootData) {
            $children = $rootData['children'] ?? [];
            unset($rootData['children']);
            $root = Category::updateOrCreate(['slug' => $rootData['slug']], $rootData);

            $this->seedChildren($children, $root->id, $root->color);
        }

        // Map existing products to proper category IDs
        $this->mapExistingProducts();
    }

    private function seedChildren(array $children, int $parentId, string $color, int $sort = 1): void
    {
        foreach ($children as $childData) {
            $grandChildren = $childData['children'] ?? [];
            unset($childData['children']);
            
            $childData['parent_id'] = $parentId;
            $childData['color'] = $color;
            $childData['sort_order'] = $sort++;

            $child = Category::updateOrCreate(['slug' => $childData['slug']], $childData);

            if (!empty($grandChildren)) {
                $this->seedChildren($grandChildren, $child->id, $color);
            }
        }
    }

    private function mapExistingProducts(): void
    {
        $products = Product::all();
        $catRoots = Category::whereNull('parent_id')->get()->keyBy('name');
        
        $machineReamers = Category::where('slug', 'machine-reamers')->first();
        $countersinks = Category::where('slug', '90-deg-countersinks')->first();
        $parting = Category::where('slug', 'parting-off-blades-cutters')->first();
        $micrometers = Category::where('slug', 'external-micrometers')->first();
        $inside = Category::where('slug', 'inside-measuring-instruments')->first();
        $calipers = Category::where('slug', 'calipers-height-gauges')->first();
        $plungers = Category::where('slug', 'spring-plungers')->first();
        $indexing = Category::where('slug', 'indexing-plungers-positioning')->first();
        $fasteners = Category::where('slug', 'fasteners-bearings')->first();
        $superalloys = Category::where('slug', 'superalloys-high-nickel')->first();
        $aviation = Category::where('slug', 'aviation-fittings-consumables')->first();
        $tubes = Category::where('slug', 'alloy-steels-tubes')->first();
        $profiles = Category::where('slug', 'aluminium-profiles-extrusions')->first();
        $sheets = Category::where('slug', 'sheets-plates-foils')->first();

        foreach ($products as $p) {
            $name = strtolower($p->name . ' ' . $p->title . ' ' . $p->slug);
            $catId = null;

            if (str_contains($name, 'reamer')) {
                $catId = $machineReamers?->id;
            } elseif (str_contains($name, 'countersink') || str_contains($name, 'counterbore')) {
                $catId = $countersinks?->id;
            } elseif (str_contains($name, 'parting') || str_contains($name, 'blade') || str_contains($name, 'end mill') || str_contains($name, 'insert') || str_contains($name, 'milling') || str_contains($name, 'cutter')) {
                $catId = $parting?->id;
            } elseif (str_contains($name, 'micrometer')) {
                $catId = $micrometers?->id;
            } elseif (str_contains($name, 'bore') || str_contains($name, 'inside') || str_contains($name, 'gauge')) {
                $catId = $inside?->id;
            } elseif (str_contains($name, 'caliper') || str_contains($name, 'height')) {
                $catId = $calipers?->id;
            } elseif (str_contains($name, 'spring') || str_contains($name, 'ball plunger')) {
                $catId = $plungers?->id;
            } elseif (str_contains($name, 'index') || str_contains($name, 'locating')) {
                $catId = $indexing?->id;
            } elseif (str_contains($name, 'fastener') || str_contains($name, 'dowel') || str_contains($name, 'bearing') || str_contains($name, 'bushing')) {
                $catId = $fasteners?->id;
            } elseif (str_contains($name, 'inconel') || str_contains($name, 'hastelloy') || str_contains($name, 'superalloy') || str_contains($name, 'titanium') || str_contains($name, 'alloy c') || str_contains($name, 'alloy x')) {
                $catId = $superalloys?->id;
            } elseif (str_contains($name, 'fitting') || str_contains($name, 'rivet') || str_contains($name, 'flange')) {
                $catId = $aviation?->id;
            } elseif (str_contains($name, 'streamline') || str_contains($name, 'steel tube') || str_contains($name, 'alloy steel') || str_contains($name, 'round bar') || str_contains($name, 'flat stock') || str_contains($name, 'hex bar')) {
                $catId = $tubes?->id;
            } elseif (str_contains($name, 't-slot') || str_contains($name, 'channel') || str_contains($name, 'angle') || str_contains($name, 'extrusion') || str_contains($name, 'profile')) {
                $catId = $profiles?->id;
            } elseif (str_contains($name, 'tread plate') || str_contains($name, 'foil') || str_contains($name, 'sheet') || str_contains($name, 'shim') || str_contains($name, 'plate')) {
                $catId = $sheets?->id;
            }

            // Fallback to root category by existing category string
            if (!$catId && !empty($p->category) && isset($catRoots[$p->category])) {
                $catId = $catRoots[$p->category]->id;
            }
            if (!$catId && !empty($p->root_category_name) && isset($catRoots[$p->root_category_name])) {
                $catId = $catRoots[$p->root_category_name]->id;
            }

            if ($catId) {
                $p->category_id = $catId;
                $p->saveQuietly();
            }
        }
    }
}
