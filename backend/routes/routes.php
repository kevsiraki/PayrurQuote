<?php

// routes.php

namespace Routing;

return [
    'GET' => [
        'quotes' => 'getAllQuotes',
        'quote/(\d+)' => 'getSingleQuote',
        'quote/random' => 'getRandomQuote'
    ]
];
