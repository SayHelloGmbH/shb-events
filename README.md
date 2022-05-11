# Events

## Description

Plugin for the management of events. The output of the events should be managed by the theme: the plugin contains no views.

## Usage

Install and activate the plugin. The custom post type “Events” will become available. The Theme must handle the output of the event list and single views.

### Filters

The plugin provides the following filters for use by developers.

    apply_filters('shp-events_post_type_labels', array $labels);
    apply_filters('shp-events_post_type_capabilities', array $capabilities);
    apply_filters('shp-events_post_type_args', array $capabilities);

## Changelog

### 1.0.0

-   Initial working release version.

### 0.0.1

-   Initial development version.

## Contributors

-   Mark Howells-Mead (mark@sayhello.ch)

## License

Use this code freely, widely and for free. Provision of this code provides and implies no guarantee.

Please respect the GPL v3 licence, which is available via http://www.gnu.org/licenses/gpl-3.0.html
