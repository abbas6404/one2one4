<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Facades\Seo;

class SeoMeta extends Component
{
    /**
     * SEO title
     *
     * @var string
     */
    public $title;

    /**
     * SEO description
     *
     * @var string
     */
    public $description;

    /**
     * SEO keywords
     *
     * @var string
     */
    public $keywords;

    /**
     * SEO image
     *
     * @var string
     */
    public $image;

    /**
     * SEO type
     *
     * @var string
     */
    public $type;

    /**
     * Create a new component instance.
     *
     * @param string|null $title
     * @param string|null $description
     * @param string|null $keywords
     * @param string|null $image
     * @param string|null $type
     * @return void
     */
    public function __construct(
        ?string $title = null,
        ?string $description = null,
        ?string $keywords = null,
        ?string $image = null,
        ?string $type = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->image = $image;
        $this->type = $type;

        // Set SEO data if provided
        if ($title || $description || $keywords || $image || $type) {
            $data = [];
            
            if ($title) {
                $data['title'] = $title;
            }
            
            if ($description) {
                $data['description'] = $description;
            }
            
            if ($keywords) {
                $data['keywords'] = $keywords;
            }
            
            if ($image) {
                $data['image'] = $image;
            }
            
            if ($type) {
                $data['type'] = $type;
            }
            
            Seo::setData($data);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
        <!-- SEO meta tags set via component -->
        blade;
    }
} 