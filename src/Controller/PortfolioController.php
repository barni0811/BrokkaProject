<?php

namespace Controller;

class PortfolioController extends BaseController
{
    public function handle(): void
    {
        $url = 'http://localhost:9090/getPortfolio';
        $this->fetchAndInsert($url, 'contracts', false);
    }
}
