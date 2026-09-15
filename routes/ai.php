<?php

use App\Mcp\Servers\Locket;
use Ugarit\Mcp\Facades\Mcp;

Mcp::oauthRoutes();

Mcp::web('/mcp', Locket::class)
    ->name('mcp.locket')
    ->middleware('auth:api');
