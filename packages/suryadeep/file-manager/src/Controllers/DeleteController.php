<?php

namespace Mafftor\LaravelFileManager\Controllers;

use Mafftor\LaravelFileManager\Events\ImageIsDeleting;
use Mafftor\LaravelFileManager\Events\ImageWasDeleted;

class DeleteController extends LfmController
{
    /**
     * Delete image and associated thumbnail.
     *
     * @return mixed
     */
    public function getDelete()
    {
        $item_names = request('items');
        // dd($item_names);

        foreach ($item_names as $name_to_delete) {
            $file_to_delete = $this->lfm->pretty($name_to_delete);
          
            $file_path = $file_to_delete->path();
            // dd($file_path);

            event(new ImageIsDeleting($file_path));

            if (is_null($name_to_delete)) {
                return parent::error('folder-name');
            }

            if (! $this->lfm->setName($name_to_delete)->exists()) {
                return parent::error('folder-not-found', ['folder' => $file_path], 404);
            }

            if ($this->lfm->setName($name_to_delete)->isDirectory()) {
                if (! $this->lfm->setName($name_to_delete)->directoryIsEmpty()) {
                    return parent::error('delete-folder');
                }
            } else {
                // dd($name_to_delete);
                // dd($this->lfm->setName($name_to_delete));
                // dd($this->lfm->setName($name_to_delete)->thumb());
                
                
                if ($file_to_delete->isImage()) {
                    
                    $images = $this->lfm->getImages($name_to_delete);
                    if(count($images)){
                        foreach($images as $image_to_delete){
                            $this->lfm->setName($image_to_delete)->thumb()->delete();
                        }
                    }
                    $this->lfm->setName($name_to_delete)->thumb()->delete();
                }
            }

            $this->lfm->setName($name_to_delete)->delete();

            event(new ImageWasDeleted($file_path));
        }

        return parent::$success_response;
    }
}
