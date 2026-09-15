<?php

declare(strict_types=1);

namespace App\Mcp\Resources;

use App\Actions\GetUserLastAddedLink;
use Ugarit\Mcp\Request;
use Ugarit\Mcp\Server\Resource;

class LastAddedLink extends Resource
{
    protected string $description = 'The user\'s most recently added link with any attached notes.';

    public function handle(Request $request, GetUserLastAddedLink $getUserLastAddedLink): string
    {
        $user = $request->user();
        if (! $user instanceof \App\Models\User) {
            return "❌ **Authentication Required**\n\nYou must be authenticated to view your last added link.";
        }

        $result = $getUserLastAddedLink->handle($user);

        if (! $result) {
            return "⚠️ **No Links Found**\n\nYou haven't added any links to your Locket yet. Try adding your first link!";
        }

        $output = "📖 **Your Last Added Link**\n\n";
        $output .= "**{$result['link']['title']}**\n";
        $output .= "URL: {$result['link']['url']}\n";
        $output .= 'Category: '.ucfirst($result['user_link']['category'])."\n";
        $output .= 'Status: '.ucfirst($result['user_link']['status'])."\n";
        $output .= "Added: {$result['user_link']['created_at']}\n";

        if (! empty($result['link']['description'])) {
            $output .= "Description: {$result['link']['description']}\n";
        }

        if (! empty($result['notes'])) {
            $output .= "\n**📝 Your Notes:**\n";
            foreach ($result['notes'] as $note) {
                $output .= "• {$note['note']} (added {$note['created_at']})\n";
            }
        } else {
            $output .= "\n*No notes attached to this link.*";
        }

        return $output;
    }
}
