<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    public function run(): void
    {
        $departamentos = [
            [
                'ID_DEPARTAMENTO' => '1',
                'NOMBRE_DEPARTAMENTO' => 'Atlántico',
                'DESCRIPCION' => 'Hermosas playas llaman la atención de los viajeros, que encuentran en este departamento un destino propicio para el descanso mientras disfrutan del clima cálido y la refrescante brisa del mar. Sus municipios han sido cuna de importantes personajes en el mundo del arte, la cultura y el deporte y han resguardado, además, las tradiciones de las comunidades que se asentaron en sus terrenos en tiempos antiguos. Los bellos paisajes del Atlántico, que se alimentan del paso del agua dulce y del agua de mar que toca las costas, resultan un espectáculo admirable y reflejan su inmensa riqueza natural.',
            ],
            [
                'ID_DEPARTAMENTO' => '2',
                'NOMBRE_DEPARTAMENTO' => 'Valle del Cauca',
                'DESCRIPCION' => 'Este encantador departamento está ubicado entre las regiones Andina y Pacífica, se caracteriza por su diversidad de ecosistemas, incluyendo selvas tropicales, zonas montañosas, valles fértiles y playas, así como numerosos parques nacionales, reservas naturales y áreas de conservación, que atraen cada año a amantes de la naturaleza y el ecoturismo. Por otra parte, el Valle del Cauca es reconocido por su producción de caña de azúcar, su majestuosa industria azucarera, su delicioso café, su cultivo de plátanos y su industria de las flores. Sin duda, es un territorio que posee una variedad de razones únicas para ser explorado.',
            ],
            [
                'ID_DEPARTAMENTO' => '3',
                'NOMBRE_DEPARTAMENTO' => 'Bolívar',
                'DESCRIPCION' => 'Situado en la región norte de Colombia, este departamento se destaca como un destino lleno de encanto y diversidad. Allí se entrelazan la historia, la cultura y la belleza natural de una manera única. Desde las calles empedradas de Cartagena hasta las zonas de montaña y playas de arena blanca, ofrece una experiencia fascinante a los viajeros. Con su arquitectura de ensueño y murallas históricas, Cartagena transporta al viajero al pasado colonial, mientras que áreas naturales como el Parque Nacional Natural Corales del Rosario y San Bernardo lo invitan a explorar paisajes de ensueño. Además, Bolívar es un crisol de culturas y tradiciones que enriquecen su gastronomía y festividades. No se pierda la oportunidad de explorar su riqueza, desde sus tesoros históricos hasta sus joyas naturales, sin olvidar la maravillosa calidez de su gente.',
            ],
        ];

        DB::table('tabla_departamentos')->insert($departamentos);
    }
}
