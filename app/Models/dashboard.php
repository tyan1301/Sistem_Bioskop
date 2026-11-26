
<?php

class Dashboard
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getTotalMovies()
    {
        $query = "SELECT COUNT(*) FROM movies";
        return $this->db->query($query)->fetchColumn();
    }

    public function getTotalTransactions()
    {
        $query = "SELECT COUNT(*) FROM bookings";
        return $this->db->query($query)->fetchColumn();
    }

    public function getTotalTickets()
    {
        $query = "SELECT COUNT(*) FROM booking_details
                  WHERE status = 'sold'";

        return $this->db->query($query)->fetchColumn();
    }

    public function getTotalRevenue()
    {
        $query = "SELECT SUM(total_amount) FROM bookings
                  WHERE status = 'paid'";

        return $this->db->query($query)->fetchColumn() ?? 0;
    }
}
