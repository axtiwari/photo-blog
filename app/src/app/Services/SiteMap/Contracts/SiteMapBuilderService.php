<?php

namespace App\Services\SiteMap\Contracts;

use Lib\SiteMap\Contracts\Builder;

/**
 * Interface SiteMapBuilderService.
 *
 * @package App\Services\SiteMap\Contracts
 */
interface SiteMapBuilderService
{
    /**
     * Build the sitemap.
     *
     * @return Builder
     */
    public function build(): Builder;
}
