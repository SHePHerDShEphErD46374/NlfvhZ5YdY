<?php
// 代码生成时间: 2025-09-17 17:22:02
// 用户登录验证系统
// 使用CAKEPHP框架实现

use Cake\Http\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validation;
use Cake\Controller\Controller;
use Cake\Controller\RequestHandler;
use Cake\Controller\Exception\NotFoundException;
use Cake\Auth\Auth;
use Cake\Auth\AbstractAuthentication;
use Cake\Auth\FormAuthenticate;
use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\Router;
use Cake\Datasource\Exception\RecordNotFoundException;

class UserLoginController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        // 加载认证组件
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ],
                    'userModel' => 'Users',
                    'scope' => [
                        'active' => 1,
                    ],
                ],
            ],
            'loginAction' => [
                'controller' => 'UserLogin',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'controller' => 'Dashboard',
                'action' => 'index',
            ],
            'logoutRedirect' => [
                'controller' => 'UserLogin',
                'action' => 'login',
            ],
            'unauthorizedRedirect' => [
                'controller' => 'UserLogin',
                'action' => 'login',
            ],
        ]);
    }

    // 登录页面
    public function login()
    {
        if ($this->request->is('post')) {
            // 验证用户登录信息
            $user = $this->Auth->identify();

            if ($user) {
                // 认证成功，自动重定向到登录重定向页面
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                // 认证失败，设置错误消息
                $this->Flash->error(__('Invalid username or password'));
            }
        }
    }

    // 注销功能
    public function logout()
    {
        $this->Flash->success(__('You are now logged out.'));
        return $this->redirect($this->Auth->logout());
    }
}

// 用户模型
class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // 设置用户模型的字段
        $this->addBehavior('Timestamp');
    }

    // 验证用户信息
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmpty('email', __('Email cannot be empty'))
            ->email('email', __('Email is invalid'))
            ->notEmpty('password', __('Password cannot be empty'))
            ->add('password', 'length', [
                'rule' => ['minLength', 8],
                'message' => __('Password must be at least 8 characters long')
            ]);

        return $validator;
    }
}

// 认证类
class AppAuthenticator extends FormAuthenticate
{
    // 自定义认证方法
    protected function _findUser($username)
    {
        // 根据用户名查找用户
        $query = $this->getQuery($this->settings['userModel'], ['email' => $username]);

        return $this->_table->find()
            ->where($query)
            ->first();
    }
}

// CAKEPHP路由配置
Router::scope('/user', function (RouteBuilder $builder) {
    $builder->connect('/login', ['controller' => 'UserLogin', 'action' => 'login']);
    $builder->connect('/logout', ['controller' => 'UserLogin', 'action' => 'logout']);
});

// 使用的插件
// CakePHP核心插件
// AuthComponent, FormAuthenticate, FlashComponent
