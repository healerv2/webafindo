<?php

namespace App\Services;

use App\Models\Mikrotik;
use App\Models\LoginLog;
use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;
use Exception;
use Illuminate\Support\Facades\Log;

class MikrotikMonitorService
{
    /**
     * Connect to Mikrotik device
     *
     * @param string $ip
     * @param string $username
     * @param string $password
     * @param int $port
     * @return Client|null
     */
    public function connect(string $ip, string $username, string $password, int $port = 8728)
    {
        try {
            $config = new Config([
                'host' => $ip,
                'user' => $username,
                'pass' => $password,
                'port' => $port,
            ]);

            return new Client($config);
        } catch (Exception $e) {
            Log::error('Mikrotik connection error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Check if device is online
     *
     * @param Device $device
     * @return bool
     */
    public function isOnline(Mikrotik $device): bool
    {
        try {
            $client = $this->connect($device->ip, $device->username, $device->password, $device->port);
            return $client !== null;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get system resources
     *
     * @param Device $device
     * @return array|null
     */
    public function getSystemResources(Mikrotik $device): ?array
    {
        try {
            $client = $this->connect($device->ip, $device->username, $device->password, $device->port);

            if (!$client) {
                return null;
            }

            $query = new Query('/system/resource/print');
            $resources = $client->query($query)->read();

            return $resources[0] ?? null;
        } catch (Exception $e) {
            Log::error('Failed to get system resources: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get active users
     *
     * @param Device $device
     * @return array
     */
    public function getActiveUsers(Mikrotik $device): array
    {
        try {
            $client = $this->connect($device->ip, $device->username, $device->password, $device->port);

            if (!$client) {
                return [];
            }

            $query = new Query('/user/active/print');
            return $client->query($query)->read();
        } catch (Exception $e) {
            Log::error('Failed to get active users: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get login history from device
     *
     * @param Device $device
     * @return array
     */
    public function getLoginHistory(Mikrotik $device): array
    {
        try {
            $client = $this->connect($device->ip, $device->username, $device->password, $device->port);

            if (!$client) {
                return [];
            }

            $query = new Query('/log/print');
            $query->where('message', 'logged in');

            return $client->query($query)->read();
        } catch (Exception $e) {
            Log::error('Failed to get login history: ' . $e->getMessage());
            return [];
        }
    }
}
