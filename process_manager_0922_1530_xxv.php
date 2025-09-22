<?php
// 代码生成时间: 2025-09-22 15:30:54
// Process Manager using PHP and CakePHP framework
// Filename: process_manager.php

// Load CakePHP's autoloader
require_once 'vendor/autoload.php';

use Cake\Core\Configure;
use Cake\Utility\Inflector;

// Define configuration for the Process Manager
Configure::write('ProcessManager', [
    'maxProcesses' => 5, // Maximum number of processes that can run concurrently
    'timeout' => 60, // Timeout for each process in seconds
]);

class ProcessManager {
    // This function starts a new process
    public function startProcess($command) {
        $output = [];
        $return_var = 0;
        // Start the process using exec and pass the command
        $process = proc_open($command, [], $pipes);
        if (!is_resource($process)) {
            throw new Exception('Failed to start the process.');
        }

        // Set a timeout for the process
        $timeout = Configure::read('ProcessManager.timeout');
        $start = time();
        while (true) {
            if (time() - $start > $timeout) {
                throw new Exception('Process timed out.');
            }

            // Check if the process is still running
            $status = proc_get_status($process);
            if ($status['running'] === false) {
                break;
            }

            // Sleep for a short period to avoid busy waiting
            usleep(100000);
        }

        // Close the process and get the exit code
        $return_var = proc_close($process);

        // Check if the process finished successfully
        if ($return_var !== 0) {
            throw new Exception('Process failed with exit code ' . $return_var);
        }

        // Return the output from the process
        return implode("\
", $output);
    }

    // This function lists all running processes
    public function listProcesses() {
        $output = [];
        exec('ps aux', $output);
        return $output;
    }

    // This function stops a process by its PID
    public function stopProcess($pid) {
        if (!$this->isProcessRunning($pid)) {
            throw new Exception('Process not found.');
        }

        // Send a SIGTERM signal to the process
        posix_kill($pid, SIGTERM);
    }

    // This function checks if a process is running by its PID
    private function isProcessRunning($pid) {
        $output = [];
        exec('ps -p ' . escapeshellarg($pid) . ' | grep -v grep', $output);
        return count($output) > 0;
    }
}
