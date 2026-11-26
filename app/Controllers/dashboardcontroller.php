
<?php

require_once __DIR__ . '/../Models/Dashboard.php';

class DashboardController
{
    private $dashboard;

    public function __construct($db)
    {
        $this->dashboard = new Dashboard($db);
    }

    public function index()
    {
        $totalMovies = $this->dashboard->getTotalMovies();

        $totalTransactions = $this->dashboard->getTotalTransactions();

        $totalTickets = $this->dashboard->getTotalTickets();

        $totalRevenue = $this->dashboard->getTotalRevenue();

        require __DIR__ . '/../../resources/views/admin/dashboard.php';
    }
}
