<?php

declare(strict_types=1);

namespace App\Mcp\Resources;

use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\AppResource;
use Ugarit\Mcp\Server\Attributes\AppMeta;
use Ugarit\Mcp\Server\Attributes\Description;
use Ugarit\Mcp\Server\Ui\Enums\Library;

#[Description('Visual feed of trending links on Locket with one-click bookmark and summarise actions.')]
#[AppMeta(
    libraries: [Library::Tailwind, Library::Alpine],
    domain: 'c52a9c1773d9872c169453f3c0889932.claudemcpcontent.com',
)]
class TrendingLinksApp extends AppResource
{
    public function handle(Request $request): Response
    {
        return Response::view('mcp.trending-links-app', [
            'title' => $this->title(),
        ]);
    }
}
