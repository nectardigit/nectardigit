<?php

namespace App\Http\Livewire\Admin;

use App\Models\Tag;
use App\Traits\BaseTrait;
use Livewire\Component;
use Str;
use Auth;
class Taglist extends Component
{
    use BaseTrait;
    public $plus = 1;
    public $add_tag = false;
    public $np_title = null;
    public $en_title = null;
    public $errors = null;
    public $publish_status = '1';
    public $tags = [];
    public $newsdata;
   
    public function addTag()
    {
        // $this->add_tag = true;
        $this->tags =  $this->getTags();
    }
    public function mount($newsdata){
        $this->get_web();
        $this->newsdata = $newsdata;
    }
    protected function rules()
    {
        $_website =  session()->get('_website');
        if ($_website == 'Nepali') {
            return [
                'np_title' => "required|string|max:100",

                'publish_status' => "required|numeric|in:1,0",
            ];
        } else if ($_website == 'English') {
            return [
                'en_title' => "required|string|max:100",

                "publish_status" => "required|numeric|in;1,0",
            ];
        } else if ($_website == 'Both') {
            return [
                'np_title' => "required|string|max:100",
                "en_title" => "required|string|max:100",

                "publish_status" => "required|numeric|in:1,0",
            ];
        }
    }
    public function storeTag()
    {

        $this->validate($this->rules());
        $data = [
            'title' => [
                'en' => $this->en_title ?? $this->np_title,
                'np' => $this->np_title ?? $this->en_title,
            ],
            // 'description' => [
            //     'en' => htmlentities(@$this->en_description) ?? htmlentities(@$this->np_description),
            //     'np' => htmlentities(@$this->np_description) ?? htmlentities(@$this->en_description),
            // ],
            "slug" => $this->getSlug($this->np_title ?? $this->en_title),
            "publish_status" => $this->publish_status,
            'created_by' => Auth::user()->id,
        ];
        
        // dd($data);
        try {
            Tag::create($data);
            session()->flash('success', 'Tag created successfully.');
            // return redirect()->route('tag.index');
         
            $this->emit('storeTag');
            $this->tags  = $this->getTags();
            // dd( $this->tags);
        } catch (\Exception $error) {
            session()->flash('error', $error->getMessage());
            // return redirect()->back();
        }
    }
    protected function getSlug($title)
    {
        $slug = Str::slug($title);
        $find = Tag::where('slug', $slug)->first();
        // dd($find);
        if ($find) {
            $slug = $slug . '-' . rand(1111, 9999);
        }
        // dd($slug);
        return $slug;
    }
    protected function getTags(){
    //    return Tag::select('id', 'title->np as np_title', 'title->en as en_title')
    //     // ->get();
    //         ->pluck(app()->getLocale() . '_title', 'id');

    //         $tags =  Tag::select('id', 'title')
    //         ->get();
    $tags =  Tag::select('id', 'title')
        ->get();
            $tag_items = [];
            foreach ($tags as $tag) {
                $tag_items[$tag->id] = $tag->title[$this->locale];
            }
            return $tag_items;
    }
    public function render()
    {
        // dd($this->newsdata);
        $this->tags =  $this->getTags();
        $this->selected_tags = $this->newsdata  ? $this->newsdata->tags : null;
       $selected_tags  = $this->selected_tags ;
        return view('livewire.admin.taglist' , compact('selected_tags'));
    }
}
