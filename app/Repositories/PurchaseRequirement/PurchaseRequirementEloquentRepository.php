<?php


namespace App\Repositories\PurchaseRequirement;

use App\Enums\Person\AccountStatus;
use App\Enums\Person\AccountSourceTypes;
use App\Enums\PurchaseRequirementStatus;
use App\Events\PurchaseRequirementCreated;
use App\Models\PurchaseRequirement;
use App\Models\PurchaseRequirementsHsCode;
use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Imports\PurchaseRequirementSuffixImport;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PurchaseRequirementEloquentRepository implements PurchaseRequirementRepositoryInterface
{
    private $imageRepository;
    private $fileRepository;

    public function __construct(ImageRepositoryInterface $imageRepository,FileRepositoryInterface $fileRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->fileRepository = $fileRepository;
    }

    public function getAll($person)
    {
        return $person->purchase_requirements;
    }

    public function getById($id)
    {
        return PurchaseRequirement::find($id);
    }

    public function create($data, $person)
    {
        if($person->status === AccountStatus::Verified)
        {
            $data['status'] = PurchaseRequirementStatus::Published;
        }
        else
        {
            $data['status'] = PurchaseRequirementStatus::Unpublished;
        }

        if($person->source === AccountSourceTypes::Api){
           $data['suffix'] = $this->suffixGenerator(); 
        }

        if(auth('agent')->check()){
            $data['added_by_agent'] = auth('agent')->user()->id;
        }
        
        $data['slug'] = $this->slugGenerator($data['product']);

        $purchase_req = $person->purchase_requirements()->create($data);

        if(isset($data['hs_code'])){

          foreach($data['hs_code'] as $hs_code){

            $purchase_req->hs_codes()->create([
                'purchase_requirement_id' => $purchase_req->id,
                'hs_code_id'              => $hs_code
            ]);

          }
          
        }

        if(isset($data['images']))
        {
            foreach ($data['images'] as $file)
            {
                $image = $this->imageRepository->createData($file, 'purchase_requirement/' . $purchase_req->getRouteKey());
                $purchase_req->images()->save($image);
            }
        }

        if(isset($data['requirement_specification']))
        {
            $file = $this->fileRepository->createData($data['requirement_specification'], 'purchase_requirement/' . $purchase_req->getRouteKey());
            $purchase_req->requirement_specification_id = $file->id;
            $purchase_req->save();
        }

        $tags = isset($data['tags']) ? explode(',', $data['tags']) : [];
        $purchase_req->syncTags($tags);

        event(new PurchaseRequirementCreated($purchase_req));

        return $purchase_req;
    }

    public function update($data, $id)
    {
        $purchase_req = $this->getById($id);

        $tags = isset($data['tags']) ? explode(',', $data['tags']) : [];
        $purchase_req->syncTags($tags);

        $purchase_req->update($data);        

        if(isset($data['hs_code'])){

            foreach($purchase_req->hs_codes as $hs_code) {
                try {
                    $hs_code->delete();
                }catch (\Exception $exception){

                }
            }

            foreach ($data['hs_code'] as $hs_code) {
                $purchase_req->hs_codes()->create([
                    'purchase_requirement_id' => $purchase_req->id,
                    'hs_code_id'              => $hs_code
                ]);
            }
        }

        if($data['images_changed'] && $data['images_changed'] == 'true') {
            foreach ($purchase_req->images as $image)
            {
               $this->imageRepository->deleteData($image->id);
            }
        }

        if(isset($data['images']))
        {
            foreach ($data['images'] as $file)
            {
                $image = $this->imageRepository->createData($file, 'purchase_requirement/' . $purchase_req->getRouteKey());
                $purchase_req->images()->save($image);
            }
        }

        if(isset($data['requirement_specification_changed']) && $data['requirement_specification_changed'] == 'true')
        {
            $this->fileRepository->deleteData( $purchase_req->requirement_specification_id );
            $purchase_req->requirement_specification_id = null;
            $purchase_req->save();
        }

        if(isset($data['requirement_specification']) && $data['requirement_specification_changed'] == 'true')
        {
            $file = $this->fileRepository->createData($data['requirement_specification'], 'purchase_requirement/' . $purchase_req->getRouteKey());
            $purchase_req->requirement_specification_id = $file->id;
            $purchase_req->save();
        }

        $slug = Str::slug($data['product'], '-');

        $check_slug_exist =  PurchaseRequirement::where('slug', $slug)->first();

        if($check_slug_exist){
            $slug = Str::slug($data['product'], '-').Str::random(4);
        }

        $purchase_req->slug = $slug;
        $purchase_req->save();
        

        return $purchase_req;
    }

    public function delete($id)
    {
        $purchase_req = $this->getById($id);
        $purchase_req->timeslots()->delete();
        return $purchase_req->delete();
    }

    public function slugGenerator($name){

        $slug = Str::slug($name, '-');

        $check_slug_exist =  PurchaseRequirement::where('slug', $slug)->first();

        if($check_slug_exist){
            $slug = Str::slug($name , '-').Str::random(4);
        }

        return $slug;
    }


    public function suffixGenerator(){

        $suffix_array = array();

        $file = resource_path() . '/codes/purchase_requirement_suffix.csv';

        $import_instance  = new PurchaseRequirementSuffixImport($file);

        $csv_array = $import_instance->convertCsvToArray();

        foreach ($csv_array as $record) {
            array_push($suffix_array, $record['Terms']);
        }

        $index = array_rand($suffix_array);

        $random_suffix = $suffix_array[$index];

        return $random_suffix;
    }
}