<?php

namespace DSFacyt\InfrastructureBundle\Resources\Services;

use Symfony\Component\Yaml\Yaml;

/**
 *	Los datos de las configuraciones del sistema
 *
 *	@author Freddy Contreras <freddycontreras3@gmail.com>
 *	@author Currently Working: Freddy Contreras <freddycontreras3@gmail.com>
 *	@version 12/08/2015
 */
class ConfigurationDSFacyt
{
    public function getConfig()
    {
        return Yaml::parse(file_get_contents('../app/config/config_dsf_facyt.yml'))['config'];
    }

    public function updateConfig($config)
    {
    	$curretConfig = Yaml::parse(file_get_contents('../app/config/config_dsf_facyt.yml'));
    	$curretConfig['config'] = $config;
    	$yaml = Yaml::dump($curretConfig);
		file_put_contents('../app/config/config_dsf_facyt.yml', $yaml);
    }
}