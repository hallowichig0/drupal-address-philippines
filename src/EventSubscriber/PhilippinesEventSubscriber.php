<?php

namespace Drupal\drupal_address_metromanila_cities\EventSubscriber;

use CommerceGuys\Addressing\AddressFormat\AdministrativeAreaType;
use Drupal\address\Event\AddressEvents;
use Drupal\address\Event\AddressFormatEvent;
use Drupal\address\Event\SubdivisionsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Adds a county field and a predefined list of counties for Great Britain.
 *
 * Counties are not provided by the library because they're not used for
 * addressing. However, sites might want to add them for other purposes.
 */
class PhilippinesEventSubscriber implements EventSubscriberInterface {

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        $events[AddressEvents::ADDRESS_FORMAT][] = ['onAddressFormat'];
        $events[AddressEvents::SUBDIVISIONS][] = ['onSubdivisions'];
        return $events;
    }

    /**
     * Alters the address format for Philippines.
     *
     * @param \Drupal\address\Event\AddressFormatEvent $event
     *   The address format event.
     */
    public function onAddressFormat(AddressFormatEvent $event) {
        $definition = $event->getDefinition();
        // dpm($definition);
        if ($definition['country_code'] == 'PH') {
            // $definition['format'] = $definition['format'] . "\n%locality";
            $definition['format'] = "
                %givenName %familyName\n
                %organization\n
                %addressLine1\n
                %addressLine2\n
                %dependentLocality
                %administrativeArea\n
                %locality\n
                %postalCode ";
            // $definition['locality_type'] = LocalityType::CITY;
            // $definition['administrative_area_type'] = AdministrativeAreaType::PROVINCE;
            $definition['subdivision_depth'] = 2;
            $definition['dependent_locality_type'] = 'district';
            $event->setDefinition($definition);
        }
    }

    /**
     * Provides the subdivisions for Great Britain.
     *
     * Note: Provides just the Welsh counties. A real subscriber would include
     * the full list, sourced from the CLDR "Territory Subdivisions" listing.
     *
     * @param \Drupal\address\Event\SubdivisionsEvent $event
     *   The subdivisions event.
     */
    public function onSubdivisions(SubdivisionsEvent $event) {
        // For administrative areas $parents is an array with just the country code.
        // Otherwise it also contains the parent subdivision codes. For example,
        // if we were defining cities in California, $parents would be ['US', 'CA'].
        $parents = $event->getParents();
        $current_definitions = $event->getDefinitions();
        // dpm($current_definitions);
        
        // if ($event->getParents() != ['PH']) {
        //     return;
        // }

        $definitions = [
            'country_code' => $parents[0],
            'parents' => $parents,
            'subdivisions' => 
                // Key by the subdivision code, which is the value that's displayed on
                // the formatted address. Could be an abbreviation (e.g 'CA' for
                // California) or a full name like below.
                // If it's an abbreviation, define a 'name' in the subarray, to be used
                // in the address widget dropdown.
                $this->getPhilippinesProvinces(),
        ];
        
        
        // if($parents[1] == 'Abra') {
        //     $definitions = [
        //         'country_code' => $parents[0],
        //         'parents' => $parents,
        //         'subdivisions' => [
        //             'Abra' => [
        //                 "country_code" => "PH",
        //                 "code" => "Abra",
        //                 "name" => "Abra",
        //             ],
        //         ],
        //     ];
        // }
        // if($parents[1] == 'Agusan del Norte') {
        //     $definitions = [
        //         'country_code' => $parents[0],
        //         'parents' => $parents,
        //         'subdivisions' => [
        //             'Agusan del Norte' => [
        //                 "country_code" => "PH",
        //                 "code" => "Agusan del Norte",
        //                 "name" => "Agusan del Norte",
        //             ],
        //         ],
        //     ];
        // }
        // if($parents[1] == 'Agusan del Sur') {
        //     $definitions = [
        //         'country_code' => $parents[0],
        //         'parents' => $parents,
        //         'subdivisions' => [
        //             'Agusan del Sur' => [
        //                 "country_code" => "PH",
        //                 "code" => "Agusan del Sur",
        //                 "name" => "Agusan del Sur",
        //             ],
        //         ],
        //     ];
        // }
        if(isset($parents[1]) && $parents[1] == 'Metro Manila') {
            $definitions = [
                'country_code' => $parents[0],
                'parents' => $parents,
                'subdivisions' => $this->getMetroManilaCities(),
            ];
        }
        $event->setDefinitions($definitions);
    }

    public function getMetroManilaCities() {
        return [
            'Caloocan' => [
                "country_code" => "PH",
                "code" => "Caloocan",
                "name" => "Caloocan",
            ],
            'Malabon' => [
                "country_code" => "PH",
                "code" => "Malabon",
                "name" => "Malabon",
            ],
            'Navotas' => [
                "country_code" => "PH",
                "code" => "Navotas",
                "name" => "Navotas",
            ],
            'Valenzuela' => [
                "country_code" => "PH",
                "code" => "Valenzuela",
                "name" => "Valenzuela",
            ],
            'Quezon City' => [
                "country_code" => "PH",
                "code" => "Quezon City",
                "name" => "Quezon City",
            ],
            'Marikina' => [
                "country_code" => "PH",
                "code" => "Marikina",
                "name" => "Marikina",
            ],
            'Pasig' => [
                "country_code" => "PH",
                "code" => "Pasig",
                "name" => "Pasig",
            ],
            'Pateros' => [
                "country_code" => "PH",
                "code" => "Pateros",
                "name" => "Pateros",
            ],
            'Taguig' => [
                "country_code" => "PH",
                "code" => "Taguig",
                "name" => "Taguig",
            ],
            'Makati' => [
                "country_code" => "PH",
                "code" => "Makati",
                "name" => "Makati",
            ],
            'Manila' => [
                "country_code" => "PH",
                "code" => "Manila",
                "name" => "Manila",
            ],
            'Mandaluyong' => [
                "country_code" => "PH",
                "code" => "Mandaluyong",
                "name" => "Mandaluyong",
            ],
            'San Juan' => [
                "country_code" => "PH",
                "code" => "San Juan",
                "name" => "San Juan",
            ],
            'Pasay' => [
                "country_code" => "PH",
                "code" => "Pasay",
                "name" => "Pasay",
            ],
            'Parañaque' => [
                "country_code" => "PH",
                "code" => "Parañaque",
                "name" => "Parañaque",
            ],
            'Las Piñas' => [
                "country_code" => "PH",
                "code" => "Las Piñas",
                "name" => "Las Piñas",
            ],
            'Muntinlupa' => [
                "country_code" => "PH",
                "code" => "Muntinlupa",
                "name" => "Muntinlupa",
            ]
        ];
    }

    public function getPhilippinesProvinces() {
        return [
            'Abra' => [
                "iso_code" => "PH-ABR",
                "postal_code_pattern" => "28[0-2]",
                "country_code" => "PH",
                "code" => "Abra",
                "name" => "Abra",
            ],
            'Agusan del Norte' => [
                "iso_code" => "PH-AGN",
                "postal_code_pattern" => "86[01]",
                "country_code" => "PH",
                "code" => "Agusan del Norte",
                "name" => "Agusan del Norte",
            ],
            'Agusan del Sur' => [
                "iso_code" => "PH-AGS",
                "postal_code_pattern" => "85[01]",
                "country_code" => "PH",
                "code" => "Agusan del Sur",
                "name" => "Agusan del Sur",
            ],
            'Aklan' => [
                "iso_code" => "PH-AKL",
                "postal_code_pattern" => "56[01]",
                "country_code" => "PH",
                "code" => "Aklan",
                "name" => "Aklan",
            ],
            'Albay' => [
                "iso_code" => "PH-ALB",
                "postal_code_pattern" => "45[01]",
                "country_code" => "PH",
                "code" => "Albay",
                "name" => "Albay",
            ],
            'Antique' => [
                "iso_code" => "PH-ANT",
                "postal_code_pattern" => "57[01]",
                "country_code" => "PH",
                "code" => "Antique",
                "name" => "Antique",
            ],
            'Apayao' => [
                "iso_code" => "PH-APA",
                "postal_code_pattern" => "380[0-68]",
                "country_code" => "PH",
                "code" => "Apayao",
                "name" => "Apayao",
            ],
            'Aurora' => [
                "iso_code" => "PH-AUR",
                "postal_code_pattern" => "320",
                "country_code" => "PH",
                "code" => "Aurora",
                "name" => "Aurora",
            ],
            'Basilan' => [
                "iso_code" => "PH-BAS",
                "postal_code_pattern" => "730",
                "country_code" => "PH",
                "code" => "Basilan",
                "name" => "Basilan",
            ],
            'Bataan' => [
                "iso_code" => "PH-BAN",
                "postal_code_pattern" => "21[01]",
                "country_code" => "PH",
                "code" => "Bataan",
                "name" => "Bataan",
            ],
            'Batanes' => [
                "iso_code" => "PH-BTN",
                "postal_code_pattern" => "390",
                "country_code" => "PH",
                "code" => "Batanes",
                "name" => "Batanes",
            ],
            'Batangas' => [
                "iso_code" => "PH-BTG",
                "postal_code_pattern" => "42[0-3]",
                "country_code" => "PH",
                "code" => "Batangas",
                "name" => "Batangas",
            ],
            'Benguet' => [
                "iso_code" => "PH-BEN",
                "postal_code_pattern" => "26(0|1[0-5])",
                "country_code" => "PH",
                "code" => "Benguet",
                "name" => "Benguet",
            ],
            'Biliran' => [
                "iso_code" => "PH-BIL",
                "postal_code_pattern" => "65(4[3-9]|5)",
                "country_code" => "PH",
                "code" => "Biliran",
                "name" => "Biliran",
            ],
            'Bohol' => [
                "iso_code" => "PH-BOH",
                "postal_code_pattern" => "63[0-3]",
                "country_code" => "PH",
                "code" => "Bohol",
                "name" => "Bohol",
            ],
            'Bukidnon' => [
                "iso_code" => "PH-BUK",
                "postal_code_pattern" => "87[0-2]",
                "country_code" => "PH",
                "code" => "Bukidnon",
                "name" => "Bukidnon",
            ],
            'Bulacan' => [
                "iso_code" => "PH-BUL",
                "postal_code_pattern" => "30[0-2]",
                "country_code" => "PH",
                "code" => "Bulacan",
                "name" => "Bulacan",
            ],
            'Cagayan' => [
                "iso_code" => "PH-CAG",
                "postal_code_pattern" => "35[0-2]",
                "country_code" => "PH",
                "code" => "Cagayan",
                "name" => "Cagayan",
            ],
            'Camarines Norte' => [
                "iso_code" => "PH-CAN",
                "postal_code_pattern" => "46[01]",
                "country_code" => "PH",
                "code" => "Camarines Norte",
                "name" => "Camarines Norte",
            ],
            'Camarines Sur' => [
                "iso_code" => "PH-CAS",
                "postal_code_pattern" => "44[0-3]",
                "country_code" => "PH",
                "code" => "Camarines Sur",
                "name" => "Camarines Sur",
            ],
            'Camiguin' => [
                "iso_code" => "PH-CAM",
                "postal_code_pattern" => "910",
                "country_code" => "PH",
                "code" => "Camiguin",
                "name" => "Camiguin",
            ],
            'Capiz' => [
                "iso_code" => "PH-CAP",
                "postal_code_pattern" => "58[01]",
                "country_code" => "PH",
                "code" => "Capiz",
                "name" => "Capiz",
            ],
            'Catanduanes' => [
                "iso_code" => "PH-CAT",
                "postal_code_pattern" => "48[01]",
                "country_code" => "PH",
                "code" => "Catanduanes",
                "name" => "Catanduanes",
            ],
            'Cavite' => [
                "iso_code" => "PH-CAV",
                "postal_code_pattern" => "41[0-2]",
                "country_code" => "PH",
                "code" => "Cavite",
                "name" => "Cavite",
            ],
            'Cebu' => [
                "iso_code" => "PH-CEB",
                "postal_code_pattern" => "60[0-5]",
                "country_code" => "PH",
                "code" => "Cebu",
                "name" => "Cebu",
            ],
            'Compostela Valley' => [
                "iso_code" => "PH-COM",
                "postal_code_pattern" => "88[01]",
                "country_code" => "PH",
                "code" => "Compostela Valley",
                "name" => "Compostela Valley",
            ],
            'Cotabato' => [
                "iso_code" => "PH-NCO",
                "postal_code_pattern" => "94[01]",
                "country_code" => "PH",
                "code" => "Cotabato",
                "name" => "Cotabato",
            ],
            'Davao del Norte' => [
                "iso_code" => "PH-DAV",
                "postal_code_pattern" => "81[0-2]",
                "country_code" => "PH",
                "code" => "Davao del Norte",
                "name" => "Davao del Norte",
            ],
            'Davao del Sur' => [
                "iso_code" => "PH-DAS",
                "postal_code_pattern" => "80[01]",
                "country_code" => "PH",
                "code" => "Davao del Sur",
                "name" => "Davao del Sur",
            ],
            'Davao Occidental' => [
                "iso_code" => "PH-DVO",
                "postal_code_pattern" => "801[1-5]",
                "country_code" => "PH",
                "code" => "Davao Occidental",
                "name" => "Davao Occidental",
            ],
            'Davao Oriental' => [
                "iso_code" => "PH-DAO",
                "postal_code_pattern" => "82[01]",
                "country_code" => "PH",
                "code" => "Davao Oriental",
                "name" => "Davao Oriental",
            ],
            'Dinagat Islands' => [
                "iso_code" => "PH-DIN",
                "postal_code_pattern" => "84[12]",
                "country_code" => "PH",
                "code" => "Dinagat Islands",
                "name" => "Dinagat Islands",
            ],
            'Eastern Samar' => [
                "iso_code" => "PH-EAS",
                "postal_code_pattern" => "68[0-2]",
                "country_code" => "PH",
                "code" => "Eastern Samar",
                "name" => "Eastern Samar",
            ],
            'Guimaras' => [
                "iso_code" => "PH-GUI",
                "postal_code_pattern" => "504[4-6]",
                "country_code" => "PH",
                "code" => "Guimaras",
                "name" => "Guimaras",
            ],
            'Ifugao' => [
                "iso_code" => "PH-IFU",
                "postal_code_pattern" => "36[01]",
                "country_code" => "PH",
                "code" => "Ifugao",
                "name" => "Ifugao",
            ],
            'Ilocos Norte' => [
                "iso_code" => "PH-ILN",
                "postal_code_pattern" => "29[0-2]",
                "country_code" => "PH",
                "code" => "Ilocos Norte",
                "name" => "Ilocos Norte",
            ],
            'Ilocos Sur' => [
                "iso_code" => "PH-ILS",
                "postal_code_pattern" => "27[0-3]",
                "country_code" => "PH",
                "code" => "Ilocos Sur",
                "name" => "Ilocos Sur",
            ],
            'Iloilo' => [
                "iso_code" => "PH-ILI",
                "postal_code_pattern" => "50([0-3]|4[0-3])",
                "country_code" => "PH",
                "code" => "Iloilo",
                "name" => "Iloilo",
            ],
            'Isabela' => [
                "iso_code" => "PH-ISA",
                "postal_code_pattern" => "33[0-3]",
                "country_code" => "PH",
                "code" => "Isabela",
                "name" => "Isabela",
            ],
            'Kalinga' => [
                "iso_code" => "PH-KAL",
                "postal_code_pattern" => "38(0[79]|1[0-4])",
                "country_code" => "PH",
                "code" => "Kalinga",
                "name" => "Kalinga",
            ],
            'La Union' => [
                "iso_code" => "PH-LUN",
                "postal_code_pattern" => "25[0-2]",
                "country_code" => "PH",
                "code" => "La Union",
                "name" => "La Union",
            ],
            'Laguna' => [
                "iso_code" => "PH-LAG",
                "postal_code_pattern" => "40[0-3]",
                "country_code" => "PH",
                "code" => "Laguna",
                "name" => "Laguna",
            ],
            'Lanao del Norte' => [
                "iso_code" => "PH-LAN",
                "postal_code_pattern" => "92[0-2]",
                "country_code" => "PH",
                "code" => "Lanao del Norte",
                "name" => "Lanao del Norte",
            ],
            'Lanao del Sur' => [
                "iso_code" => "PH-LAS",
                "postal_code_pattern" => "9(3[0-2]|7[01])",
                "country_code" => "PH",
                "code" => "Lanao del Sur",
                "name" => "Lanao del Sur",
            ],
            'Leyte' => [
                "iso_code" => "PH-LEY",
                "postal_code_pattern" => "65([0-3]|4[0-2])",
                "country_code" => "PH",
                "code" => "Leyte",
                "name" => "Leyte",
            ],
            'Maguindanao' => [
                "iso_code" => "PH-MAG",
                "postal_code_pattern" => "96[01]",
                "country_code" => "PH",
                "code" => "Maguindanao",
                "name" => "Maguindanao",
            ],
            'Marinduque' => [
                "iso_code" => "PH-MAD",
                "postal_code_pattern" => "490",
                "country_code" => "PH",
                "code" => "Marinduque",
                "name" => "Marinduque",
            ],
            'Masbate' => [
                "iso_code" => "PH-MAS",
                "postal_code_pattern" => "54[0-2]",
                "country_code" => "PH",
                "code" => "Masbate",
                "name" => "Masbate",
            ],
            'Metro Manila' => [
                "iso_code" => "PH-00",
                "country_code" => "PH",
                "code" => "Metro Manila",
                "name" => "Metro Manila",
                "has_children" => true
            ],
            'Mindoro Occidental' => [
                "iso_code" => "PH-MDC",
                "postal_code_pattern" => "51[01]",
                "country_code" => "PH",
                "code" => "Mindoro Occidental",
                "name" => "Mindoro Occidental",
            ],
            'Mindoro Oriental' => [
                "iso_code" => "PH-MDR",
                "postal_code_pattern" => "52[01]",
                "country_code" => "PH",
                "code" => "Mindoro Oriental",
                "name" => "Mindoro Oriental",
            ],
            'Misamis Occidental' => [
                "iso_code" => "PH-MSC",
                "postal_code_pattern" => "72[01]",
                "country_code" => "PH",
                "code" => "Misamis Occidental",
                "name" => "Misamis Occidental",
            ],
            'Misamis Oriental' => [
                "iso_code" => "PH-MSR",
                "postal_code_pattern" => "90[0-2]",
                "country_code" => "PH",
                "code" => "Misamis Oriental",
                "name" => "Misamis Oriental",
            ],
            'Mountain Province' => [
                "iso_code" => "PH-MOU",
                "postal_code_pattern" => "26(1[6-9]|2[0-5])",
                "country_code" => "PH",
                "code" => "Mountain Province",
                "name" => "Mountain Province",
            ],
            'Negros Occidental' => [
                "iso_code" => "PH-NEC",
                "postal_code_pattern" => "61[0-3]",
                "country_code" => "PH",
                "code" => "Negros Occidental",
                "name" => "Negros Occidental",
            ],
            'Negros Oriental' => [
                "iso_code" => "PH-NER",
                "postal_code_pattern" => "62[0-2]",
                "country_code" => "PH",
                "code" => "Negros Oriental",
                "name" => "Negros Oriental",
            ],
            'Northern Samar' => [
                "iso_code" => "PH-NSA",
                "postal_code_pattern" => "64[0-2]",
                "country_code" => "PH",
                "code" => "Northern Samar",
                "name" => "Northern Samar",
            ],
            'Nueva Ecija' => [
                "iso_code" => "PH-NUE",
                "postal_code_pattern" => "31[0-3]",
                "country_code" => "PH",
                "code" => "Nueva Ecija",
                "name" => "Nueva Ecija",
            ],
            'Nueva Vizcaya' => [
                "iso_code" => "PH-NUV",
                "postal_code_pattern" => "37[01]",
                "country_code" => "PH",
                "code" => "Nueva Vizcaya",
                "name" => "Nueva Vizcaya",
            ],
            'Palawan' => [
                "iso_code" => "PH-PLW",
                "postal_code_pattern" => "53[0-2]",
                "country_code" => "PH",
                "code" => "Palawan",
                "name" => "Palawan",
            ],
            'Pampanga' => [
                "iso_code" => "PH-PAM",
                "postal_code_pattern" => "20[0-2]",
                "country_code" => "PH",
                "code" => "Pampanga",
                "name" => "Pampanga",
            ],
            'Pangasinan' => [
                "iso_code" => "PH-PAN",
                "postal_code_pattern" => "24[0-4]",
                "country_code" => "PH",
                "code" => "Pangasinan",
                "name" => "Pangasinan",
            ],
            'Quezon Province' => [
                "iso_code" => "PH-QUE",
                "postal_code_pattern" => "43[0-4]",
                "country_code" => "PH",
                "code" => "Quezon Province",
                "name" => "Quezon Province"
            ],
            'Quirino' => [
                "iso_code" => "PH-QUI",
                "postal_code_pattern" => "340",
                "country_code" => "PH",
                "code" => "Quirino",
                "name" => "Quirino",
            ],
            'Rizal' => [
                "iso_code" => "PH-RIZ",
                "postal_code_pattern" => "1[89]",
                "country_code" => "PH",
                "code" => "Rizal",
                "name" => "Rizal",
            ],
            'Romblon' => [
                "iso_code" => "PH-ROM",
                "postal_code_pattern" => "55[01]",
                "country_code" => "PH",
                "code" => "Romblon",
                "name" => "Romblon",
            ],
            'Samar' => [
                "iso_code" => "PH-WSA",
                "postal_code_pattern" => "67[0-2]",
                "country_code" => "PH",
                "code" => "Samar",
                "name" => "Samar",
            ],
            'Sarangani' => [
                "iso_code" => "PH-SAR",
                "postal_code_pattern" => "8015",
                "country_code" => "PH",
                "code" => "Sarangani",
                "name" => "Sarangani",
            ],
            'Siquijor' => [
                "iso_code" => "PH-SIG",
                "postal_code_pattern" => "62(2[5-9]|30)",
                "country_code" => "PH",
                "code" => "Siquijor",
                "name" => "Siquijor",
            ],
            'Sorsogon' => [
                "iso_code" => "PH-SOR",
                "postal_code_pattern" => "47[01]",
                "country_code" => "PH",
                "code" => "Sorsogon",
                "name" => "Sorsogon",
            ],
            'South Cotabato' => [
                "iso_code" => "PH-SCO",
                "postal_code_pattern" => "95[01]",
                "country_code" => "PH",
                "code" => "South Cotabato",
                "name" => "South Cotabato",
            ],
            'Southern Leyte' => [
                "iso_code" => "PH-SLE",
                "postal_code_pattern" => "66[10]",
                "country_code" => "PH",
                "code" => "Southern Leyte",
                "name" => "Southern Leyte",
            ],
            'Sultan Kudarat' => [
                "iso_code" => "PH-SUK",
                "postal_code_pattern" => "98[01]",
                "country_code" => "PH",
                "code" => "Sultan Kudarat",
                "name" => "Sultan Kudarat",
            ],
            'Sulu' => [
                "iso_code" => "PH-SLU",
                "postal_code_pattern" => "74[01]",
                "country_code" => "PH",
                "code" => "Sulu",
                "name" => "Sulu",
            ],
            'Surigao del Norte' => [
                "iso_code" => "PH-SUN",
                "postal_code_pattern" => "84[0-2]",
                "country_code" => "PH",
                "code" => "Surigao del Norte",
                "name" => "Surigao del Norte",
            ],
            'Surigao del Sur' => [
                "iso_code" => "PH-SUR",
                "postal_code_pattern" => "83[01]",
                "country_code" => "PH",
                "code" => "Surigao del Sur",
                "name" => "Surigao del Sur",
            ],
            'Tarlac' => [
                "iso_code" => "PH-TAR",
                "postal_code_pattern" => "23[01]",
                "country_code" => "PH",
                "code" => "Tarlac",
                "name" => "Tarlac",
            ],
            'Tawi-Tawi' => [
                "iso_code" => "PH-TAW",
                "postal_code_pattern" => "750",
                "country_code" => "PH",
                "code" => "Tawi-Tawi",
                "name" => "Tawi-Tawi",
            ],
            'Zambales' => [
                "iso_code" => "PH-ZMB",
                "postal_code_pattern" => "22[01]",
                "country_code" => "PH",
                "code" => "Zambales",
                "name" => "Zambales",
            ],
            'Zamboanga del Norte' => [
                "iso_code" => "PH-ZAN",
                "postal_code_pattern" => "71[0-2]",
                "country_code" => "PH",
                "code" => "Zamboanga del Norte",
                "name" => "Zamboanga del Norte",
            ],
            'Zamboanga del Sur' => [
                "iso_code" => "PH-ZAS",
                "postal_code_pattern" => "70[0-4]",
                "country_code" => "PH",
                "code" => "Zamboanga del Sur",
                "name" => "Zamboanga del Sur",
            ],
            'Zamboanga Sibuguey' => [
                "iso_code" => "PH-ZSI",
                "postal_code_pattern" => "70[0-4]",
                "country_code" => "PH",
                "code" => "Zamboanga Sibuguey",
                "name" => "Zamboanga Sibuguey",
            ],
        ];
    }

}
