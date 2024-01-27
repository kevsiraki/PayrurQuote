<?php

// QuoteController.php

namespace Controllers;

use Routing\Router;
use Models\Quote;

class QuoteController
{
    /** @var Router */
    private $router;

    /** @var Quote */
    private $quoteModel;

    /**
     * QuoteController constructor.
     *
     * @param Router $router
     * @param Quote $quoteModel
     */
    public function __construct(Router $router, Quote $quoteModel)
    {
        $this->router = $router;
        $this->quoteModel = $quoteModel;
    }

    /**
     * Handle incoming requests based on the specified method and parameters.
     *
     * @param string $method
     * @param mixed $params
     */
    public function handleRequest($method, $params)
    {
        // Find the appropriate handler for the given method and parameters
        $handler = $this->router->findHandler($method, $params);

        // If a valid handler is found, execute it; otherwise, provide a default response
        if ($handler !== null) {
            $this->$handler($params);
        } else {
            $this->defaultResponse();
        }
    }

    /**
     * Retrieve all quotes and respond with a JSON-encoded representation.
     */
    public function getAllQuotes()
    {
        $items = $this->quoteModel->getAllQuotes();
        echo json_encode($items, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Retrieve a specific quote by ID and respond with a JSON-encoded representation.
     *
     * @param mixed $params
     */
    public function getSingleQuote($params)
    {
        // Extract the ID from the URL parameters
        $parts = explode('/', $params);
        $id = end($parts);
        $id = is_numeric($id) ? (int) $id : null;

        // If a valid ID is found, retrieve the item and respond with JSON; otherwise, provide a default response
        if ($id !== null) {
            $item = $this->quoteModel->getSingleQuote($id);
            echo json_encode($item, JSON_UNESCAPED_UNICODE);
        } else {
            $this->defaultResponse();
        }
    }

    public function getRandomQuote()
    {
        echo json_encode($this->quoteModel->getRandomQuote(), JSON_UNESCAPED_UNICODE);
    }

    public function defaultResponse()
    {
        echo json_encode(['message' => 'Invalid endpoint']);
    }
}
