<?php

namespace Controller;

class VehicleController extends BaseController
{
    public function handle(string $plate): void
    {
        $url = 'http://localhost:9090/getVehicleByPlateNumber?plate=' . urlencode($plate);
        $this->fetchAndInsert($url, 'vehicles');
    }
}
