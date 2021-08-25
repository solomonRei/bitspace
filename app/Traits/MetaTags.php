<?php
namespace App\Traits;

use Butschster\Head\Facades\Meta;

trait MetaTags {

    public function setMeta($title, $description = '')
    {
        Meta::setTitle($title)
            ->setDescription($description);
    }
}
