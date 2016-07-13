# GeoObjectsBundle #



## Installation ##

Install AnchovyCURLBundle bundle:
composer require anchovy/curl-bundle

Add the AnchovyCURLBundle, WorldGeoObjectsBundle to your application's kernel:

    public function registerBundles()
    {
        $bundles = array(
            ...
            new Anchovy\CURLBundle\AnchovyCURLBundle(),
            new World\GeoObjectsBundle\WorldGeoObjectsBundle(),
            ...
        );

Define parameter "geo_objects.host" in configuration:
    parameters:
      geo_objects.host: <link to page for retreiving json data>


## Usage ##

	// Simple call:

	    public function indexAction() {
            $objects = $this->get('world.geo.objects')->getList();
		}

## Author ##

The bundle created by Gennady Kosaryntsev.
