<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QueueManagerController extends Controller
{
    protected $queueScript = "C:\\xampp\htdocs\Concurrency\queue_worker.bat";

    // Start the Queue Worker
    public function startQueue()
    {
        // Run the queue in a hidden background process
        $command = 'start /B cmd /C "' . $this->queueScript . '"';
        shell_exec($command);

        return response()->json(['message' => 'Queue started successfully!']);
    }

    // Stop the Queue Worker
    public function stopQueue()
    {
        // Kill all running queue workers
        shell_exec('taskkill /F /IM php.exe');

        return response()->json(['message' => 'Queue stopped successfully!']);
    }
}

