<?php

// Quote.php

namespace Models;

use Db\Database;
use PDO;

class Quote
{
    /**
     * Retrieve all quotes from the database.
     *
     * @return array The list of quotes as associative arrays.
     */
    public function getAllQuotes()
    {
        $query = Database::connect()->query('SELECT * FROM Quotes');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieve a specific quote by ID from the database.
     *
     * @param int $id The ID of the quote to retrieve.
     *
     * @return array|null The quote as an associative array or null if not found.
     */
    public function getSingleQuote($id)
    {
        $query = Database::connect()->prepare('SELECT * FROM Quotes WHERE id = :id');
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
	
	/**
     * Retrieve a random quote from the database.
     *
     * @return array|null The quote as an associative array or null if not found.
     */
    public function getRandomQuote()
    {
        // Get the total number of quotes in the database
        $totalQuotesQuery = Database::connect()->query('SELECT COUNT(*) FROM Quotes');
        $totalQuotes = $totalQuotesQuery->fetchColumn();

        // Generate a random ID within the range of available IDs
        $randomId = rand(1, $totalQuotes);

        // Fetch the quote with the randomly generated ID
        $query = Database::connect()->prepare('SELECT * FROM Quotes WHERE id = :id');
        $query->execute(['id' => $randomId]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
