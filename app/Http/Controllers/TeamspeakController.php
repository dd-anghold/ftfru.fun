<?php

namespace App\Http\Controllers;

use TeamSpeak3;
use Illuminate\Http\Request;

class TeamspeakController extends Controller
{

    
    private $ts3;

    public function __construct()
    {
        $uri = "serverquery://serveradmin:BfthpY6J@127.0.0.1:10011/?server_port=9987";
        $this->ts3 = TeamSpeak3::factory($uri);
    }

    public function getChannelsAndUsers()
    {
        try {
            $ts3_VirtualServer = $this->ts3;

            // Получаем все каналы на сервере
            $channels = $ts3_VirtualServer->channelList();
            // Получаем всех онлайн-пользователей
            $clients = $ts3_VirtualServer->clientList(["client_type" => 0]);

            // Структурируем пользователей по каналам
            $channelData = [];
            foreach ($channels as $channel) {
                $channelData[$channel['cid']] = [
                    'channel_name' => $channel['channel_name'],
                    'parent_id' => $channel['pid'],
                    'clients' => [],
                    'subchannels' => [],
                ];
            }

            // Распределяем пользователей по соответствующим каналам
            foreach ($clients as $client) {
                $channelId = $client['cid'];
                $channelData[$channelId]['clients'][] = [
                    'nickname' => $client['client_nickname'],
                    'status' => $client['client_away'] ? 'away' : 'online',
                ];
            }

            // Формируем иерархию каналов с подканалами
            $channelsHierarchy = [];
            foreach ($channelData as $cid => $channel) {
                if ($channel['parent_id'] == 0) {
                    $channelsHierarchy[$cid] = &$channelData[$cid];
                } else {
                    $channelData[$channel['parent_id']]['subchannels'][] = &$channelData[$cid];
                }
            }

            return response()->json(array_values($channelsHierarchy));

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getChannels()
    {
        $channels = $this->ts3->channelList();
        return response()->json($channels);
    }

    public function getClients()
    {
        $clients = $this->ts3->clientList();
        return response()->json($clients);
    }
}