<?php
// 代码生成时间: 2025-10-10 03:48:54
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Exception\ForbiddenException;
use Cake\Routing\Router;

class ApprovalProcessController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('approvalProcesses', $this->ApprovalProcess->find()->all());
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Renders view for adding a new approval process or redirects to index.
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $approvalProcess = $this->ApprovalProcess->newEntity($this->request->getData());
            if ($this->ApprovalProcess->save($approvalProcess)) {
                $this->Flash->success(__('The approval process has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The approval process could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id ApprovalProcess id.
     * @return \Cake\Http\Response|null|void Redirects to index or renders view for editing an existing approval process.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $approvalProcess = $this->ApprovalProcess->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $approvalProcess = $this->ApprovalProcess->patchEntity($approvalProcess, $this->request->getData(), ['validate' => 'default']);
            if ($this->ApprovalProcess->save($approvalProcess)) {
                $this->Flash->success(__('The approval process has been updated.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The approval process could not be updated. Please, try again.'));
            }
        }
        if (empty($approvalProcess)) {
            throw new NotFoundException(__('Not Found'));
        }
        $this->set(compact('approvalProcess'));
    }

    /**
     * Delete method
     *
     * @param string|null $id ApprovalProcess id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $approvalProcess = $this->ApprovalProcess->get($id);
        if ($this->ApprovalProcess->delete($approvalProcess)) {
            $this->Flash->success(__('The approval process has been deleted.'));
        } else {
            $this->Flash->error(__('The approval process could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
