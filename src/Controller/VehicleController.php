<?php

namespace Controller;

use Service\InsertService;

class VehicleController
{
    public function handle(string $plate): void
    {
        $url = 'http://localhost:9090/getVehicleByPlateNumber?plate=' . urlencode($plate);
        $json = file_get_contents($url);

        if ($json === false) {
            http_response_code(500);
            echo 'Hiba a mock API elérésekor.';
            return;
        }

        $data = json_decode($json, true);

        if (isset($data['errorCode']) || isset($data['errorMsg'])) {
            http_response_code(400);
            $msg = $data['errorMsg'] ?? 'Ismeretlen API hiba';
            echo 'API hiba: ' . htmlspecialchars($msg);
            return;
        }

        $service = new InsertService();
        $sqls = $service->build('vehicles', [$data]);

        foreach ($sqls as $sql) {
            echo '<pre>' . $sql . '</pre>';
        }
    }
}
