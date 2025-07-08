<?php

namespace Controller;

use Service\InsertService;

class VehicleController
{
    public function handle(string $plate): void
    {
        $url = 'http://localhost:9090/getVehicleByPlateNumber?plate=' . urlencode($plate);

        $options = [
            'http' => [
                'header' => "X-Api-Key: 2AA52DDEA0EC\r\n",
                'method' => 'GET',
            ],
        ];
        $context = stream_context_create($options);

        $json = @file_get_contents($url, false, $context);

        if ($json === false) {
            http_response_code(500);
            echo 'Hiba a mock API elérésekor.';
            return;
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            http_response_code(500);
            echo 'Érvénytelen JSON válasz a mock API-tól.';
            return;
        }

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
