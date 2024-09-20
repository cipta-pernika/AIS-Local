<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DiagnosticController extends Controller
{
    public function runDiagnostics()
    {
        $issues = [];
        $status = [];

        // 1. Ping to 192.168.10.2
        $pingResult = $this->ping('192.168.10.2');
        if ($pingResult) {
            $status[] = "Ping to 192.168.10.2 is successful";
        } else {
            $issues[] = "Cannot ping 192.168.10.2";
        }

        // 2. TCP Ping to 192.168.144.1:8080
        $tcpResult = $this->tcpPing('192.168.144.1', 8080);
        if ($tcpResult) {
            $status[] = "TCP Ping to 192.168.144.1:8080 is successful";
        } else {
            $issues[] = "Cannot connect to 192.168.144.1:8080";
        }

        // 3. Other Diagnostic Checks (These are just dummy checks)
        if ($this->checkInternetConnection()) {
            $status[] = "Connected to Internet";
        }
        // More checks can be added here...

        // Format the response
        return response()->json([
            'issues' => $issues,
            'status' => $status,
        ]);
    }

    private function ping($ip)
    {
        $process = new Process(['ping', '-c', '1', $ip]);
        $process->run();

        return $process->isSuccessful();
    }

    private function tcpPing($host, $port)
    {
        $connection = @fsockopen($host, $port, $errno, $errstr, 5);
        if ($connection) {
            fclose($connection);
            return true;
        }
        return false;
    }

    private function checkInternetConnection()
    {
        // Check if we can ping Google DNS
        return $this->ping('8.8.8.8');
    }
}
