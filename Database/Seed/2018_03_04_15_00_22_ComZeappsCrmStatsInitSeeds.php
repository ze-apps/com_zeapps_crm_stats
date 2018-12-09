<?php

use Illuminate\Database\Capsule\Manager as Capsule;


class ComZeappsCrmStatsInitSeeds
{
    public function run()
    {
        Capsule::table('zeapps_modules')->insert([
            'module_id' => "com_zeapps_crm_stats",
            'label' => "com_zeapps_crm_stats",
            'active' => "1",
            'version' => "1.0.0",
            'last_sql' => "0",
            'dependencies' => "",
            'missing_dependencies' => "",
            'created_at'=>'2018-01-01',
            'updated_at'=>'2018-01-01',
        ]);
    }
}
