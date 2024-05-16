<?php

namespace App\Imports;

use App\Models\HsCode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class HsCodeImport implements ToModel, WithStartRow, WithCustomCsvSettings{

    use Importable;

    
    public function startRow(): int{
        return 2;
    }

    public function searchSection($peram){

        $sections = [
            array(
                'section' => 'I',
                'name'    => 'live animals; animal products'
            ),
            array(
              'section' => 'II',
              'name'    => 'Vegetable products'
            ),
            array(
                'section' => 'III',
                'name'    => 'Animal or vegetable fats and oils and their cleavage products; prepared edible fats; animal or vegetable waxes'
            ),
            array(
                'section' => 'IV',
                'name'    => 'Prepared foodstuffs; beverages, spirits and vinegar; tobacco and manufactured tobacco substitutes'
            ),
            array(
                'section' => 'V',
                'name'    => 'Mineral products'
            ),
            array(
                'section' => 'VI',
                'name'    => 'Products of the chemical or allied industries'
            ),
            array(
                'section' => 'VII',
                'name'    => 'Plastics and articles thereof; rubber and articles thereof'
            ),
            array(
                'section' => 'VIII',
                'name'    => 'Raw hides and skins, leather, furskins and articles thereof; saddlery and harness; travel goods, handbags and similar containers; articles of animal gut (other than silk-worm gut)'
            ),
            array(
                'section' => 'IX',
                'name'    => 'Wood and articles of wood; wood charcoal; cork and articles of cork; manufactures of straw, of esparto or of other plaiting materials; basketware and wickerwork'
            ),
            array(
                'section' => 'X',
                'name'    => 'Pulp of wood or of other fibrous cellulosic material; recovered (waste and scrap) paper or paperboard; paper and paperboard and articles thereof'
            ),
            array(
                'section' => 'XI',
                'name'    => 'Textiles and textile articles'
            ),
            array(
                'section' => 'XII',
                'name'    => 'Footwear, headgear, umbrellas, sun umbrellas, walking-sticks, seat-sticks, whips, riding-crops and parts thereof; prepared feathers and articles made therewith; artificial flowers; articles of human hair'
            ),
            array(
                'section' => 'XIII',
                'name'    => 'Articles of stone, plaster, cement, asbestos, mica or similar materials; ceramic products; glass and glassware'
            ),
            array(
                'section' => 'XIV',
                'name'    => 'Natural or cultured pearls, precious or semi-precious stones, precious metals, metals clad with precious metal and articles thereof; imitation jewellery; coin'
            ),
            array(
                'section' => 'XV',
                'name'    => 'Base metals and articles of base metal'
            ),
            array(
                'section' => 'XVI',
                'name'    => 'Machinery and mechanical appliances; electrical equipment; parts thereof; sound recorders and reproducers, television image and sound recorders and reproducers, and parts and accessories of such articles'
            ),
            array(
                'section' => 'XVII',
                'name'    => 'Vehicles, aircraft, vessels and associated transport equipment'
            ),  
            array(
                'section' => 'XVIII',
                'name'    => 'Optical, photographic, cinematographic, measuring, checking, precision, medical or surgical instruments and apparatus; clocks and watches; musical instruments; parts and accessories thereof'
            ),
            array(
                'section' => 'XIX',
                'name'    => 'Arms and ammunition; parts and accessories thereof'
            ),  
            array(
                'section' => 'XX',
                'name'    => 'Miscellaneous manufactured articles'
            ),      
            array(
                'section' => 'XXI',
                'name'    => 'Works of art, collectors pieces and antiques'
            ),         
        ];

        $found_peram = "";

        foreach($sections as $sec){
            if($sec['section'] == $peram){
              $found_peram = $sec['name'];
            }
        }

        return $found_peram;
    }

    public function model(array $row){

        $hs_code = HsCode::create([
           'code'     => $row[1],
           'name'     => $row[2],
           'section'  => $this->searchSection($row[0])
        ]);
        
        return $hs_code;
    }

    public function getCsvSettings(): array{
        return [
            'input_encoding' => 'ISO-8859-1'
        ];
    }
}