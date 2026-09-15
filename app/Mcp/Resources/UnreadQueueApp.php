<?php

declare(strict_types=1);

namespace App\Mcp\Resources;

use Ugarit\Mcp\Request;
use Ugarit\Mcp\Response;
use Ugarit\Mcp\Server\AppResource;
use Ugarit\Mcp\Server\Attributes\AppMeta;
use Ugarit\Mcp\Server\Attributes\Description;
use Ugarit\Mcp\Server\Ui\Enums\Library;

#[Description('Unread reading queue with one-click start-reading action.')]
#[AppMeta(
    libraries: [Library::Tailwind, Library::Alpine],
    domain: 'c52a9c1773d9872c169453f3c0889932.claudemcpcontent.com',
)]
class UnreadQueueApp extends AppResource
{
    public function handle(Request $request): Response
    {
        return Response::view('mcp.unread-queue-app', [
            'title' => $this->title(),
        ]);
    }
}
