<?php namespace Gigafeed\Locations;

use Backend;
use OFFLINE\OpeningHours\Controllers\Locations;
use OFFLINE\OpeningHours\Models\Location;
use OFFLINE\OpeningHours\Models\Location as LocationModel;
use System\Classes\PluginBase;

/**
 * Locations Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = [
        'Offline.OpeningHours'
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Locations',
            'description' => '',
            'author' => 'Gigafeed',
            'icon' => 'icon-map-pin'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        Locations::extendFormFields(function ($form, $model, $context) {
            if (!($model instanceof LocationModel)) {
                return;
            }

            $form->addTabFields([
                'physical_location[addr1]' => [
                    'label' => 'Address Line 1',
                    'tab' => 'Physical Location',
                    'span' => 'left',
                    'type' => 'text'
                ],
                'physical_location[addr2]' => [
                    'label' => 'Address Line 2',
                    'tab' => 'Physical Location',
                    'span' => 'right',
                    'type' => 'text'
                ],
                'physical_location[city]' => [
                    'label' => 'City',
                    'tab' => 'Physical Location',
                    'type' => 'text'
                ],
                'physical_location[state]' => [
                    'label' => 'City',
                    'tab' => 'Physical Location',
                    'type' => 'dropdown',
                    'options' => [
                        'AL' => 'Alabama',
                        'AK' => 'Alaska',
                        'AZ' => 'Arizona',
                        'AR' => 'Arkansas',
                        'CA' => 'California',
                        'CO' => 'Colorado',
                        'CT' => 'Connecticut',
                        'DE' => 'Delaware',
                        'DC' => 'District Of Columbia',
                        'FL' => 'Florida',
                        'GA' => 'Georgia',
                        'HI' => 'Hawaii',
                        'ID' => 'Idaho',
                        'IL' => 'Illinois',
                        'IN' => 'Indiana',
                        'IA' => 'Iowa',
                        'KS' => 'Kansas',
                        'KY' => 'Kentucky',
                        'LA' => 'Louisiana',
                        'ME' => 'Maine',
                        'MD' => 'Maryland',
                        'MA' => 'Massachusetts',
                        'MI' => 'Michigan',
                        'MN' => 'Minnesota',
                        'MS' => 'Mississippi',
                        'MO' => 'Missouri',
                        'MT' => 'Montana',
                        'NE' => 'Nebraska',
                        'NV' => 'Nevada',
                        'NH' => 'New Hampshire',
                        'NJ' => 'New Jersey',
                        'NM' => 'New Mexico',
                        'NY' => 'New York',
                        'NC' => 'North Carolina',
                        'ND' => 'North Dakota',
                        'OH' => 'Ohio',
                        'OK' => 'Oklahoma',
                        'OR' => 'Oregon',
                        'PA' => 'Pennsylvania',
                        'RI' => 'Rhode Island',
                        'SC' => 'South Carolina',
                        'SD' => 'South Dakota',
                        'TN' => 'Tennessee',
                        'TX' => 'Texas',
                        'UT' => 'Utah',
                        'VT' => 'Vermont',
                        'VA' => 'Virginia',
                        'WA' => 'Washington',
                        'WV' => 'West Virginia',
                        'WI' => 'Wisconsin',
                        'WY' => 'Wyoming',
                    ]
                ],
                'physical_location[zipcode]' => [
                    'label' => 'City',
                    'tab' => 'Physical Location',
                    'type' => 'number'
                ],
            ]);
        });

        // Extend all backend form usage
        \Event::listen('backend.form.extendFields', function ($widget) {

            // Only for the User controller
            if (!$widget->getController() instanceof Locations) {
                return;
            }

            // Only for the User model
            if (!$widget->model instanceof Location) {
                return;
            }

            $widget->addFields([

                //'addr1' => [
                //    'label' => 'Address Line 1',
                //    'type' => 'datepicker'
                //]

            ]);
            //$widget->removeField('surname');
        });

        \Event::listen('backend.menu.extendItems', function ($manager) {
            $manager->removeMainMenuItem('Offline.OpeningHours', 'opening-hours-main');
        });

        \Event::listen('backend.page.beforeDisplay', function ($controller, $action, $parameters) {
            if (!($controller instanceof Locations)) {
                return;
            }

            if ($action === 'create') {
                \BackendMenu::setContext('Gigafeed.Locations', 'locations', 'add_location');
            } else {
                \BackendMenu::setContext('Gigafeed.Locations', 'locations', 'locations');
            }
        });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Gigafeed\Locations\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'gigafeed.locations.some_permission' => [
                'tab' => 'Locations',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'locations' => [
                'label' => 'Locations',
                'url' => Backend::url('gigafeed/locations/locations'),
                'icon' => 'icon-map',
                'permissions' => ['gigafeed.locations.*'],
                'order' => 500,
                'sideMenu' => [
                    'add_location' => [
                        'label' => 'Add Locations',
                        'icon' => 'icon-plus',
                        'url' => Backend::url('offline/openinghours/locations/create'),
                    ],
                    'locations' => [
                        'label' => 'Locations',
                        'icon' => 'icon-map',
                        'url' => Backend::url('gigafeed/locations/locations'),
                    ],

                ]
            ],
        ];
    }
}
