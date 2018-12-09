<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

use App\com_zeapps_contact\Models\AddressFormat;
use App\com_zeapps_contact\Models\Country;
use App\com_zeapps_contact\Models\CountryLang;
use App\com_zeapps_contact\Models\States;
use App\com_zeapps_contact\Models\ZoneAddress;

class ComZeappsCrmStatsInit
{

    public function up()
    {
        /*Capsule::schema()->create('com_zeapps_contact_country_lang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_country', false, true)->default(0);
            $table->integer('id_lang', false, true)->default(0);
            $table->string('name', 64)->default("");

            $table->timestamps();
            $table->softDeletes();
        });*/
    }


    public function down()
    {
        //apsule::schema()->dropIfExists('com_zeapps_contact_companies');
    }
}
