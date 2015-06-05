<?php

/*
 * 后台用户管理控制器
 */

class UserAction extends CommonAction {
    /*
     * 用户列表
     */

    public function index() {
        $User = M('User');
        $where = array();
        $data['numPerPage'] = (int) $this->_post('numPerPage', "", 10); //每页显示多少条
        $data['currentPage'] = (int) $this->_post('pageNum', "", 1); //当前页
        $data['keywords'] = $this->_post('keywords'); //查询关键字
        if (!empty($data['keywords'])) {
            $map['account'] = array('like', '%' . $data['keywords'] . '%');
            $map['nickname'] = array('like', '%' . $data['keywords'] . '%');
            $map['email'] = array('like', '%' . $data['keywords'] . '%');
            $map['_logic'] = 'or';
            $where['_complex'] = $map;
        }
        $data['totalCount'] = $User->where($where)->count();
        $list = $User->where($where)->page(($data['currentPage']) . ',' . $data['numPerPage'])->field('id,account,nickname,email,last_login_time,last_login_ip,login_count,create_time,status')->order('create_time desc')->select();
        
       //得到用户所属组(角色)
        if ($list)
        {
            foreach ($list as $k => $v) {
                $user_id = $list[$k]['id'];
                //得到角色名称
                $sql = 'SELECT r.name FROM ' . C("DB_PREFIX") . 'role_user AS u LEFT JOIN ' . C("DB_PREFIX") . 'role AS r ON u.role_id=r.id  WHERE u.user_id=' . $user_id;
                $re = M()->query($sql);
                $role_list = array();
                
                foreach ($re as $value) {
                    $role_list[] = $value['name'];
                }
                $list[$k]['role_list'] = join("|", $role_list);
            }
            
        }
        $data['list'] = & $list;
        
        $this->assign($data);
        $this->display();
    }

    /*
     * 用户添加
     */

    public function add() {
        if ($_POST) {
            $User = D('User');
            if ($data = $User->create()) {
                if ($User->add()) {
                    ajaxReturn(200, '添加用户成功', 'user', 'User/index');
                } else {
                    ajaxReturn(300, '添加用户失败:' . $User->getDbError());
                }
            } else {
                ajaxReturn(300, "错误：" . $User->getError());
            }
        } else {
            $this->display();
        }
    }

    /*
     * 用户编辑
     */

    public function edit() {
        $User = M('User'); //初始化用户模型
        if ($_POST) {
            $data['id'] = $this->_post('uid');
            $data['nickname'] = $this->_post('nickname');
            if (!empty($_POST['password'])) {
                $data['password'] = md5(trim($_POST['password']));
            }
            $data['email'] = $this->_post('email');
            $data['remark'] = $this->_post('remark');
            $data['status'] = $this->_post('status');
            empty($data['id']) && ajaxReturn(300, "请指定要修改的用户");
            if ($data['id'] == 1 && $data['status'] != 1) {
                ajaxReturn(300, "超级管理员不能禁用");
            }
            if ($User->save($data)) {
                ajaxReturn(200, '修改用户成功', 'user', 'User/index');
            } else {
                ajaxReturn(300, "修改用户失败");
            }
        } else {
            $uid = $this->_get('uid');
            if (empty($uid)) {
                ajaxReturn(300, "请选择要编辑的用户");
            } else {
                $data['data'] = $User->find($uid);
                $this->assign($data);
                $this->display();
            }
        }
    }

    /*
     * 用户信息查看
     */

    public function view() {
        $uid = $this->_get('uid');
        if (empty($uid)) {
            ajaxReturn(300, "请选择要查看的用户");
        } else {
            $User = D('User');
            $data['data'] = $User->find($uid);
            $this->assign($data);
            $this->display();
        }
    }

    /*
     * 修改用户状态
     */

    public function c_status() {
        $data['id'] = $this->_get('uid');
        $data['status'] = $this->_get('act');
        if ($data['id'] == 1) {
            ajaxReturn(300, "超级管理员不能禁用");
        }
        $User = M('User');
        if ($User->save($data)) {
            ajaxReturn(200, $data['status'] == 1 ? "激活成功" : "锁定成功", "user", "User/index", "forward");
        } else {
            ajaxReturn(300, "操作失败");
        }
    }

    /*
     * 用户删除
     */

    public function del() {
        $uid = $this->_get('uid');
        $uid == 1 && ajaxReturn(300, "超级管理员不能删除");
        if (empty($uid)) {
            ajaxReturn(300, "请指定要删除的用户");
        } else {
            $User = M('User');
            if ($User->where(array('id' => $uid))->delete()) {
                ajaxReturn(200, '删除用户成功', 'user', 'User/index');
            } else {
                ajaxReturn(300, "删除用户失败");
            }
        }
    }

    /*
     * 批量删除
     */

    public function batchdel() {
        $ids = $this->_post('ids');
        if (!empty($ids)) {
        	//检测是否删除超级管理员
        	$idarr	=	explode(',', $ids );
        	in_array( 1 , $idarr ) && ajaxReturn(300, "超级管理员不能删除");
            $User = M('User');
            if ($User->where('id in (' . $ids . ')')->delete()) {
                ajaxReturn(200, "批量删除用户成功", "user", 'User/index', "forward");
            } else {
                ajaxReturn(300, "删除用户错误:" . $User->getDbError());
            }
        } else {
            ajaxReturn(300, "请选择要删除的用户");
        }
    }

    /*
     * 用户所属角色编辑
     */
   /*暂时不启用。去角色管理中去针对角色添加用户可以实现同样效果
    public function RoleEdit() {

        if (!isset($_REQUEST['uid']))
            ajaxReturn(300, "没有传递用户编号");

        $user_id = trim($_REQUEST['uid']);
        $map['id'] = array('eq', $user_id);
        $User = M('User');
        $user_info = $User->where($map)->find();
        if (false === $user_info)
            ajaxReturn(300, "用户编号错误，该用户不存在:" . $user_id);
        
        
        //超级管理员不需要编辑权限
        if($user_info['account']=='admin') ajaxReturn(300, "你编辑的是超级管理员,具有最大权限,不需要控制权限");

        $data['user_info'] = $user_info;

        //获取当前用户所属角色列表
        $sql = 'SELECT r.name,r.id FROM ' . C("DB_PREFIX") . 'role_user AS u LEFT JOIN ' . C("DB_PREFIX") . 'role AS r ON u.role_id=r.id  WHERE u.user_id=' . $user_id;
        $list = M()->query($sql);

        //重组数据格式，用于，修改页面checkbox勾选判断
        /////////////////////////////////////////////////////
        $user_role_list = array();

        if ($list) {
            foreach ($list as $k => $v) {
                $user_role_list[$v['id']] = $v['name'];
            }

            $data['user_role_list'] = & $user_role_list;

            unset($user_role_list);

            //用于比较交集，差集使用
            foreach ($list as $k => $v) {
                $user_role_list[] = $v['id'];
            }

            unset($list);
        }

        /////////////////////////////////////////////////////





        if (isset($_POST['doEdit'])) {
            //提交修改

            $role_list = $_POST['role_list'];

            if (empty($user_role_list) && !empty($role_list)) { //数据库中并没有设置过角色，全部为insert
                foreach ($role_list as $role_id) {
                    $add = array(
                        'user_id' => $user_id,
                        'role_id' => $role_id
                    );
                    M('Role_user')->add($add);
                }//end foreach
            } else if (empty($role_list)) {
                //勾掉所有的，全部delete 
                M('Role_user')->where('user_id=' . $user_id)->delete();
            } else {

                $delete_ids = array_diff($user_role_list, $role_list);
                
                if(!empty($delete_ids) )
                {
                    $where = 'user_id=' . $user_id.' AND role_id IN('.join(',',$delete_ids).')';
                    M('Role_user')->where($where)->delete();
                }
                
                //计算需要insert的值
                $intersect = array_intersect($user_role_list, $role_list);
                $insert_ids = array_diff($role_list, $intersect);   //不存在交集时$intersect为空。此时$assign_user数组全部插入
                
                if(!empty($insert_ids) )
                {
                    foreach ($insert_ids as $role_id) {
                    $add = array(
                        'user_id' => $user_id,
                        'role_id' => $role_id
                    );
                    M('Role_user')->add($add);
                    }//end foreach
                }

            }
            
             ajaxReturn(200, "编辑成功", "user", 'User/index');
        } else {
            //显示修改页面
            //所有角色
            $sql = 'SELECT name,id FROM ' . C("DB_PREFIX") . 'role ';
            $all_role_list = M()->query($sql);
            $data['all_role_list'] = $all_role_list;
            $data['todo'] = 'doEdit'; //隐藏域，修改的判断依据,参看doEdit方法
            $this->assign($data);
            $this->display('User:Role');
        }
    }
    */

}