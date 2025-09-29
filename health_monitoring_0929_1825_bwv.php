<?php
// 代码生成时间: 2025-09-29 18:25:30
// HealthMonitoring.php
// 这个类代表一个健康监测设备，用于记录和检索健康数据

use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Validation\Validation;
use Cake\Core\Exception\Exception;

class HealthMonitoring {

    private Table $healthData;

    public function __construct() {
        // 初始化健康数据表
        $this->healthData = TableRegistry::getTableLocator()->get('HealthData');
    }

    // 添加健康数据
    public function addHealthData(array $data): bool {
        try {
            // 验证数据
            $validation = Validation::build();
            $validation->add('value', 'valid', [
                'rule' => 'float',
                'message' => 'Value must be a valid number.'
            ]);
            if (!$validation->validate($data)) {
                throw new Exception('Invalid data provided.');
            }

            // 保存数据
            $entity = $this->healthData->newEntity($data);
            if (!$this->healthData->save($entity)) {
                throw new Exception('Failed to save health data.');
            }
            return true;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return false;
        }
    }

    // 获取健康数据
    public function getHealthData(int $id): ?array {
        try {
            $entity = $this->healthData->get($id);
            if ($entity) {
                return $entity->toArray();
            }
            throw new RecordNotFoundException('Health data not found.');
        } catch (RecordNotFoundException $e) {
            // 错误处理
            error_log($e->getMessage());
            return null;
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return null;
        }
    }

    // 获取所有健康数据
    public function getAllHealthData(): array {
        try {
            $entities = $this->healthData->find('all');
            return $entities->toArray();
        } catch (Exception $e) {
            // 错误处理
            error_log($e->getMessage());
            return [];
        }
    }
}
